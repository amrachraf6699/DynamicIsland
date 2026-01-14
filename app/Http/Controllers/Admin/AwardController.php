<?php

namespace App\Http\Controllers\Admin;

use App\Models\Award;

class AwardController extends BaseCrudController
{
    protected string $model = Award::class;
    protected string $resourceName = 'awards';
    protected array $searchable = ['id', 'title', 'organization'];
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
    protected array $sortable = ['id', 'title', 'order', 'awarded_at', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'is_featured'];
    protected array $fileAttributes = ['image' => 'public'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'organization' => ['nullable', 'string', 'max:255'],
        'awarded_at' => ['nullable', 'date'],
        'image' => ['nullable', 'image'],
        'link' => ['nullable', 'url'],
        'description' => ['nullable', 'string'],
        'order' => ['required', 'integer'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'organization' => ['nullable', 'string', 'max:255'],
        'awarded_at' => ['nullable', 'date'],
        'image' => ['nullable', 'image'],
        'link' => ['nullable', 'url'],
        'description' => ['nullable', 'string'],
        'order' => ['required', 'integer'],
    ];
                protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'عنوان الجائزة', 'colspan' => 2, 'group' => 'البيانات الأساسية'],
        ['type' => 'text', 'name' => 'organization', 'label' => 'الجهة المانحة', 'group' => 'البيانات الأساسية'],
        ['type' => 'text', 'name' => 'awarded_at', 'label' => 'تاريخ التكريم', 'props' => ['type' => 'date'], 'group' => 'البيانات الأساسية'],
        ['type' => 'file', 'name' => 'image', 'label' => 'صورة الجائزة', 'group' => 'الوسائط'],
        ['type' => 'text', 'name' => 'link', 'label' => 'الرابط', 'colspan' => 2, 'group' => 'الروابط'],
        ['type' => 'textarea', 'name' => 'description', 'label' => 'الوصف', 'colspan' => 2, 'group' => 'الوصف'],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number'], 'group' => 'البيانات الأساسية'],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز', 'group' => 'الإعدادات'],
    ];
}
