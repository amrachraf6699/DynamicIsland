@php
$title = $resourceLabel ?? 'العناصر';
$actions = [
    ['label' => 'رد', 'type' => 'link', 'route' => "admin.$resourceName.reply", 'variant' => 'primary'],
    ['label' => 'حذف', 'type' => 'delete', 'route' => "admin.$resourceName.destroy"],
];
$bulkRoute = null;
if (Route::has('admin.contacts.bulk-destroy') && auth()->user()?->can('contacts.delete')) {
    $bulkRoute = route('admin.contacts.bulk-destroy');
}
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
                    placeholder="{{ $filter['placeholder'] ?? ('ابحث عن ' . $label . '...') }}"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                    dir="rtl">
            </div>
            @endif
            @endforeach

            <button type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 transition hover:border-rose-200 hover:text-rose-600"
                data-filter-reset aria-label="إعادة ضبط عوامل التصفية" title="إعادة ضبط عوامل التصفية">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12a8 8 0 11-2.34-5.66M20 4v6h-6" />
                </svg>
            </button>
        </form>

        {{-- No create for contacts --}}
        <div></div>
    </div>

    <x-admin.table :columns="$columns ?? []" :rows="$items" :resource="$resourceName" :actions="$actions" :bulk-route="$bulkRoute" />

    @if ($items->hasPages())
    <div class="glass-panel rounded-3xl px-4 py-3">
        {{ $items->onEachSide(1)->links() }}
    </div>
    @endif
</x-admin.layout>
