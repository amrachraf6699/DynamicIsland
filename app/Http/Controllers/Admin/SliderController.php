<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Model;

class SliderController extends BaseCrudController
{
    protected string $model = Slider::class;
    protected string $resourceName = 'sliders';
    protected array $searchable = ['id', 'title', 'subtitle'];
    protected array $filterable = [
        'is_active' => [
            'label' => 'الحالة',
            'type' => 'boolean',
            'options' => [
                '1' => 'مفعل',
                '0' => 'معطل',
            ],
        ],
    ];
    protected array $sortable = ['id', 'title', 'created_at'];
    protected array $fileAttributes = ['img' => 'public'];
    protected array $createValidationRules = [
        'title' => ['nullable', 'string', 'max:255'],
        'subtitle' => ['nullable', 'string', 'max:255'],
        'content' => ['nullable', 'string', 'max:1000'],
        'button' => ['nullable', 'string', 'max:255'],
        'url' => ['nullable', 'url'],
        'img' => ['required', 'image'],
        'service_id' => ['nullable', 'exists:services,id'],
        'text_align_horizontal' => ['required', 'in:left,center,right'],
        'text_align_vertical' => ['required', 'in:top,middle,bottom'],
        'button_align_horizontal' => ['required', 'in:left,center,right'],
        'button_align_vertical' => ['required', 'in:top,middle,bottom'],
    ];
    protected array $updateValidationRules = [
        'title' => ['nullable', 'string', 'max:255'],
        'subtitle' => ['nullable', 'string', 'max:255'],
        'content' => ['nullable', 'string', 'max:1000'],
        'button' => ['nullable', 'string', 'max:255'],
        'url' => ['nullable', 'url'],
        'img' => ['nullable', 'image'],
        'service_id' => ['nullable', 'exists:services,id'],
        'text_align_horizontal' => ['required', 'in:left,center,right'],
        'text_align_vertical' => ['required', 'in:top,middle,bottom'],
        'button_align_horizontal' => ['required', 'in:left,center,right'],
        'button_align_vertical' => ['required', 'in:top,middle,bottom'],
    ];

    protected function formSchema(?Model $item = null): array
    {
        $services = Service::query()->orderBy('title')->pluck('title', 'id')->toArray();
        $alignOptions = [
            'left' => 'يسار',
            'center' => 'وسط',
            'right' => 'يمين',
        ];
        $verticalAlign = [
            'top' => 'أعلى',
            'middle' => 'منتصف',
            'bottom' => 'أسفل',
        ];
        return [
            ['type' => 'text', 'name' => 'title', 'label' => 'عنوان السلايدر', 'group' => 'البيانات الأساسية'],
            ['type' => 'text', 'name' => 'subtitle', 'label' => 'العنوان الفرعي', 'group' => 'البيانات الأساسية'],
            ['type' => 'textarea', 'name' => 'content', 'label' => 'النص', 'colspan' => 2, 'group' => 'المحتوى'],
            ['type' => 'text', 'name' => 'button', 'label' => 'نص الزر', 'group' => 'المحتوى'],
            ['type' => 'text', 'name' => 'url', 'label' => 'رابط الزر', 'group' => 'المحتوى'],
            ['type' => 'file', 'name' => 'img', 'label' => 'صورة السلايدر', 'colspan' => 2, 'group' => 'الوسائط'],
            [
                'type' => 'select',
                'name' => 'service_id',
                'label' => 'الخدمة المرتبطة',
                'props' => [
                    'options' => $services,
                    'placeholder' => 'اختر خدمة',
                ],
                'group' => 'البيانات الأساسية',
            ],
            [
                'type' => 'select',
                'name' => 'text_align_horizontal',
                'label' => 'محاذاة النص أفقياً',
                'props' => ['options' => [
                    'left' => 'يسار',
                    'center' => 'وسط',
                    'right' => 'يمين',
                ]],
                'group' => 'المحاذاة',
            ],
            [
                'type' => 'select',
                'name' => 'text_align_vertical',
                'label' => 'محاذاة النص عمودياً',
                'props' => ['options' => [
                    'top' => 'أعلى',
                    'middle' => 'منتصف',
                    'bottom' => 'أسفل',
                ]],
                'group' => 'المحاذاة',
            ],
            [
                'type' => 'select',
                'name' => 'button_align_horizontal',
                'label' => 'محاذاة الزر أفقياً',
                'props' => ['options' => [
                    'left' => 'يسار',
                    'center' => 'وسط',
                    'right' => 'يمين',
                ]],
                'group' => 'المحاذاة',
            ],
            [
                'type' => 'select',
                'name' => 'button_align_vertical',
                'label' => 'محاذاة الزر عمودياً',
                'props' => ['options' => [
                    'top' => 'أعلى',
                    'middle' => 'منتصف',
                    'bottom' => 'أسفل',
                ]],
                'group' => 'المحاذاة',
            ],
            ['type' => 'text', 'name' => 'text_color', 'label' => 'لون النص', 'group' => 'الألوان'],
            ['type' => 'text', 'name' => 'button_color', 'label' => 'لون الزر', 'group' => 'الألوان'],
            ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعّل', 'group' => 'الإعدادات'],
        ];
    }
}
