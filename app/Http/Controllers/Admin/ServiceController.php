<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;

class ServiceController extends BaseCrudController
{
    protected string $model = Service::class;
    protected string $resourceName = 'services';
    protected array $searchable = ['id', 'title', 'slug'];
    protected array $filterable = ['is_active', 'featured', 'requestable'];
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
        ['type' => 'text', 'name' => 'title', 'label' => 'العنوان', 'colspan' => 2],
        ['type' => 'file', 'name' => 'cover', 'label' => 'صورة الخدمة', 'colspan' => 2],
        ['type' => 'richtext', 'name' => 'content', 'label' => 'وصف الخدمة', 'colspan' => 2],
        ['type' => 'text', 'name' => 'delivery_days', 'label' => 'أيام التسليم', 'props' => ['type' => 'number']],
        ['type' => 'toggle', 'name' => 'featured', 'label' => 'مميزة'],
        ['type' => 'toggle', 'name' => 'requestable', 'label' => 'قابلة للطلب'],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان السيو', 'colspan' => 2],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف السيو', 'colspan' => 2],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات مفتاحية', 'colspan' => 2],
    ];
}
