<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ServiceController extends BaseCrudController
{
    protected string $model = Service::class;
    protected string $resourceName = 'services';
    protected array $searchable = ['id', 'title', 'slug'];
    protected array $filterable = [
        'is_active' => [
            'label' => 'الحالة',
            'type' => 'boolean',
            'options' => ['1' => 'مفعل', '0' => 'معطل'],
        ],
        'featured' => [
            'label' => 'مميزة',
            'type' => 'boolean',
            'options' => ['1' => 'مميزة', '0' => 'عادية'],
        ],
        'requestable' => [
            'label' => 'قابلة للطلب',
            'type' => 'boolean',
            'options' => ['1' => 'نعم', '0' => 'لا'],
        ],
    ];
    protected array $sortable = ['id', 'title', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'featured', 'requestable'];
    protected array $fileAttributes = ['cover' => 'public'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'cover' => ['nullable', 'image'],
        'content' => ['required', 'string'],
        'delivery_days' => ['nullable', 'integer', 'min:0'],
        'featured' => ['nullable', 'boolean'],
        'is_active' => ['nullable', 'boolean'],
        'requestable' => ['nullable', 'boolean'],
        'meta_title' => ['nullable', 'string', 'max:255'],
        'meta_description' => ['nullable', 'string', 'max:1000'],
        'meta_keywords' => ['nullable', 'string', 'max:255'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'cover' => ['nullable', 'image'],
        'content' => ['required', 'string'],
        'delivery_days' => ['nullable', 'integer', 'min:0'],
        'featured' => ['nullable', 'boolean'],
        'is_active' => ['nullable', 'boolean'],
        'requestable' => ['nullable', 'boolean'],
        'meta_title' => ['nullable', 'string', 'max:255'],
        'meta_description' => ['nullable', 'string', 'max:1000'],
        'meta_keywords' => ['nullable', 'string', 'max:255'],
    ];
    protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'عنوان الخدمة', 'colspan' => 2, 'group' => 'بيانات عامة'],
        ['type' => 'file', 'name' => 'cover', 'label' => 'صورة الخدمة', 'colspan' => 2, 'group' => 'الوسائط'],
        ['type' => 'richtext', 'name' => 'content', 'label' => 'وصف الخدمة', 'colspan' => 2, 'group' => 'بيانات عامة'],
        ['type' => 'text', 'name' => 'delivery_days', 'label' => 'أيام التسليم', 'props' => ['type' => 'number'], 'group' => 'بيانات عامة'],
        ['type' => 'toggle', 'name' => 'featured', 'label' => 'مميزة', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'requestable', 'label' => 'قابلة للطلب', 'group' => 'الإعدادات'],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'الحالة', 'group' => 'الإعدادات'],
        ['type' => 'text', 'name' => 'meta_title', 'label' => 'عنوان الميتا', 'colspan' => 2, 'group' => 'تحسين محركات البحث'],
        ['type' => 'textarea', 'name' => 'meta_description', 'label' => 'وصف الميتا', 'colspan' => 2, 'group' => 'تحسين محركات البحث'],
        ['type' => 'text', 'name' => 'meta_keywords', 'label' => 'كلمات مفتاحية', 'colspan' => 2, 'group' => 'تحسين محركات البحث'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:' . $this->permissionName('read'))->only('show');
    }

    protected function buildIndexQuery(Request $request): Builder
    {
        return parent::buildIndexQuery($request)
            ->withCount(['serviceRequests as requests_count']);
    }

    public function show(Service $service): Renderable
    {
        $service->loadCount('serviceRequests');
        $requests = $service->serviceRequests()
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.services.show', compact('service', 'requests'));
    }
}
