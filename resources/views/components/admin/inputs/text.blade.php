@props([
    'name',
    'label' => null,
    'value' => '',
    'type' => 'text',
    'placeholder' => '',
    'colspan' => 1,
    'icon' => null,
    'required' => false,
])

<div class="space-y-2 text-right" style="grid-column: span {{ $colspan }} / span {{ $colspan }};">
    <!-- Enhanced label styling with better typography and spacing -->
    <label for="{{ $name }}" class="flex items-center gap-1 text-xs font-semibold tracking-widest text-slate-600">
        {{ $label ?? \Illuminate\Support\Str::headline($name) }}
        @if($required)
            <span class="text-rose-400">*</span>
        @endif
    </label>
    
    <!-- Improved input wrapper with icon support and better focus states -->
    <div class="group relative flex items-center">
        @if($icon)
            <span class="absolute right-4 text-slate-500 group-focus-within:text-indigo-400 transition pointer-events-none">
                <i class="bx {{ $icon }} text-lg"></i>
            </span>
        @endif
        
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            dir="rtl"
            {{ $required ? 'required' : '' }}
            class="w-full rounded-xl border border-slate-200 bg-white px-4 {{ $icon ? 'pr-12' : '' }} py-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 placeholder:font-normal transition duration-200
                   focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40 focus:bg-white
                   hover:border-slate-300
                   disabled:opacity-50 disabled:cursor-not-allowed"
        >
    </div>
    
    <!-- Better error message styling -->
    @error($name)
        <div class="flex items-center gap-1.5 text-xs text-rose-600 font-medium">
            <i class="bx bx-x-circle text-base"></i>
            <span>{{ $message }}</span>
        </div>
    @enderror
</div>
