@props([
    'action' => '#',
    'method' => 'POST',
    'submitLabel' => 'حفظ',
])

@php
    $spoofMethod = strtoupper($method) !== 'GET' && strtoupper($method) !== 'POST';
@endphp

<!-- Improved responsive form with better mobile spacing -->
<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="glass-panel space-y-4 sm:space-y-6 rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6 text-right">
    @csrf
    @if ($spoofMethod)
        @method($method)
    @endif

    <div class="grid gap-3 sm:gap-4 md:gap-6 md:grid-cols-2">
        {{ $slot }}
    </div>

    <div class="flex flex-col-reverse sm:flex-row items-center justify-start gap-2 sm:gap-3 pt-2 sm:pt-4 border-t border-white/10">
        <a href="{{ url()->previous() }}" class="w-full sm:w-auto text-center rounded-lg sm:rounded-2xl border border-slate-600 px-4 sm:px-5 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold text-slate-200 hover:bg-white/5 transition">
            إلغاء
        </a>
        <button type="submit" class="w-full sm:w-auto rounded-lg sm:rounded-2xl bg-indigo-600 hover:bg-indigo-500 px-4 sm:px-5 py-2.5 sm:py-2 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-indigo-600/30 transition">
            {{ $submitLabel }}
        </button>
    </div>
</form>
