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
        'type' => [
            'label' => 'النوع',
            'type' => 'select',
            'options' => [
                'photo' => 'صورة',
                'video' => 'فيديو',
            ],
        ],
    ];
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
                    'placeholder' => 'اختر قسماً',
                ],
                'group' => 'البيانات الأساسية',
            ],
            ['type' => 'text', 'name' => 'title', 'label' => 'العنوان', 'group' => 'البيانات الأساسية'],
            ['type' => 'textarea', 'name' => 'description', 'label' => 'الوصف', 'colspan' => 2, 'group' => 'الوصف'],
            [
                'type' => 'select',
                'name' => 'type',
                'label' => 'نوع المعرض',
                'props' => [
                    'options' => [
                        'photo' => 'صورة',
                        'video' => 'فيديو',
                    ],
                ],
                'group' => 'البيانات الأساسية',
            ],
            ['type' => 'file', 'name' => 'file_path', 'label' => 'الملف', 'colspan' => 2, 'group' => 'الوسائط'],
            ['type' => 'text', 'name' => 'youtube_url', 'label' => 'رابط يوتيوب', 'colspan' => 2, 'group' => 'الوسائط'],
            ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number'], 'group' => 'البيانات الأساسية'],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
            ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز', 'group' => 'الإعدادات'],
        ];
    }
}
