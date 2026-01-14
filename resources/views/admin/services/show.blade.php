@php
    $title = 'تفاصيل الخدمة - ' . $service->title;
@endphp

<x-admin.layout :title="$title">
    <div class="glass-panel rounded-3xl p-5 space-y-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">الخدمة</p>
                <h1 class="text-2xl font-semibold text-slate-900">{{ $service->title }}</h1>
                <p class="mt-1 text-sm text-slate-500">إجمالي الطلبات: {{ $service->service_requests_count }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.services.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    <i class="bx bx-arrow-back"></i>
                    العودة للخدمات
                </a>
                @can('services.update')
                    <a href="{{ route('admin.services.edit', $service) }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        <i class="bx bx-edit-alt"></i>
                        تعديل الخدمة
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="mt-5 rounded-3xl border border-slate-200 bg-white shadow-sm p-5 space-y-6">
        <div class="flex flex-col gap-5 lg:flex-row">
            @if($service->cover_url)
                <div class="mx-auto h-40 w-40 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                    <img src="{{ $service->cover_url }}" alt="{{ $service->title }}" class="h-full w-full object-cover">
                </div>
            @endif
            <div class="flex-1 space-y-4">
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-100">
                        <span class="h-2 w-2 rounded-full {{ $service->is_active ? 'bg-emerald-600' : 'bg-rose-500' }}"></span>
                        {{ $service->is_active ? 'نشطة' : 'غير نشطة' }}
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-100">
                        {{ $service->featured ? 'مميزة' : 'غير مميزة' }}
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">
                        {{ $service->requestable ? 'تسمح بالطلبات' : 'الطلبات معطلة' }}
                    </span>
                </div>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">الرابط المختصر</dt>
                        <dd class="text-sm font-semibold text-slate-800">{{ $service->slug }}</dd>
                    </div>
                    @if(! is_null($service->delivery_days))
                        <div>
                            <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">أيام التسليم</dt>
                            <dd class="text-sm font-semibold text-slate-800">{{ $service->delivery_days }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">تاريخ الإنشاء</dt>
                        <dd class="text-sm font-semibold text-slate-800">
                            {{ $service->created_at?->locale('ar')->translatedFormat('d M Y - h:i a') ?? '--' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-[0.3em] text-slate-400">تاريخ التحديث</dt>
                        <dd class="text-sm font-semibold text-slate-800">
                            {{ $service->updated_at?->locale('ar')->translatedFormat('d M Y - h:i a') ?? '--' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        @if($service->content)
            <div class="prose prose-slate max-w-none text-right" dir="rtl">
                {!! $service->content !!}
            </div>
        @endif
    </div>

    <div class="mt-6 rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[640px] w-full text-right text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase tracking-[0.3em] text-slate-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">الاسم</th>
                        <th class="px-4 py-3 font-semibold">البريد الإلكتروني</th>
                        <th class="px-4 py-3 font-semibold">الهاتف</th>
                        <th class="px-4 py-3 font-semibold">تاريخ الطلب</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($requests as $request)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $request->name }}</td>
                            <td class="px-4 py-3">
                                @if($request->email)
                                    <a href="mailto:{{ $request->email }}" class="text-indigo-600 hover:underline">{{ $request->email }}</a>
                                @else
                                    <span class="text-slate-400">غير متوفر</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($request->phone_number)
                                    <span class="text-slate-800">{{ trim(($request->phone_country_code ?? '') . ' ' . $request->phone_number) }}</span>
                                @else
                                    <span class="text-slate-400">غير متوفر</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $request->created_at?->locale('ar')->translatedFormat('d M Y - h:i a') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                                لم يتم تقديم أي طلبات لهذه الخدمة بعد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $requests->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</x-admin.layout>