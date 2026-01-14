<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseCrudController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleCrudController extends BaseCrudController
{
    protected string $model = Role::class;
    protected string $resourceName = 'roles';
    protected ?string $resourceLabel = 'الأدوار';

    protected array $createValidationRules = [
        'name' => ['required', 'string', 'max:255', 'unique:roles,name'],'permissions' => ['array'],
        'permissions.*' => ['string'],
    ];

    protected array $updateValidationRules = [
        'name' => ['required', 'string', 'max:255', 'unique:roles,name'],'permissions' => ['array'],
        'permissions.*' => ['string'],
    ];

    protected function getIndexColumns(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'الاسم'],
            ['key' => 'created_at', 'label' => 'تاريخ الإنشاء'],
        ];
    }

    protected function formSchema(?\Illuminate\Database\Eloquent\Model $item = null): array
    {
        // Not used: we render a custom form for roles to show grouped toggles
        return [
            ['name' => 'name', 'label' => 'الاسم', 'type' => 'text'],
            ];
    }

    public function create(): Renderable
    {
        $role = new Role();
        [$groups, $all] = $this->permissionsCatalog();
        return view('admin.roles.form', compact('role', 'groups', 'all'));
    }

    public function edit($id): Renderable
    {
        $role = Role::findOrFail($id);
        [$groups, $all] = $this->permissionsCatalog();
        $assigned = $role->permissions->pluck('name')->all();
        return view('admin.roles.form', compact('role', 'groups', 'all', 'assigned'));
    }

    protected function permissionsCatalog(): array
    {
        $resourceLabels = [
            'page-groups' => 'مجموعات الصفحات',
            'pages' => 'الصفحات',
            'services' => 'الخدمات',
            'projects' => 'المشاريع',
            'testimonials' => 'آراء العملاء',
            'sliders' => 'السلايدر',
            'team-members' => 'أعضاء الفريق',
            'blog-sections' => 'أقسام المدونة',
            'blogs' => 'المقالات',
            'statistics' => 'الإحصائيات',
            'job-postings' => 'الوظائف',
            'gallery-sections' => 'أقسام المعرض',
            'galleries' => 'المعرض',
            'partners' => 'الشركاء',
            'awards' => 'الجوائز',
            'settings' => 'الإعدادات',
            'roles' => 'الأدوار',
            'users' => 'المستخدمون',
        ];

        $actionLabels = [
            'create' => 'إنشاء',
            'read' => 'عرض',
            'update' => 'تعديل',
            'delete' => 'حذف',
            'update' => 'تعديل',
        ];

        $permissions = Permission::query()->orderBy('name')->get();
        $all = $permissions->pluck('name')->values()->all();
        $groups = [];
        foreach ($permissions as $perm) {
            $name = $perm->name;
            [$res, $act] = array_pad(explode('.', $name, 2), 2, null);
            $resKey = $res ?: 'misc';
            $resLabel = $resourceLabels[$resKey] ?? $resKey;
            $actionLabel = $actionLabels[$act] ?? $act;
            if (!isset($groups[$resKey])) {
                $groups[$resKey] = [
                    'key' => $resKey,
                    'label' => $resLabel,
                    'permissions' => [],
                ];
            }
            $groups[$resKey]['permissions'][] = [
                'name' => $name,
                'label' => $actionLabel,
                'action' => $act,
            ];
        }
        // Sort groups by label
        uasort($groups, fn($a, $b) => strcmp($a['label'], $b['label']));
        return [array_values($groups), $all];
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request, $this->createValidationRules);
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($permissions);

        return redirect()->route($this->routeName('index'))
            ->with('success', 'تم إنشاء الدور بنجاح');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $data = $this->validatedData($request, $this->updateValidationRules, $role);
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role->update([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);
        $role->syncPermissions($permissions);

        return redirect()->route($this->routeName('index'))
            ->with('success', 'تم تحديث الدور بنجاح');
    }
}
