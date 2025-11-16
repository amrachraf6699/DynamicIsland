<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partner;

class PartnerController extends BaseCrudController
{
    protected string $model = Partner::class;
    protected string $resourceName = 'partners';
    protected array $searchable = ['id', 'name', 'website', 'email'];
    protected array $filterable = ['is_active', 'is_featured'];
    protected array $sortable = ['id', 'name', 'order', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'is_featured'];
    protected array $fileAttributes = ['logo' => 'public'];
    protected array $createValidationRules = [
        'name' => ['required', 'string', 'max:255'],
        'logo' => ['nullable', 'image'],
        'website' => ['nullable', 'url'],
        'email' => ['nullable', 'email'],
        'phone' => ['nullable', 'string', 'max:50'],
        'order' => ['nullable', 'integer'],
    ];
    protected array $updateValidationRules = [
        'name' => ['required', 'string', 'max:255'],
        'logo' => ['nullable', 'image'],
        'website' => ['nullable', 'url'],
        'email' => ['nullable', 'email'],
        'phone' => ['nullable', 'string', 'max:50'],
        'order' => ['nullable', 'integer'],
    ];
    protected array $formSchema = [
        ['type' => 'text', 'name' => 'name', 'label' => 'اسم الشريك'],
        ['type' => 'file', 'name' => 'logo', 'label' => 'الشعار'],
        ['type' => 'text', 'name' => 'website', 'label' => 'الموقع الإلكتروني'],
        ['type' => 'text', 'name' => 'email', 'label' => 'البريد الإلكتروني'],
        ['type' => 'text', 'name' => 'phone', 'label' => 'رقم الهاتف'],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number']],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز'],
    ];
}
