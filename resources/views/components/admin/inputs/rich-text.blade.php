@props([
    'name',
    'label' => null,
    'value' => '',
    'colspan' => 2,
    'required' => false,
    'minHeight' => 300,
])

<div class="space-y-2 text-right" style="grid-column: span {{ $colspan }} / span {{ $colspan }};">
    <!-- Enhanced label styling -->
    <label for="{{ $name }}" class="flex items-center gap-1 text-xs font-semibold tracking-widest text-slate-600">
        {{ $label ?? \Illuminate\Support\Str::headline($name) }}
        @if($required)
            <span class="text-rose-400">*</span>
        @endif
    </label>
    
    <!-- Improved rich text editor with TinyMCE integration -->
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        class="js-richtext w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 transition duration-200
               focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40 focus:bg-white
               hover:border-slate-300"
        {{ $required ? 'required' : '' }}
        style="min-height: {{ $minHeight }}px;"
    >{{ old($name, $value) }}</textarea>
    
    <!-- Better error message styling -->
    @error($name)
        <div class="flex items-center gap-1.5 text-xs text-rose-600 font-medium">
            <i class="bx bx-x-circle text-base"></i>
            <span>{{ $message }}</span>
        </div>
    @enderror
</div>
