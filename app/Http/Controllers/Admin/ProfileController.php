<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $roles = method_exists($user, 'getRoleNames') ? $user->getRoleNames() : collect();
        $permissions = method_exists($user, 'getAllPermissions')
            ? $user->getAllPermissions()->pluck('name')->sort()->values()
            : collect();
        $groupedPermissions = $permissions->groupBy(function ($name) {
            $parts = explode('.', $name);
            return $parts[0] ?? 'أخرى';
        });

        $resourceLabels = [
            'page-groups' => 'مجموعات الصفحات',
            'pages' => 'الصفحات',
            'services' => 'الخدمات',
            'projects' => 'المشاريع',
            'testimonials' => 'الشهادات',
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
        ];

        $actionLabels = [
            'create' => 'إنشاء',
            'read' => 'عرض',
            'update' => 'تعديل',
            'delete' => 'حذف',
        ];

        $permissionsLocalized = $permissions
            ->map(function ($perm) use ($resourceLabels, $actionLabels) {
                [$res, $act] = array_pad(explode('.', $perm, 2), 2, null);
                $resourceLabel = $resourceLabels[$res] ?? \Illuminate\Support\Str::headline(str_replace('-', ' ', (string) $res));
                $actionLabel = $actionLabels[$act] ?? $act;
                return [
                    'resource_key' => $res,
                    'resource_label' => $resourceLabel,
                    'action_key' => $act,
                    'action_label' => $actionLabel,
                    'display' => sprintf('%s: %s', $resourceLabel, $actionLabel),
                ];
            })
            ->groupBy('resource_key')
            ->map(function ($group) {
                return [
                    'resource_label' => $group->first()['resource_label'] ?? 'غير معروف',
                    'actions' => $group->pluck('action_label')->unique()->values(),
                ];
            })
            ->values();

        return view('admin.profile.edit', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'groupedPermissions' => $groupedPermissions,
            'permissionsLocalized' => $permissionsLocalized,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
