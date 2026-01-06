@php
    $resourceTitle = $resourceLabel ?? \Illuminate\Support\Str::headline($resourceName);
    $isEdit = $item?->exists ?? false;
    $title = $isEdit ? "تعديل {$resourceTitle}" : "إنشاء {$resourceTitle}";
    $action = $isEdit
        ? (Route::has("admin.$resourceName.update") ? route("admin.$resourceName.update", $item) : '#')
        : (Route::has("admin.$resourceName.store") ? route("admin.$resourceName.store") : '#');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<x-admin.layout :title="$title">
    <x-admin.form :action="$action" :method="$method" :submit-label="'إنشاء ' . $resourceTitle">
        @php
            $schema = collect($formSchema ?? []);
            $hasExplicitGroups = $schema->contains(fn ($field) => ($field['type'] ?? null) === 'group');
            $hasGroupKey = $schema->contains(fn ($field) => array_key_exists('group', $field));

            if ($hasExplicitGroups) {
                $groups = $schema->flatMap(function ($field) {
                    if (($field['type'] ?? null) === 'group') {
                        return [[
                            'label' => $field['label'] ?? null,
                            'description' => $field['description'] ?? null,
                            'fields' => $field['fields'] ?? [],
                        ]];
                    }

                    return [[
                        'label' => null,
                        'description' => null,
                        'fields' => [$field],
                    ]];
                })->values();
            } elseif ($hasGroupKey) {
                $groups = $schema->groupBy(fn ($field) => $field['group'] ?? '')
                    ->map(function ($fields, $label) {
                        return [
                            'label' => $label ?: null,
                            'description' => null,
                            'fields' => $fields->values()->all(),
                        ];
                    })
                    ->values();
            } else {
                $groups = collect([
                    ['label' => null, 'description' => null, 'fields' => $schema->all()],
                ]);
            }
        @endphp

        @if ($schema->isEmpty())
            <p class="text-sm text-slate-500">No form fields are configured for this resource yet.</p>
        @else
            <div class="space-y-5 sm:space-y-6">
                @foreach($groups as $group)
                    <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-[0_8px_24px_rgba(15,23,42,0.08)]">
                        @if($group['label'] || $group['description'])
                            <div class="mb-4 border-b border-slate-200 pb-3">
                                @if($group['label'])
                                    <h3 class="text-sm font-semibold text-slate-800 tracking-wide">{{ $group['label'] }}</h3>
                                @endif
                                @if($group['description'])
                                    <p class="text-xs text-slate-500 mt-1">{{ $group['description'] }}</p>
                                @endif
                            </div>
                        @endif

                        <div class="grid gap-3 sm:gap-4 md:gap-6 md:grid-cols-2">
                            @foreach($group['fields'] as $field)
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
                                        'required' => in_array($field['name'], $requiredFields ?? [], true),
                                    ], $field['props'] ?? []);

                                    $attrs = new \Illuminate\View\ComponentAttributeBag($props);
                                @endphp

                                <x-dynamic-component :component="$component" :attributes="$attrs" />
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </x-admin.form>
</x-admin.layout>
