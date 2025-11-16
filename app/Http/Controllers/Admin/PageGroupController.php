<?php

namespace App\Http\Controllers\Admin;

use App\Models\PageGroup;

class PageGroupController extends BaseCrudController
{
    protected string $model = PageGroup::class;
    protected string $resourceName = 'page-groups';
    protected array $searchable = ['id', 'title', 'position'];
    protected array $filterable = ['is_active'];
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
        ['type' => 'text', 'name' => 'title', 'label' => 'العنوان', 'colspan' => 2],
        [
            'type' => 'select',
            'name' => 'position',
            'label' => 'موضع الظهور',
            'props' => [
                'options' => [
                    'navbar' => 'الشريط العلوي',
                    'footer' => 'تذييل الموقع',
                    'both' => 'كلاهما',
                ],
            ],
        ],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
    ];
}
