<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobPosting;

class JobPostingController extends BaseCrudController
{
    protected string $model = JobPosting::class;
    protected string $resourceName = 'job-postings';
    protected array $searchable = ['id', 'title', 'department', 'location'];
    protected array $filterable = ['is_active', 'is_featured', 'employment_type'];
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
        ['type' => 'text', 'name' => 'title', 'label' => 'عنوان الوظيفة', 'colspan' => 2],
        ['type' => 'text', 'name' => 'department', 'label' => 'القسم'],
        ['type' => 'text', 'name' => 'location', 'label' => 'الموقع'],
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
        ],
        ['type' => 'textarea', 'name' => 'description', 'label' => 'وصف الوظيفة', 'colspan' => 2],
        ['type' => 'textarea', 'name' => 'requirements', 'label' => 'متطلبات الوظيفة', 'colspan' => 2],
        ['type' => 'textarea', 'name' => 'responsibilities', 'label' => 'المسؤوليات', 'colspan' => 2],
        ['type' => 'text', 'name' => 'experience_level', 'label' => 'سنوات الخبرة'],
        ['type' => 'text', 'name' => 'salary_min', 'label' => 'الراتب الأدنى', 'props' => ['type' => 'number', 'step' => '0.01']],
        ['type' => 'text', 'name' => 'salary_max', 'label' => 'الراتب الأعلى', 'props' => ['type' => 'number', 'step' => '0.01']],
        ['type' => 'text', 'name' => 'currency', 'label' => 'العملة', 'colspan' => 1],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان السيو', 'colspan' => 2],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف السيو', 'colspan' => 2],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات مفتاحية', 'colspan' => 2],
    ];
}
