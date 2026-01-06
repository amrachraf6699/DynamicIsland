@props([
    'name',
    'label' => null,
    'value' => false,
    'colspan' => 1,
    'required' => false,
])

@php
    $checked = old($name, $value) ? 'checked' : '';
@endphp

<div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white px-5 py-4 text-right shadow-sm" style="grid-column: span {{ $colspan }} / span {{ $colspan }};">
    <span class="text-sm font-semibold text-slate-800">
        {{ $label ?? \Illuminate\Support\Str::headline($name) }}
    </span>

    <label class="relative inline-flex cursor-pointer items-center">
        <input
            type="hidden"
            name="{{ $name }}"
            value="0"
        >
        <input
            type="checkbox"
            class="peer sr-only"
            name="{{ $name }}"
            value="1"
            {{ $checked }}
            {{ $required ? 'required' : '' }}
        >
        <span class="relative h-7 w-14 rounded-full bg-slate-200 shadow-inner ring-1 ring-inset ring-slate-200 transition-all duration-300
            after:absolute after:left-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition after:duration-300
            peer-checked:bg-indigo-600 peer-checked:ring-indigo-500/40 peer-checked:after:translate-x-6
            peer-focus:ring-2 peer-focus:ring-indigo-300/50">
        </span>
    </label>
</div>
