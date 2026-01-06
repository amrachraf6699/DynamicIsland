<?php

namespace App\Http\Controllers\Admin;

use App\Models\PageGroup;

class PageGroupController extends BaseCrudController
{
    protected string $model = PageGroup::class;
    protected string $resourceName = 'page-groups';
    protected array $searchable = ['id', 'title', 'position'];
    protected array $filterable = [
        'is_active' => [
            'label' => 'الحالة',
            'type' => 'boolean',
            'options' => [
                '1' => 'مفعل',
                '0' => 'معطل',
            ],
        ],
    ];
    protected array $sortable = ['id', 'title', 'position', 'created_at'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'position' => ['required', 'in:navbar,footer,both'],
        'is_active' => ['nullable', 'boolean'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'position' => ['required', 'in:navbar,footer,both'],
        'is_active' => ['nullable', 'boolean'],
    ];
                    protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'عنوان المجموعة', 'colspan' => 2, 'group' => 'البيانات الأساسية'],
        [
            'type' => 'select',
            'name' => 'position',
            'label' => 'مكان الظهور',
            'props' => [
                'options' => [
                    'navbar' => 'القائمة العلوية',
                    'footer' => 'تذييل الموقع',
                    'both' => 'كلاهما',
                ],
            ],
            'group' => 'البيانات الأساسية',
        ],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
    ];
}
