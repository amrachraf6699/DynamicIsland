<?php

namespace App\Http\Controllers.Admin;

use App\Models\Award;

class AwardController extends BaseCrudController
{
    protected string $model = Award::class;
    protected string $resourceName = 'awards';
    protected array $searchable = ['id', 'title', 'organization'];
    protected array $filterable = ['is_active', 'is_featured'];
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
        'order' => ['nullable', 'integer'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'organization' => ['nullable', 'string', 'max:255'],
        'awarded_at' => ['nullable', 'date'],
        'image' => ['nullable', 'image'],
        'link' => ['nullable', 'url'],
        'description' => ['nullable', 'string'],
        'order' => ['nullable', 'integer'],
    ];
    protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'اسم الجائزة', 'colspan' => 2],
        ['type' => 'text', 'name' => 'organization', 'label' => 'الجهة المانحة'],
        ['type' => 'text', 'name' => 'awarded_at', 'label' => 'تاريخ الاستلام', 'props' => ['type' => 'date']],
        ['type' => 'file', 'name' => 'image', 'label' => 'صورة الجائزة'],
        ['type' => 'text', 'name' => 'link', 'label' => 'الرابط', 'colspan' => 2],
        ['type' => 'textarea', 'name' => 'description', 'label' => 'التفاصيل', 'colspan' => 2],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number']],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميزة'],
    ];
}
