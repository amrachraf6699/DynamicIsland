<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;

class TestimonialController extends BaseCrudController
{
    protected string $model = Testimonial::class;
    protected string $resourceName = 'testimonials';
    protected array $searchable = ['id', 'name', 'company'];
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
    protected array $sortable = ['id', 'name', 'rating', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'is_featured'];
    protected array $fileAttributes = ['img' => 'public'];
    protected array $createValidationRules = [
        'name' => ['nullable', 'string', 'max:255'],
        'job_title' => ['nullable', 'string', 'max:255'],
        'company' => ['nullable', 'string', 'max:255'],
        'img' => ['nullable', 'image'],
        'content' => ['nullable', 'string', 'max:1000'],
        'rating' => ['nullable', 'integer', 'between:1,5'],
        'service_id' => ['nullable', 'exists:services,id'],
        'project_id' => ['nullable', 'exists:projects,id'],
    ];
    protected array $updateValidationRules = [
        'name' => ['nullable', 'string', 'max:255'],
        'job_title' => ['nullable', 'string', 'max:255'],
        'company' => ['nullable', 'string', 'max:255'],
        'img' => ['nullable', 'image'],
        'content' => ['nullable', 'string', 'max:1000'],
        'rating' => ['nullable', 'integer', 'between:1,5'],
        'service_id' => ['nullable', 'exists:services,id'],
        'project_id' => ['nullable', 'exists:projects,id'],
    ];

    protected function formSchema(?Model $item = null): array
    {
        $services = Service::query()->orderBy('title')->pluck('title', 'id')->toArray();
        $projects = Project::query()->orderBy('title')->pluck('title', 'id')->toArray();
        return [
            ['type' => 'text', 'name' => 'name', 'label' => 'الاسم', 'group' => 'البيانات الأساسية'],
            ['type' => 'text', 'name' => 'job_title', 'label' => 'المسمى الوظيفي', 'group' => 'البيانات الأساسية'],
            ['type' => 'text', 'name' => 'company', 'label' => 'الشركة', 'group' => 'البيانات الأساسية'],
            ['type' => 'file', 'name' => 'img', 'label' => 'الصورة', 'group' => 'الوسائط'],
            ['type' => 'textarea', 'name' => 'content', 'label' => 'النص', 'colspan' => 2, 'group' => 'المحتوى'],
            ['type' => 'text', 'name' => 'rating', 'label' => 'التقييم', 'props' => ['type' => 'number', 'min' => 1, 'max' => 5], 'group' => 'البيانات الأساسية'],
            [
                'type' => 'select',
                'name' => 'service_id',
                'label' => 'الخدمة المرتبطة',
                'props' => [
                    'options' => $services,
                    'placeholder' => 'اختر خدمة',
                ],
                'group' => 'الربط',
            ],
            [
                'type' => 'select',
                'name' => 'project_id',
                'label' => 'المشروع المرتبط',
                'props' => [
                    'options' => $projects,
                    'placeholder' => 'اختر مشروعاً',
                ],
                'group' => 'الربط',
            ],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
            ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز', 'group' => 'الإعدادات'],
        ];
    }
}
