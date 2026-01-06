@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'placeholder' => 'اختر من القائمة',
    'colspan' => 1,
    'required' => false,
    'multiple' => false,
    'searchable' => true,
])

<div class="space-y-2 text-right" style="grid-column: span {{ $colspan }} / span {{ $colspan }};">
    <!-- Enhanced label styling -->
    <label for="{{ $name }}" class="flex items-center gap-1 text-xs font-semibold tracking-widest text-slate-600">
        {{ $label ?? \Illuminate\Support\Str::headline($name) }}
        @if($required)
            <span class="text-rose-400">*</span>
        @endif
    </label>
    
    <!-- Improved select with Select2 integration for better UX -->
    <select
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        id="{{ $name }}"
        class="js-select2 w-full rounded-xl border border-slate-200 bg-white px-0 py-3 text-sm font-medium text-slate-900 transition duration-200
               focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40
               hover:border-slate-300"
        data-placeholder="{{ $placeholder }}"
        data-allow-clear="{{ $searchable ? 'true' : 'false' }}"
        dir="rtl"
        {{ $required ? 'required' : '' }}
        {{ $multiple ? 'multiple' : '' }}
    >
        <option value=""></option>
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected(old($name, $value) == $optionValue || (is_array(old($name, $value)) && in_array($optionValue, old($name, $value))))>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    
    <!-- Better error message styling -->
    @error($name)
        <div class="flex items-center gap-1.5 text-xs text-rose-600 font-medium">
            <i class="bx bx-x-circle text-base"></i>
            <span>{{ $message }}</span>
        </div>
    @enderror
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('{{ $name }}');
            if (select && window.jQuery && window.jQuery.fn.select2) {
                jQuery(select).select2({
                    language: 'ar',
                    dir: 'rtl',
                    width: '100%',
                    placeholder: '{{ $placeholder }}',
                    allowClear: {{ $searchable ? 'true' : 'false' }},
                    closeOnSelect: {{ $multiple ? 'false' : 'true' }},
                    templateResult: function(data) {
                        if (!data.id) return data.text;
                        return data.text;
                    },
                    templateSelection: function(data) {
                        return data.text;
                    }
                });
            }
        });
    </script>
@endpush
