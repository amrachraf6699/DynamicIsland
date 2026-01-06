<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\PageGroup;
use Illuminate\Database\Eloquent\Model;

class PageController extends BaseCrudController
{
    protected string $model = Page::class;
    protected string $resourceName = 'pages';
    protected array $searchable = ['id', 'title', 'slug'];
    protected array $filterable = [
        'is_active' => [
            'label' => 'الحالة',
            'type' => 'boolean',
            'options' => [
                '1' => 'مفعل',
                '0' => 'معطل',
            ],
        ],
        'visitable' => [
            'label' => 'قابل للزيارة',
            'type' => 'boolean',
            'options' => [
                '1' => 'قابل للزيارة',
                '0' => 'غير قابل للزيارة',
            ],
        ],
    ];
    protected array $sortable = ['id', 'title', 'order', 'created_at'];
    protected array $fileAttributes = ['cover' => 'public'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'page_group_id' => ['nullable', 'exists:page_groups,id'],
        'parent_id' => ['nullable', 'exists:pages,id'],
        'order' => ['nullable', 'integer'],
        'cover' => ['nullable', 'image'],
        'is_active' => ['nullable', 'boolean'],
        'visitable' => ['nullable', 'boolean'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'page_group_id' => ['nullable', 'exists:page_groups,id'],
        'parent_id' => ['nullable', 'exists:pages,id'],
        'order' => ['nullable', 'integer'],
        'cover' => ['nullable', 'image'],
        'is_active' => ['nullable', 'boolean'],
        'visitable' => ['nullable', 'boolean'],
    ];

    protected function formSchema(?Model $item = null): array
    {
        $groups = PageGroup::query()->orderBy('title')->pluck('title', 'id')->toArray();
        $pages = Page::query()->orderBy('title')->pluck('title', 'id')->toArray();
        return [
            ['type' => 'text', 'name' => 'title', 'label' => 'عنوان الصفحة', 'colspan' => 2, 'group' => 'البيانات الأساسية'],
            [
                'type' => 'select',
                'name' => 'page_group_id',
                'label' => 'مجموعة الصفحة',
                'props' => [
                    'options' => $groups,
                    'placeholder' => 'اختر مجموعة',
                ],
                'group' => 'البيانات الأساسية',
            ],
            [
                'type' => 'select',
                'name' => 'parent_id',
                'label' => 'الصفحة الأب',
                'props' => [
                    'options' => $pages,
                    'placeholder' => 'اختر صفحة',
                ],
                'group' => 'البيانات الأساسية',
            ],
            ['type' => 'file', 'name' => 'cover', 'label' => 'صورة الغلاف', 'colspan' => 2, 'group' => 'الوسائط'],
            ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number'], 'group' => 'البيانات الأساسية'],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّلة', 'group' => 'الإعدادات'],
            ['type' => 'toggle', 'name' => 'visitable', 'label' => 'قابلة للزيارة', 'group' => 'الإعدادات'],
        ];
    }
}
