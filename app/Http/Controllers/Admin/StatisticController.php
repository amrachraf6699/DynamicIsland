<?php

namespace App\Http\Controllers\Admin;

use App\Models\Statistic;

class StatisticController extends BaseCrudController
{
    protected string $model = Statistic::class;
    protected string $resourceName = 'statistics';
    protected array $searchable = ['id', 'title', 'unit'];
    protected array $filterable = ['is_active', 'is_featured'];
    protected array $sortable = ['id', 'title', 'order', 'created_at'];
    protected array $booleanAttributes = ['is_active', 'is_featured'];
    protected array $createValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'value' => ['required', 'integer', 'min:0'],
        'unit' => ['nullable', 'string', 'max:50'],
        'order' => ['nullable', 'integer'],
    ];
    protected array $updateValidationRules = [
        'title' => ['required', 'string', 'max:255'],
        'value' => ['required', 'integer', 'min:0'],
        'unit' => ['nullable', 'string', 'max:50'],
        'order' => ['nullable', 'integer'],
    ];
    protected array $formSchema = [
        ['type' => 'text', 'name' => 'title', 'label' => 'العنوان'],
        ['type' => 'text', 'name' => 'value', 'label' => 'القيمة', 'props' => ['type' => 'number']],
        ['type' => 'text', 'name' => 'unit', 'label' => 'الوحدة'],
        ['type' => 'text', 'name' => 'order', 'label' => 'الترتيب', 'props' => ['type' => 'number']],
        ['type' => 'toggle', 'name' => 'is_active', 'label' => 'مفعل'],
        ['type' => 'toggle', 'name' => 'is_featured', 'label' => 'مميز'],
    ];
}
