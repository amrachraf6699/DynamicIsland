<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Models\GallerySection;
use Illuminate\Database\Eloquent\Model;

class GalleryController extends BaseCrudController
{
    protected string $model = Gallery::class;
    protected string $resourceName = 'galleries';
    protected array $searchable = ['id', 'title', 'type'];
    protected array $filterable = ['is_active', 'is_featured', 'type'];
    protected array $sortable = ['id', 'title', 'order', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'is_featured'];
    protected array $fileAttributes = ['file_path' => 'public'];
    protected array $createValidationRules = [
        'gallery_section_id' => ['nullable', 'exists:gallery_sections,id'],
        'title' => ['nullable', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'type' => ['required', 'in:photo,video'],
        'file_path' => ['nullable', 'file'],
        'youtube_url' => ['nullable', 'url'],
        'order' => ['nullable', 'integer'],
    ];
    protected array $updateValidationRules = [
        'gallery_section_id' => ['nullable', 'exists:gallery_sections,id'],
        'title' => ['nullable', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'type' => ['required', 'in:photo,video'],
        'file_path' => ['nullable', 'file'],
        'youtube_url' => ['nullable', 'url'],
        'order' => ['nullable', 'integer'],
    ];

    protected function formSchema(?Model $item = null): array
    {
        $sections = GallerySection::query()->orderBy('title')->pluck('title', 'id')->toArray();

        return [
            [
                'type' => 'select',
                'name' => 'gallery_section_id',
                'label' => 'قسم المعرض',
                'props' => [
                    'options' => $sections,
                    'placeholder' => 'اختر القسم',
                ],
            ],
            ['type' => 'text', 'name' => 'title', 'label' => 'العنوان'],
            ['type' => 'textarea', 'name' => 'description', 'label' => 'الوصف', 'colspan' => 2],
            [
                'type' => 'select',
                'name' => 'type',
                'label' => 'النوع',
                'props' => [
                    'options' => [
                        'photo' => 'صورة',
                        'video' => 'فيديو',
                    ],
                ],
            ],
            ['type' => 'file', 'name' => 'file_path', 'label' => 'الملف', 'colspan' => 2],
            ['type' => 'text', 'name' => 'youtube_url', 'label' => 'رابط يوتيوب', 'colspan' => 2],
            ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number']],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
            ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز'],
        ];
    }
}
