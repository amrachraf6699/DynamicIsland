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
    protected array $filterable = [];
    protected array $sortable = ['id', 'created_at', 'updated_at', 'order'];
    protected array $booleanAttributes = ['is_active', 'is_featured', 'requestable'];
    protected array $fileAttributes = [];
    protected array $createValidationRules = [];
    protected array $updateValidationRules = [];
    protected array $formSchema = [];
    protected int $perPage = 15;
    protected ?string $resourceLabel = null;
    protected array $indexColumns = [];

    public function __construct()
    {
        if (! isset($this->resourceName, $this->model)) {
            throw new \InvalidArgumentException(static::class . ' must define $resourceName and $model.');
        }

        // Attach CRUD permission middleware per resource
        $this->middleware('can:' . $this->permissionName('read'))->only(['index']);
        $this->middleware('can:' . $this->permissionName('create'))->only(['create', 'store']);
        $this->middleware('can:' . $this->permissionName('update'))->only(['edit', 'update']);
        $this->middleware('can:' . $this->permissionName('delete'))->only(['destroy', 'bulkDestroy']);
    }

    protected function permissionName(string $action): string
    {
        return sprintf('%s.%s', $this->resourceName, $action);
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
            'filters' => $this->filterDefinitions(),
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
            'requiredFields' => $this->requiredFields($this->createValidationRules),
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
            'requiredFields' => $this->requiredFields($this->updateValidationRules),
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

        $this->deleteAttachedFiles($item);

        $item->delete();

        return redirect()
            ->route($this->routeName('index'))
            ->with('success', __('تم حذف :resource بنجاح.', ['resource' => $this->resourceLabel()]));
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['nullable'],
        ]);

        $ids = collect($validated['ids'])
            ->filter(fn ($id) => filled($id))
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return back()->with('error', 'الرجاء اختيار عنصر واحد على الأقل.');
        }

        $model = $this->makeModel();
        $keyName = $model->getKeyName();

        $items = $model->newQuery()->whereIn($keyName, $ids)->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'العناصر المحددة غير متاحة.');
        }

        foreach ($items as $item) {
            $this->deleteAttachedFiles($item);
            $item->delete();
        }

        return redirect()
            ->route($this->routeName('index'))
            ->with('success', 'تم حذف العناصر المحددة بنجاح.');
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

        foreach ($this->filterDefinitions() as $filter) {
            $attribute = $filter['key'];
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

    protected function deleteAttachedFiles(Model $item): void
    {
        foreach ($this->fileAttributes as $attribute => $disk) {
            if (is_string($attribute)) {
                $field = $attribute;
                $diskName = is_string($disk) ? $disk : 'public';
            } else {
                $field = $disk;
                $diskName = 'public';
            }

            if (! empty($item->{$field})) {
                $this->deleteFile($item->{$field}, $diskName);
            }
        }
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
        if (!empty($this->indexColumns)) {
            return $this->indexColumns;
        }

        $routeName = "admin.{$this->resourceName}.index";
        $resource = collect(config('admin.resources', []))->firstWhere('route', $routeName);
        if (is_array($resource) && isset($resource['columns']) && is_array($resource['columns'])) {
            $columns = [];
            foreach ($resource['columns'] as $col) {
                if (is_string($col)) {
                    $parts = explode(':', $col, 2);
                    $key = $parts[0];
                    $type = $parts[1] ?? null;
                    $entry = [
                        'key' => $key,
                        'label' => \Illuminate\Support\Str::headline($key),
                    ];
                    if ($type) { $entry['type'] = $type; }
                    $columns[] = $entry;
                } elseif (is_array($col)) {
                    $entry = [
                        'key' => $col['key'] ?? 'id',
                        'label' => $col['label'] ?? \Illuminate\Support\Str::headline($col['key'] ?? 'id'),
                    ];
                    if (isset($col['type'])) { $entry['type'] = $col['type']; }
                    if (isset($col['sortable'])) { $entry['sortable'] = (bool) $col['sortable']; }
                    $columns[] = $entry;
                }
            }
            if (!empty($columns)) {
                return $columns;
            }
        }

        return [ ['key' => 'id', 'label' => '#'] ];
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

    protected function filterDefinitions(): array
    {
        $definitions = [];

        foreach ($this->filterable as $key => $value) {
            if (is_string($value)) {
                $definitions[] = [
                    'key' => $value,
                    'label' => $value,
                    'type' => 'text',
                    'options' => [],
                ];
                continue;
            }

            if (is_array($value)) {
                $definitions[] = [
                    'key' => $key,
                    'label' => $value['label'] ?? $key,
                    'type' => $value['type'] ?? 'text',
                    'options' => $value['options'] ?? [],
                ];
            }
        }

        return $definitions;
    }

    protected function requiredFields(array $rules): array
    {
        $required = [];

        foreach ($rules as $attribute => $rule) {
            if (is_string($rule)) {
                $segments = explode('|', $rule);
                if (in_array('required', $segments, true)) {
                    $required[] = $attribute;
                }
            } elseif (is_array($rule)) {
                if (in_array('required', $rule, true)) {
                    $required[] = $attribute;
                }
            }
        }

        return $required;
    }
}

