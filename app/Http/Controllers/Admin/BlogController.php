<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\BlogSection;
use Illuminate\Database\Eloquent\Model;

class BlogController extends BaseCrudController
{
    protected string $model = Blog::class;
    protected string $resourceName = 'blogs';
    protected array $searchable = ['id', 'title', 'slug'];
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
    protected array $sortable = ['id', 'title', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'is_featured'];
    protected array $fileAttributes = ['cover' => 'public'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'cover' => ['nullable', 'image'],
        'excerpt' => ['nullable', 'string'],
        'content' => ['nullable', 'string'],
        'blog_section_id' => ['nullable', 'exists:blog_sections,id'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'cover' => ['nullable', 'image'],
        'excerpt' => ['nullable', 'string'],
        'content' => ['nullable', 'string'],
        'blog_section_id' => ['nullable', 'exists:blog_sections,id'],
    ];

    protected function formSchema(?Model $item = null): array
    {
        $sections = BlogSection::query()->orderBy('title')->pluck('title', 'id')->toArray();
        return [
            ['type' => 'text', 'name' => 'title', 'label' => 'عنوان المقال', 'colspan' => 2, 'group' => 'البيانات الأساسية'],
            ['type' => 'file', 'name' => 'cover', 'label' => 'صورة الغلاف', 'colspan' => 2, 'group' => 'الوسائط'],
            ['type' => 'textarea', 'name' => 'excerpt', 'label' => 'المقتطف', 'colspan' => 2, 'group' => 'المحتوى'],
            ['type' => 'richtext', 'name' => 'content', 'label' => 'محتوى المقال', 'colspan' => 2, 'group' => 'المحتوى'],
            [
                'type' => 'select',
                'name' => 'blog_section_id',
                'label' => 'قسم المدونة',
                'props' => [
                    'options' => $sections,
                    'placeholder' => 'اختر قسماً',
                ],
                'group' => 'البيانات الأساسية',
            ],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
            ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز', 'group' => 'الإعدادات'],
            ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
            ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف الميتا', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
            ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات الميتا المفتاحية', 'colspan' => 2, 'group' => 'تهيئة محركات البحث'],
        ];
    }
}
