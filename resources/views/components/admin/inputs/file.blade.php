@props([
    'name',
    'label' => null,
    'value' => '',
    'colspan' => 1,
    'accept' => 'image/*',
    'required' => false,
    'multiple' => false,
])

@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="space-y-2 text-right" style="grid-column: span {{ $colspan }} / span {{ $colspan }};">
    <!-- Enhanced label styling -->
    <label for="{{ $name }}" class="flex items-center gap-1 text-xs font-semibold tracking-widest text-slate-300 uppercase">
        {{ $label ?? \Illuminate\Support\Str::headline($name) }}
        @if($required)
            <span class="text-rose-400">*</span>
        @endif
    </label>
    
    <!-- Improved file input with Dropify integration for drag-drop UX -->
    <input
        type="file"
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        id="{{ $name }}"
        class="js-dropify w-full rounded-xl"
        data-default-file="{{ $value ? Storage::url($value) : '' }}"
        accept="{{ $accept }}"
        {{ $required ? 'required' : '' }}
        {{ $multiple ? 'multiple' : '' }}
        data-height="120"
        data-errors='{"badFile":"نوع الملف غير صحيح","badUrl":"رابط الملف غير صحيح"}'
    >
    
    <!-- Better error message styling -->
    @error($name)
        <div class="flex items-center gap-1.5 text-xs text-rose-300 font-medium">
            <i class="bx bx-x-circle text-base"></i>
            <span>{{ $message }}</span>
        </div>
    @enderror
    
    <!-- File removal checkbox with improved styling -->
    @if ($value)
        <label class="mt-3 inline-flex items-center gap-3 rounded-lg border border-slate-700/50 bg-slate-900/30 px-4 py-3 hover:bg-slate-900/50 transition cursor-pointer">
            <input type="checkbox" name="remove_{{ $name }}" value="1" class="h-4 w-4 rounded accent-rose-400 cursor-pointer">
            <span class="text-xs font-medium text-slate-300">حذف الملف الحالي</span>
        </label>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropify = document.getElementById('{{ $name }}');
            if (dropify && window.jQuery && window.jQuery.fn.dropify) {
                jQuery(dropify).dropify({
                    messages: {
                        default: 'اسحب الملف أو انقر للرفع',
                        replace: 'اسحب أو انقر للاستبدال',
                        remove: 'إزالة',
                        error: 'خطأ في رفع الملف',
                    },
                    error: [
                    ]
                });
            }
        });
    </script>
@endpush
