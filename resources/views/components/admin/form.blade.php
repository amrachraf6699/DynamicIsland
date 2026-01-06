@props([
    'action' => '#',
    'method' => 'POST',
    'submitLabel' => 'حفظ',
])

@php
    $spoofMethod = strtoupper($method) !== 'GET' && strtoupper($method) !== 'POST';
@endphp

<!-- Improved responsive form with better mobile spacing -->
<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="glass-panel space-y-5 sm:space-y-7 rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6 text-right border border-slate-200 shadow-[0_10px_40px_rgba(15,23,42,0.08)]">
    @csrf
    @if ($spoofMethod)
        @method($method)
    @endif

    {{ $slot }}

    <div class="flex flex-col-reverse sm:flex-row items-center justify-start gap-2 sm:gap-3 pt-2 sm:pt-4 border-t border-slate-200">
        <a href="{{ url()->previous() }}" class="w-full sm:w-auto text-center rounded-lg sm:rounded-2xl border border-slate-200 px-4 sm:px-5 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
            إلغاء
        </a>
        <button type="submit" class="w-full sm:w-auto rounded-lg sm:rounded-2xl bg-indigo-600 hover:bg-indigo-500 px-4 sm:px-5 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-indigo-600/30 transition">
            {{ $submitLabel }}
        </button>
    </div>
</form>
