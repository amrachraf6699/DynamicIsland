@php
    $resourceTitle = $resourceLabel ?? \Illuminate\Support\Str::headline($resourceName);
    $isEdit = $item?->exists ?? false;
    $title = $isEdit ? "تعديل {$resourceTitle}" : "إضافة {$resourceTitle}";
    $action = $isEdit
        ? (Route::has("admin.$resourceName.update") ? route("admin.$resourceName.update", $item) : '#')
        : (Route::has("admin.$resourceName.store") ? route("admin.$resourceName.store") : '#');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<x-admin.layout :title="$title">
    <x-admin.form :action="$action" :method="$method" :submit-label="'حفظ ' . $resourceTitle">
        @forelse($formSchema as $field)
            @php
                $component = match ($field['type']) {
                    'textarea' => 'admin.inputs.textarea',
                    'richtext', 'rich-text' => 'admin.inputs.rich-text',
                    'select' => 'admin.inputs.select',
                    'toggle' => 'admin.inputs.toggle',
                    'file' => 'admin.inputs.file',
                    default => 'admin.inputs.text',
                };

                $props = array_merge([
                    'name' => $field['name'],
                    'label' => $field['label'] ?? \Illuminate\Support\Str::headline($field['name']),
                    'value' => old($field['name'], data_get($item ?? null, $field['name'])),
                    'colspan' => $field['colspan'] ?? ($component === 'admin.inputs.text' ? 1 : 2),
                ], $field['props'] ?? []);

                $attrs = new \Illuminate\View\ComponentAttributeBag($props);
            @endphp

            <x-dynamic-component :component="$component" :attributes="$attrs" />
        @empty
            <p class="text-sm text-slate-400">يرجى تعريف مخطط الحقول داخل المتحكم قبل عرض النموذج.</p>
        @endforelse
    </x-admin.form>
</x-admin.layout>
