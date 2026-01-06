<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partner;

class PartnerController extends BaseCrudController
{
    protected string $model = Partner::class;
    protected string $resourceName = 'partners';
    protected array $searchable = ['id', 'name', 'website', 'email'];
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
        ['type' => 'text', 'name' => 'name', 'label' => 'اسم الشريك', 'group' => 'البيانات الأساسية'],
        ['type' => 'file', 'name' => 'logo', 'label' => 'الشعار', 'group' => 'الوسائط'],
        ['type' => 'text', 'name' => 'website', 'label' => 'الموقع الإلكتروني', 'group' => 'التواصل'],
        ['type' => 'text', 'name' => 'email', 'label' => 'البريد الإلكتروني', 'group' => 'التواصل'],
        ['type' => 'text', 'name' => 'phone', 'label' => 'رقم الهاتف', 'group' => 'التواصل'],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number'], 'group' => 'البيانات الأساسية'],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز', 'group' => 'الإعدادات'],
    ];
}
