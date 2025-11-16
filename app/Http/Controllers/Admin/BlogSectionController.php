<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogSection;

class BlogSectionController extends BaseCrudController
{
    protected string $model = BlogSection::class;
    protected string $resourceName = 'blog-sections';
    protected array $searchable = ['id', 'title', 'slug'];
    protected array $filterable = ['is_active', 'is_featured'];
    protected array $sortable = ['id', 'title', 'order', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'is_featured'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'order' => ['nullable', 'integer'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'order' => ['nullable', 'integer'],
    ];
    protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'عنوان القسم', 'colspan' => 2],
        ['type' => 'textarea', 'name' => 'description', 'label' => 'وصف القسم', 'colspan' => 2],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number']],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان السيو', 'colspan' => 2],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف السيو', 'colspan' => 2],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات مفتاحية', 'colspan' => 2],
    ];
}
