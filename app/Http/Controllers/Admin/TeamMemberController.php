<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMember;

class TeamMemberController extends BaseCrudController
{
    protected string $model = TeamMember::class;
    protected string $resourceName = 'team-members';
    protected array $searchable = ['id', 'name', 'job_title', 'email'];
    protected array $filterable = ['is_active', 'is_featured'];
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
        ['type' => 'text', 'name' => 'name', 'label' => 'اسم العضو'],
        ['type' => 'text', 'name' => 'job_title', 'label' => 'المسمى الوظيفي'],
        ['type' => 'file', 'name' => 'img', 'label' => 'صورة العضو'],
        ['type' => 'textarea', 'name' => 'bio', 'label' => 'نبذة تعريفية', 'colspan' => 2],
        ['type' => 'text', 'name' => 'joined_at', 'label' => 'تاريخ الانضمام', 'props' => ['type' => 'date']],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number']],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز'],
        ['type' => 'text', 'name' => 'email', 'label' => 'البريد الإلكتروني'],
        ['type' => 'text', 'name' => 'phone', 'label' => 'رقم الهاتف'],
        ['type' => 'text', 'name' => 'whatsapp', 'label' => 'واتساب'],
        ['type' => 'text', 'name' => 'facebook', 'label' => 'فيسبوك'],
        ['type' => 'text', 'name' => 'instagram', 'label' => 'إنستغرام'],
        ['type' => 'text', 'name' => 'tiktok', 'label' => 'تيك توك'],
        ['type' => 'text', 'name' => 'behance', 'label' => 'بيهانس'],
        ['type' => 'text', 'name' => 'youtube', 'label' => 'يوتيوب'],
        ['type' => 'text', 'name' => 'twitter', 'label' => 'تويتر'],
        ['type' => 'text', 'name' => 'linkedin', 'label' => 'لينكدإن'],
        ['type' => 'text', 'name' => 'github', 'label' => 'جيت هب'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان السيو', 'colspan' => 2],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف السيو', 'colspan' => 2],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات مفتاحية', 'colspan' => 2],
    ];
}
