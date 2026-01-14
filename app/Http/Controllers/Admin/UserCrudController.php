<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseCrudController;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserCrudController extends BaseCrudController
{
    protected string $model = User::class;
    protected string $resourceName = 'users';
    protected ?string $resourceLabel = 'المستخدمون';
    protected string $viewPath = 'admin.users';

    protected array $createValidationRules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'roles' => ['array'],
        'roles.*' => ['string'],
    ];

    protected array $updateValidationRules = [
        'name' => ['required', 'string', 'max:255'],
        // IMPORTANT: the "unique" rule must ignore the current user on update
        'email' => ['required', 'email', 'max:255'],
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        'roles' => ['array'],
        'roles.*' => ['string'],
    ];

    protected function getIndexColumns(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'الاسم'],
            ['key' => 'email', 'label' => 'البريد الإلكتروني'],
            ['key' => 'created_at', 'label' => 'تاريخ الإنشاء'],
        ];
    }

    // Exclude the authenticated user from the listing
    protected function buildIndexQuery(Request $request): Builder
    {
        $query = parent::buildIndexQuery($request);

        if (auth()->check()) {
            $query->where('id', '!=', auth()->id());
        }

        return $query;
    }

    public function index(Request $request): Renderable
    {
        $users = $this->buildIndexQuery($request)->get();
        $roles = Role::query()->orderBy('name')->get();
        $filters = $this->filterDefinitions();
        $resourceName = $this->resourceName;
        $title = $this->resourceLabel();

        return view('admin.users.index', compact('users', 'roles', 'filters', 'resourceName', 'title'));
    }

    public function create(): Renderable
    {
        $user = new User();
        $rolesOptions = Role::query()->orderBy('name')->pluck('name', 'name')->toArray();
        $selectedRoles = [];

        return view('admin.users.form', compact('user', 'rolesOptions', 'selectedRoles'));
    }

    public function edit($id): Renderable
    {
        $user = User::findOrFail($id);
        $rolesOptions = Role::query()->orderBy('name')->pluck('name', 'name')->toArray();
        $selectedRoles = $user->roles()->pluck('name')->all();

        return view('admin.users.form', compact('user', 'rolesOptions', 'selectedRoles'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request, $this->createValidationRules);

        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        // Hash password (important!)
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->syncRoles($roles);

        return redirect()
            ->route($this->routeName('index'))
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Apply "unique" ignoring this user's id
        $rules = $this->updateValidationRules;
        $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email,' . $user->id];

        $data = $this->validatedData($request, $rules, $user);

        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        // If password empty: don't update it. If present: hash it.
        if (empty($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        $user->syncRoles($roles);

        return redirect()
            ->route($this->routeName('index'))
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }
}
