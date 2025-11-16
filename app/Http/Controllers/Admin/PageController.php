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
    protected array $filterable = ['is_active', 'visitable'];
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
            ['type' => 'text', 'name' => 'title', 'label' => 'العنوان', 'colspan' => 2],
            [
                'type' => 'select',
                'name' => 'page_group_id',
                'label' => 'مجموعة الصفحة',
                'props' => [
                    'options' => $groups,
                    'placeholder' => 'اختر المجموعة',
                ],
            ],
            [
                'type' => 'select',
                'name' => 'parent_id',
                'label' => 'الصفحة الرئيسية',
                'props' => [
                    'options' => $pages,
                    'placeholder' => 'بدون',
                ],
            ],
            ['type' => 'file', 'name' => 'cover', 'label' => 'صورة الغلاف', 'colspan' => 2],
            ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number']],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
            ['type' => 'toggle', 'name' => 'visitable', 'label' => 'متاح للزيارة'],
        ];
    }
}
