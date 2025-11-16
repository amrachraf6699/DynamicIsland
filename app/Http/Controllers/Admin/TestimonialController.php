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
    protected array $filterable = ['is_active', 'is_featured'];
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
            ['type' => 'text', 'name' => 'name', 'label' => 'اسم العميل'],
            ['type' => 'text', 'name' => 'job_title', 'label' => 'المسمى الوظيفي'],
            ['type' => 'text', 'name' => 'company', 'label' => 'الشركة'],
            ['type' => 'file', 'name' => 'img', 'label' => 'صورة العميل'],
            ['type' => 'textarea', 'name' => 'content', 'label' => 'نص التقييم', 'colspan' => 2],
            ['type' => 'text', 'name' => 'rating', 'label' => 'التقييم', 'props' => ['type' => 'number', 'min' => 1, 'max' => 5]],
            [
                'type' => 'select',
                'name' => 'service_id',
                'label' => 'الخدمة المرتبطة',
                'props' => [
                    'options' => $services,
                    'placeholder' => 'اختر الخدمة',
                ],
            ],
            [
                'type' => 'select',
                'name' => 'project_id',
                'label' => 'المشروع المرتبط',
                'props' => [
                    'options' => $projects,
                    'placeholder' => 'اختر المشروع',
                ],
            ],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
            ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز'],
        ];
    }
}
