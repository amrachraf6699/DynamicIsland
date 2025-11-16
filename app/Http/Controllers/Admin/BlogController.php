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
    protected array $filterable = ['is_active', 'is_featured'];
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
            ['type' => 'text', 'name' => 'title', 'label' => 'عنوان المقال', 'colspan' => 2],
            ['type' => 'file', 'name' => 'cover', 'label' => 'صورة المقال', 'colspan' => 2],
            ['type' => 'textarea', 'name' => 'excerpt', 'label' => 'مقتطف قصير', 'colspan' => 2],
            ['type' => 'richtext', 'name' => 'content', 'label' => 'نص المقال', 'colspan' => 2],
            [
                'type' => 'select',
                'name' => 'blog_section_id',
                'label' => 'قسم المدونة',
                'props' => [
                    'options' => $sections,
                    'placeholder' => 'اختر قسماً',
                ],
            ],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
            ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مقال مميز'],
            ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان السيو', 'colspan' => 2],
            ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف السيو', 'colspan' => 2],
            ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات مفتاحية', 'colspan' => 2],
        ];
    }
}
