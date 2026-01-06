<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;

class ServiceController extends BaseCrudController
{
    protected string $model = Service::class;
    protected string $resourceName = 'services';
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
        'featured' => [
            'label' => 'مميز',
            'type' => 'boolean',
            'options' => [
                '1' => 'مميز',
                '0' => 'غير مميز',
            ],
        ],
        'requestable' => [
            'label' => 'قابل للطلب',
            'type' => 'boolean',
            'options' => [
                '1' => 'قابل للطلب',
                '0' => 'غير قابل للطلب',
            ],
        ],
    ];
    protected array $sortable = ['id', 'title', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'featured', 'requestable'];
    protected array $fileAttributes = ['cover' => 'public'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'cover' => ['nullable', 'image'],
        'content' => ['required', 'string'],
        'delivery_days' => ['nullable', 'integer', 'min:0'],
        'featured' => ['nullable', 'boolean'],
        'is_active' => ['nullable', 'boolean'],
        'requestable' => ['nullable', 'boolean'],
        'meta_title' => ['nullable', 'string', 'max:255'],
        'meta_description' => ['nullable', 'string', 'max:1000'],
        'meta_keywords' => ['nullable', 'string', 'max:255'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'cover' => ['nullable', 'image'],
        'content' => ['required', 'string'],
        'delivery_days' => ['nullable', 'integer', 'min:0'],
        'featured' => ['nullable', 'boolean'],
        'is_active' => ['nullable', 'boolean'],
        'requestable' => ['nullable', 'boolean'],
        'meta_title' => ['nullable', 'string', 'max:255'],
        'meta_description' => ['nullable', 'string', 'max:1000'],
        'meta_keywords' => ['nullable', 'string', 'max:255'],
    ];
        protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'عنوان الخدمة', 'colspan' => 2, 'group' => 'البيانات الأساسية'],
        ['type' => 'file', 'name' => 'cover', 'label' => 'صورة الغلاف', 'colspan' => 2, 'group' => 'الوسائط'],
        ['type' => 'richtext', 'name' => 'content', 'label' => 'محتوى الخدمة', 'colspan' => 2, 'group' => 'المحتوى'],
        ['type' => 'text', 'name' => 'delivery_days', 'label' => 'مدة التسليم (بالأيام)', 'props' => ['type' => 'number'], 'group' => 'البيانات الأساسية'],
        ['type' => 'toggle', 'name' => 'featured', 'label' => 'مميزة', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'requestable', 'label' => 'قابلة للطلب', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّلة', 'group' => 'الإعدادات'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات الميتا المفتاحية', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
    ];
}
