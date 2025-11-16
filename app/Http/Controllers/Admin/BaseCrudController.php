<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

abstract class BaseCrudController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Fully qualified model class name.
     */
    protected string $model;

    /**
     * Resource slug used for permissions and routes.
     */
    protected string $resourceName;

    /**
     * Blade path prefix, e.g. admin.services.
     */
    protected string $viewPath = 'admin.resources';

    protected array $withRelations = [];
    protected array $searchable = ['id', 'title', 'name'];
    protected array $filterable = ['is_active'];
    protected array $sortable = ['id', 'created_at', 'updated_at', 'order'];
    protected array $booleanAttributes = ['is_active', 'is_featured', 'requestable'];
    protected array $fileAttributes = [];
    protected array $createValidationRules = [];
    protected array $updateValidationRules = [];
    protected array $formSchema = [];
    protected int $perPage = 15;
    protected ?string $resourceLabel = null;

    public function __construct()
    {
        if (! isset($this->resourceName, $this->model)) {
            throw new \InvalidArgumentException(static::class . ' must define $resourceName and $model.');
        }
    }

    public function index(Request $request): Renderable
    {
        $items = $this->buildIndexQuery($request)->paginate(
            $request->integer('per_page', $this->perPage)
        )->withQueryString();

        return view("{$this->viewPath}.index", [
            'resourceName' => $this->resourceName,
            'resourceLabel' => $this->resourceLabel(),
            'items' => $items,
            'columns' => $this->getIndexColumns(),
            'filters' => $this->filterable,
            'formSchema' => $this->formSchema,
        ]);
    }

    public function create(): Renderable
    {
        $item = $this->makeModel();

        return view("{$this->viewPath}.form", [
            'resourceName' => $this->resourceName,
            'resourceLabel' => $this->resourceLabel(),
            'formSchema' => $this->formSchema($item),
            'item' => $item,
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request, $this->createValidationRules);
        $item = $this->makeModel()->create($data);

        return redirect()
            ->route($this->routeName('index'))
            ->with('success', __('تمت إضافة :resource بنجاح.', ['resource' => $this->resourceLabel()]));
    }

    public function edit($id): Renderable
    {
        $item = $this->findModel($id);

        return view("{$this->viewPath}.form", [
            'resourceName' => $this->resourceName,
            'resourceLabel' => $this->resourceLabel(),
            'formSchema' => $this->formSchema($item),
            'item' => $item,
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = $this->findModel($id);
        $data = $this->validatedData($request, $this->updateValidationRules, $item);
        $item->update($data);

        return redirect()
            ->route($this->routeName('index'))
            ->with('success', __('تم تحديث :resource بنجاح.', ['resource' => $this->resourceLabel()]));
    }

    public function destroy($id)
    {
        $item = $this->findModel($id);

        foreach ($this->fileAttributes as $attribute) {
            $this->deleteFile($item->{$attribute});
        }

        $item->delete();

        return redirect()
            ->route($this->routeName('index'))
            ->with('success', __('تم حذف :resource بنجاح.', ['resource' => $this->resourceLabel()]));
    }

    protected function buildIndexQuery(Request $request): Builder
    {
        $query = $this->makeModel()->newQuery()->with($this->withRelations);

        if ($search = $request->string('search')->trim()) {
            $query->where(function (Builder $builder) use ($search) {
                foreach ($this->searchable as $column) {
                    $builder->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        foreach ($this->filterable as $attribute) {
            if ($request->filled($attribute)) {
                $query->where($attribute, $request->input($attribute));
            }
        }

        $sort = $request->string('sort')->toString() ?: 'created_at';
        $direction = $request->string('direction')->toString() ?: 'desc';

        if (! in_array($sort, $this->sortable, true)) {
            $sort = 'created_at';
        }

        $query->orderBy($sort, $direction === 'asc' ? 'asc' : 'desc');

        return $query;
    }

    protected function validatedData(Request $request, array $rules, ?Model $item = null): array
    {
        $rules = $this->resolveUniqueRules($rules, $item);
        $data = $this->validate($request, $rules);
        $data = $this->mapBooleanAttributes($data);

        return $this->handleUploads($request, $data, $item);
    }

    protected function resolveUniqueRules(array $rules, ?Model $item = null): array
    {
        if (! $item) {
            return $rules;
        }

        foreach ($rules as $attribute => $rule) {
            if (is_array($rule)) {
                $rules[$attribute] = array_map(
                    fn ($r) => $this->tweakUniqueRule($r, $item, $attribute),
                    $rule
                );
            } else {
                $rules[$attribute] = $this->tweakUniqueRule($rule, $item, $attribute);
            }
        }

        return $rules;
    }

    protected function tweakUniqueRule($rule, Model $item, string $attribute)
    {
        if (is_string($rule) && str_contains($rule, 'unique:')) {
            [$definition] = explode('|', $rule);
            $segments = explode(',', $definition);
            if (count($segments) >= 2) {
                $table = explode(':', $segments[0])[1] ?? $item->getTable();
                $column = $segments[1] ?: $attribute;

                return str_replace(
                    $definition,
                    sprintf('unique:%s,%s,%s', $table, $column, $item->getKey()),
                    $rule
                );
            }
        }

        return $rule;
    }

    protected function mapBooleanAttributes(array $data): array
    {
        foreach ($this->booleanAttributes as $attribute) {
            if (array_key_exists($attribute, $data)) {
                $data[$attribute] = (bool) $data[$attribute];
            }
        }

        return $data;
    }

    protected function handleUploads(Request $request, array $data, ?Model $item = null): array
    {
        foreach ($this->fileAttributes as $attribute => $disk) {
            $disk = is_string($disk) ? $disk : 'public';

            if ($request->hasFile($attribute)) {
                if ($item && $item->{$attribute}) {
                    Storage::disk($disk)->delete($item->{$attribute});
                }

                $path = $request->file($attribute)->store($this->resourceName, $disk);
                $data[$attribute] = $path;
            } elseif ($request->boolean("remove_{$attribute}") && $item && $item->{$attribute}) {
                Storage::disk($disk)->delete($item->{$attribute});
                $data[$attribute] = null;
            }
        }

        return $data;
    }

    protected function deleteFile(?string $path, string $disk = 'public'): void
    {
        if ($path) {
            Storage::disk($disk)->delete($path);
        }
    }

    protected function makeModel(): Model
    {
        return app($this->model);
    }

    protected function findModel($id): Model
    {
        return $this->makeModel()->newQuery()->with($this->withRelations)->findOrFail($id);
    }

    protected function routeName(string $action): string
    {
        return "admin.{$this->resourceName}.{$action}";
    }

    protected function getIndexColumns(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'title', 'label' => 'العنوان'],
            ['key' => 'is_active', 'label' => 'مفعل'],
            ['key' => 'created_at', 'label' => 'تاريخ الإنشاء'],
        ];
    }

    protected function resourceLabel(): string
    {
        if ($this->resourceLabel) {
            return $this->resourceLabel;
        }

        $routeName = "admin.{$this->resourceName}.index";

        $label = collect(config('admin.resources', []))
            ->firstWhere('route', $routeName)['label'] ?? $this->resourceName;

        return $this->resourceLabel = $label;
    }

    protected function formSchema(?Model $item = null): array
    {
        return $this->formSchema;
    }
}
