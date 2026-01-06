<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Partial;
use Illuminate\Database\Eloquent\Model;

class PartialController extends BaseCrudController
{
    protected string $model = Partial::class;
    protected string $resourceName = 'partials';
    protected array $searchable = ['id', 'title'];
    protected array $filterable = [];
    protected array $sortable = ['id', 'title', 'created_at'];
    protected array $createValidationRules = [
        'page_id' => ['required', 'exists:pages,id'],
        'title' => ['nullable', 'string', 'max:255'],
        'content' => ['nullable', 'string'],
    ];
    protected array $updateValidationRules = [
        'page_id' => ['required', 'exists:pages,id'],
        'title' => ['nullable', 'string', 'max:255'],
        'content' => ['nullable', 'string'],
    ];

    protected function formSchema(?Model $item = null): array
    {
        $pages = Page::query()->orderBy('title')->pluck('title', 'id')->toArray();
        return [
            [
                'type' => 'select',
                'name' => 'page_id',
                'label' => 'الصفحة',
                'props' => [
                    'options' => $pages,
                    'placeholder' => 'اختر صفحة',
                ],
                'group' => 'البيانات الأساسية',
            ],
            ['type' => 'text', 'name' => 'title', 'label' => 'العنوان', 'group' => 'البيانات الأساسية'],
            ['type' => 'richtext', 'name' => 'content', 'label' => 'المحتوى', 'colspan' => 2, 'group' => 'المحتوى'],
        ];
    }
}
