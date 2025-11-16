<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;

class ProjectController extends BaseCrudController
{
    protected string $model = Project::class;
    protected string $resourceName = 'projects';
    protected array $searchable = ['id', 'title', 'client', 'location'];
    protected array $filterable = ['is_active'];
    protected array $sortable = ['id', 'title', 'date', 'created_at'];
    protected array $fileAttributes = ['cover' => 'public'];
    protected array $createValidationRules = [
        'title' => ['nullable', 'string', 'max:255'],
        'cover' => ['nullable', 'image'],
        'content' => ['nullable', 'string'],
        'demo' => ['nullable', 'url'],
        'live_preview' => ['nullable', 'url'],
        'client' => ['nullable', 'string', 'max:255'],
        'location' => ['nullable', 'string', 'max:255'],
        'date' => ['nullable', 'date'],
        'is_active' => ['nullable', 'boolean'],
    ];
    protected array $updateValidationRules = [
        'title' => ['nullable', 'string', 'max:255'],
        'cover' => ['nullable', 'image'],
        'content' => ['nullable', 'string'],
        'demo' => ['nullable', 'url'],
        'live_preview' => ['nullable', 'url'],
        'client' => ['nullable', 'string', 'max:255'],
        'location' => ['nullable', 'string', 'max:255'],
        'date' => ['nullable', 'date'],
        'is_active' => ['nullable', 'boolean'],
    ];
    protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'عنوان المشروع', 'colspan' => 2],
        ['type' => 'file', 'name' => 'cover', 'label' => 'صورة المشروع', 'colspan' => 2],
        ['type' => 'richtext', 'name' => 'content', 'label' => 'تفاصيل المشروع', 'colspan' => 2],
        ['type' => 'text', 'name' => 'demo', 'label' => 'رابط العرض التجريبي', 'colspan' => 2],
        ['type' => 'text', 'name' => 'live_preview', 'label' => 'رابط المعاينة الحية', 'colspan' => 2],
        ['type' => 'text', 'name' => 'client', 'label' => 'العميل'],
        ['type' => 'text', 'name' => 'location', 'label' => 'الموقع'],
        ['type' => 'text', 'name' => 'date', 'label' => 'تاريخ التنفيذ', 'props' => ['type' => 'date']],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
    ];
}
