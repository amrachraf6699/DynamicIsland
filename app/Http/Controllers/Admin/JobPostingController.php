<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobPosting;

class JobPostingController extends BaseCrudController
{
    protected string $model = JobPosting::class;
    protected string $resourceName = 'job-postings';
    protected array $searchable = ['id', 'title', 'department', 'location'];
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
        'employment_type' => [
            'label' => 'نوع الدوام',
            'type' => 'select',
            'options' => [
                'full_time' => 'دوام كامل',
                'part_time' => 'دوام جزئي',
                'contract' => 'عقد',
                'internship' => 'تدريب',
                'freelance' => 'عمل حر',
            ],
        ],
    ];
    protected array $sortable = ['id', 'title', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'is_featured'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'department' => ['nullable', 'string', 'max:255'],
        'location' => ['nullable', 'string', 'max:255'],
        'employment_type' => ['required', 'in:full_time,part_time,contract,internship,freelance'],
        'description' => ['nullable', 'string'],
        'requirements' => ['nullable', 'string'],
        'responsibilities' => ['nullable', 'string'],
        'experience_level' => ['nullable', 'string', 'max:255'],
        'salary_min' => ['nullable', 'numeric', 'min:0'],
        'salary_max' => ['nullable', 'numeric', 'min:0'],
        'currency' => ['nullable', 'string', 'max:10'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'department' => ['nullable', 'string', 'max:255'],
        'location' => ['nullable', 'string', 'max:255'],
        'employment_type' => ['required', 'in:full_time,part_time,contract,internship,freelance'],
        'description' => ['nullable', 'string'],
        'requirements' => ['nullable', 'string'],
        'responsibilities' => ['nullable', 'string'],
        'experience_level' => ['nullable', 'string', 'max:255'],
        'salary_min' => ['nullable', 'numeric', 'min:0'],
        'salary_max' => ['nullable', 'numeric', 'min:0'],
        'currency' => ['nullable', 'string', 'max:10'],
    ];
                    protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'المسمى الوظيفي', 'colspan' => 2, 'group' => 'البيانات الأساسية'],
        ['type' => 'text', 'name' => 'department', 'label' => 'القسم', 'group' => 'البيانات الأساسية'],
        ['type' => 'text', 'name' => 'location', 'label' => 'الموقع', 'group' => 'البيانات الأساسية'],
        [
            'type' => 'select',
            'name' => 'employment_type',
            'label' => 'نوع التوظيف',
            'props' => [
                'options' => [
                    'full_time' => 'دوام كامل',
                    'part_time' => 'دوام جزئي',
                    'contract' => 'عقد',
                    'internship' => 'تدريب',
                    'freelance' => 'عمل حر',
                ],
            ],
            'group' => 'البيانات الأساسية',
        ],
        ['type' => 'textarea', 'name' => 'description', 'label' => 'الوصف', 'colspan' => 2, 'group' => 'الوصف والمتطلبات'],
        ['type' => 'textarea', 'name' => 'requirements', 'label' => 'المتطلبات', 'colspan' => 2, 'group' => 'الوصف والمتطلبات'],
        ['type' => 'textarea', 'name' => 'responsibilities', 'label' => 'المسؤوليات', 'colspan' => 2, 'group' => 'الوصف والمتطلبات'],
        ['type' => 'text', 'name' => 'experience_level', 'label' => 'مستوى الخبرة', 'group' => 'الخبرة والراتب'],
        ['type' => 'text', 'name' => 'salary_min', 'label' => 'الحد الأدنى للراتب', 'props' => ['type' => 'number', 'step' => '0.01'], 'group' => 'الخبرة والراتب'],
        ['type' => 'text', 'name' => 'salary_max', 'label' => 'الحد الأعلى للراتب', 'props' => ['type' => 'number', 'step' => '0.01'], 'group' => 'الخبرة والراتب'],
        ['type' => 'text', 'name' => 'currency', 'label' => 'العملة', 'colspan' => 1, 'group' => 'الخبرة والراتب'],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز', 'group' => 'الإعدادات'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات الميتا المفتاحية', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
    ];
}
