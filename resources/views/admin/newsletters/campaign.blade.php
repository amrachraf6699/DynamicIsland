@php
    $title = 'إرسال حملة بريدية';
@endphp

<x-admin.layout :title="$title">
    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $title }}</h1>
                <p class="text-sm text-slate-500 mt-1">
                    سيتم إرسال الحملة إلى {{ $total }} {{ \Illuminate\Support\Str::plural('مشترك', $total) }}
                </p>
            </div>
            <a href="{{ route('admin.newsletters.index') }}"
                class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bx bx-arrow-back"></i>
                عودة إلى القائمة
            </a>
        </div>

        @if($total === 0)
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-700">
            لا يوجد مشتركين حالياً. أضف مشتركين أولاً قبل إرسال الحملة.
        </div>
        @endif

        <div class="glass-panel rounded-3xl p-5">
            <form method="POST" action="{{ route('admin.newsletters.campaign.send') }}" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-600" for="subject">عنوان الحملة</label>
                    <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40">
                    @error('subject')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-600" for="message">محتوى الحملة</label>
                    <textarea id="message" name="message" rows="8" required
                        class="js-richtext w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.newsletters.index') }}"
                        class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                        إلغاء
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        <i class="bx bx-send"></i>
                        إرسال
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin.layout>
