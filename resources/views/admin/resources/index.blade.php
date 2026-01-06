@php
$title = $resourceLabel ?? 'الموارد';
$actions = [
['label' => 'تعديل', 'type' => 'link', 'route' => "admin.$resourceName.edit"],
['label' => 'حذف', 'type' => 'delete', 'route' => "admin.$resourceName.destroy"],
];
@endphp

<x-admin.layout :title="$title">
    <div
        class="glass-panel flex flex-col gap-4 rounded-3xl p-4 text-right lg:flex-row lg:items-center lg:justify-between">
        <form method="GET" class="scroll-thin flex flex-nowrap items-end gap-4 overflow-x-auto pb-1" data-filter-form>
            <div class="min-w-[14rem] shrink-0">
                <label class="mb-2 block text-xs font-semibold text-slate-600">بحث</label>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="ابحث في {{ $title }}..."
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                    dir="rtl">
            </div>

            @foreach(($filters ?? []) as $filter)
            @php
            $name = $filter['key'] ?? '';
            $label = $filter['label'] ?? \Illuminate\Support\Str::headline($name);
            $type = $filter['type'] ?? 'text';
            $options = $filter['options'] ?? [];
            @endphp

            @if(in_array($type, ['select', 'boolean'], true))
            <div class="min-w-[10rem] shrink-0">
                <label class="mb-2 block text-xs font-semibold text-slate-600">{{ $label }}</label>
                <select name="{{ $name }}"
                    class="js-select2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                    dir="rtl">
                    <option value="">{{ $filter['placeholder'] ?? 'الكل' }}</option>
                    @foreach($options as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @selected((string) request($name)===(string) $optionValue)>
                        {{ $optionLabel }}
                    </option>
                    @endforeach
                </select>
            </div>
            @else
            <div class="min-w-[10rem] shrink-0">
                <label class="mb-2 block text-xs font-semibold text-slate-600">{{ $label }}</label>
                <input type="{{ $type }}" name="{{ $name }}" value="{{ request($name) }}"
                    placeholder="{{ $filter['placeholder'] ?? ('اكتب ' . $label . '...') }}"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                    dir="rtl">
            </div>
            @endif
            @endforeach

            <button type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 transition hover:border-rose-200 hover:text-rose-600"
                data-filter-reset aria-label="إعادة تعيين الفلاتر" title="إعادة تعيين">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12a8 8 0 11-2.34-5.66M20 4v6h-6" />
                </svg>
            </button>
        </form>

        <a href="{{ Route::has('admin.' . $resourceName . '.create') ? route('admin.' . $resourceName . '.create') : '#' }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 hover:bg-emerald-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            إضافة {{ $title }}
        </a>
    </div>

    <x-admin.table :columns="$columns ?? []" :rows="$items" :resource="$resourceName" :actions="$actions" />

    @if ($items->hasPages())
    <div class="glass-panel rounded-3xl px-4 py-3">
        {{ $items->onEachSide(1)->links() }}
    </div>
    @endif
</x-admin.layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('[data-filter-form]');
        if (!form) return;

        const inputs = form.querySelectorAll('input, select');
        let timer;

        const submit = () => form.submit();
        const debouncedSubmit = () => {
            clearTimeout(timer);
            timer = setTimeout(submit, 350);
        };

        inputs.forEach((input) => {
            const eventName = input.tagName === 'SELECT' ? 'change' : 'input';
            input.addEventListener(eventName, debouncedSubmit);
        });

        if (window.jQuery) {
            window.jQuery(form).find('.js-select2').on('select2:select select2:clear', debouncedSubmit);
        }

        const resetButton = form.querySelector('[data-filter-reset]');
        if (resetButton) {
            resetButton.addEventListener('click', () => {
                inputs.forEach((input) => {
                    if (input.tagName === 'SELECT') {
                        input.value = '';
                        if (window.jQuery) {
                            window.jQuery(input).val('').trigger('change');
                        }
                    } else {
                        input.value = '';
                    }
                });
                form.submit();
            });
        }
    });
</script>