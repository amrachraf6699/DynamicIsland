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

<div class="flex items-center justify-end gap-4 text-left" style="grid-column: span {{ $colspan }} / span {{ $colspan }};">
    <!-- Enhanced toggle switch with better visual design and accessibility -->
    <label class="relative inline-flex cursor-pointer items-center gap-3 group">
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
        
        <!-- Toggle Background -->
        <div class="h-7 w-12 rounded-full bg-slate-700/60 transition-all duration-300 after:absolute after:right-1 after:top-1 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow-md after:transition after:duration-300 
                    peer-checked:bg-emerald-500 peer-checked:after:translate-x-5
                    peer-focus:ring-2 peer-focus:ring-emerald-400/30">
        </div>
        
        <!-- Label Text -->
        <span class="text-sm font-semibold text-slate-300 group-hover:text-slate-200 transition">
            {{ $label ?? \Illuminate\Support\Str::headline($name) }}
        </span>
    </label>
</div>
