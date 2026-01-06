@props([
    'name',
    'label' => null,
    'value' => '',
    'rows' => 5,
    'placeholder' => '',
    'colspan' => 2,
    'required' => false,
    'maxlength' => null,
])

<div class="space-y-2 text-right" style="grid-column: span {{ $colspan }} / span {{ $colspan }};">
    <!-- Enhanced label with character counter support -->
    <div class="flex items-center justify-between">
        <label for="{{ $name }}" class="flex items-center gap-1 text-xs font-semibold tracking-widest text-slate-600">
            {{ $label ?? \Illuminate\Support\Str::headline($name) }}
            @if($required)
                <span class="text-rose-400">*</span>
            @endif
        </label>
        @if($maxlength)
            <span class="text-xs text-slate-500 font-medium">
                <span class="char-count">0</span> / {{ $maxlength }}
            </span>
        @endif
    </div>
    
    <!-- Improved textarea with better focus states and resize handling -->
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        dir="rtl"
        {{ $required ? 'required' : '' }}
        {{ $maxlength ? "maxlength=$maxlength" : '' }}
        @if($maxlength)
            @input="document.querySelector('.char-count').textContent = this.value.length"
        @endif
        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 placeholder:text-slate-400 placeholder:font-normal transition duration-200 resize-none
               focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40 focus:bg-white
               hover:border-slate-300"
    >{{ old($name, $value) }}</textarea>
    
    <!-- Better error message styling -->
    @error($name)
        <div class="flex items-center gap-1.5 text-xs text-rose-600 font-medium">
            <i class="bx bx-x-circle text-base"></i>
            <span>{{ $message }}</span>
        </div>
    @enderror
</div>

@push('scripts')
    @if($maxlength)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const textarea = document.getElementById('{{ $name }}');
                if (textarea) {
                    textarea.addEventListener('input', () => {
                        document.querySelector('.char-count').textContent = textarea.value.length;
                    });
                }
            });
        </script>
    @endif
@endpush
