@php
    $title = $resourceLabel ?? 'الموارد';
    $actions = [
        ['label' => 'تعديل', 'type' => 'link', 'route' => "admin.$resourceName.edit"],
        ['label' => 'حذف', 'type' => 'delete', 'route' => "admin.$resourceName.destroy"],
    ];
@endphp

<x-admin.layout :title="$title">
    <div class="glass-panel flex flex-wrap items-center justify-between gap-4 rounded-3xl p-4 text-right">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="ابحث داخل {{ $title }}..." class="w-64 rounded-2xl border border-slate-600/60 bg-slate-900/40 px-4 py-2 text-sm text-white placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/40" dir="rtl">
            @foreach(($filters ?? []) as $filter)
                @if(\Illuminate\Support\Str::startsWith($filter, 'is_'))
                    <select name="{{ $filter }}" class="js-select2 rounded-2xl border border-slate-600/60 bg-slate-900/40 px-4 py-2 text-sm text-white focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/40" dir="rtl">
                        <option value="">{{ __('اختر الحالة') }}</option>
                        <option value="1" @selected(request($filter) === '1')>مفعل</option>
                        <option value="0" @selected(request($filter) === '0')>معطل</option>
                    </select>
                @else
                    <input type="text" name="{{ $filter }}" value="{{ request($filter) }}" placeholder="ادخل القيمة المطلوبة" class="rounded-2xl border border-slate-600/60 bg-slate-900/40 px-4 py-2 text-sm text-white placeholder:text-slate-500 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/40" dir="rtl">
                @endif
            @endforeach
            <button type="submit" class="rounded-2xl bg-indigo-500 px-4 py-2 text-sm font-semibold text-white">تصفية</button>
        </form>

        <a href="{{ Route::has('admin.' . $resourceName . '.create') ? route('admin.' . $resourceName . '.create') : '#' }}" class="inline-flex items-center gap-2 rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/40 hover:bg-emerald-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            إضافة {{ $title }}
        </a>
    </div>

    <x-admin.table
        :columns="$columns ?? []"
        :rows="$items"
        :resource="$resourceName"
        :actions="$actions"
    />

    <div class="glass-panel rounded-3xl px-4 py-3 text-right">
        {{ $items->links() }}
    </div>
</x-admin.layout>
