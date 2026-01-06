<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMember;

class TeamMemberController extends BaseCrudController
{
    protected string $model = TeamMember::class;
    protected string $resourceName = 'team-members';
    protected array $searchable = ['id', 'name', 'job_title', 'email'];
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
    protected array $fileAttributes = ['img' => 'public'];
    protected array $createValidationRules = [
        'name' => ['required', 'string', 'max:255'],
        'img' => ['nullable', 'image'],
        'job_title' => ['nullable', 'string', 'max:255'],
        'bio' => ['nullable', 'string'],
        'email' => ['nullable', 'email'],
        'phone' => ['nullable', 'string', 'max:50'],
        'order' => ['nullable', 'integer'],
        'joined_at' => ['nullable', 'date'],
    ];
    protected array $updateValidationRules = [
        'name' => ['required', 'string', 'max:255'],
        'img' => ['nullable', 'image'],
        'job_title' => ['nullable', 'string', 'max:255'],
        'bio' => ['nullable', 'string'],
        'email' => ['nullable', 'email'],
        'phone' => ['nullable', 'string', 'max:50'],
        'order' => ['nullable', 'integer'],
        'joined_at' => ['nullable', 'date'],
    ];
                    protected array $formSchema = [
        ['type' => 'text', 'name' => 'name', 'label' => 'الاسم', 'group' => 'البيانات الأساسية'],
        ['type' => 'text', 'name' => 'job_title', 'label' => 'المسمى الوظيفي', 'group' => 'البيانات الأساسية'],
        ['type' => 'file', 'name' => 'img', 'label' => 'الصورة', 'group' => 'الوسائط'],
        ['type' => 'textarea', 'name' => 'bio', 'label' => 'نبذة', 'colspan' => 2, 'group' => 'النبذة'],
        ['type' => 'text', 'name' => 'joined_at', 'label' => 'تاريخ الانضمام', 'props' => ['type' => 'date'], 'group' => 'البيانات الأساسية'],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number'], 'group' => 'البيانات الأساسية'],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز', 'group' => 'الإعدادات'],
        ['type' => 'text', 'name' => 'email', 'label' => 'البريد الإلكتروني', 'group' => 'التواصل'],
        ['type' => 'text', 'name' => 'phone', 'label' => 'رقم الهاتف', 'group' => 'التواصل'],
        ['type' => 'text', 'name' => 'whatsapp', 'label' => 'واتساب', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'facebook', 'label' => 'فيسبوك', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'instagram', 'label' => 'انستغرام', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'tiktok', 'label' => 'تيك توك', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'behance', 'label' => 'بيهانس', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'youtube', 'label' => 'يوتيوب', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'twitter', 'label' => 'تويتر', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'linkedin', 'label' => 'لينكدإن', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'github', 'label' => 'جيت هاب', 'group' => 'روابط التواصل'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات الميتا المفتاحية', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
    ];
}
