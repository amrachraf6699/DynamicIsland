<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogSection;

class BlogSectionController extends BaseCrudController
{
    protected string $model = BlogSection::class;
    protected string $resourceName = 'blog-sections';
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
        'is_featured' => [
            'label' => 'مميز',
            'type' => 'boolean',
            'options' => [
                '1' => 'مميز',
                '0' => 'غير مميز',
            ],
        ],
    ];
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
        ['type' => 'text', 'name' => 'title', 'label' => 'عنوان القسم', 'colspan' => 2, 'group' => 'البيانات الأساسية'],
        ['type' => 'textarea', 'name' => 'description', 'label' => 'وصف القسم', 'colspan' => 2, 'group' => 'البيانات الأساسية'],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number'], 'group' => 'البيانات الأساسية'],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز', 'group' => 'الإعدادات'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات الميتا المفتاحية', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
    ];
}
