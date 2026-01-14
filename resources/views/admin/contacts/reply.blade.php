@php
    $title = 'الرد على الرسالة';
    $hasReply = !empty($contact->reply_message);
@endphp

<x-admin.layout :title="$title">
    <div class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h1 class="text-lg sm:text-xl font-extrabold tracking-tight text-slate-900">{{ $title }}</h1>

                    {{-- Status badge --}}
                    @if($hasReply)
                        <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                            <i class="bx bx-check-circle text-sm ml-1"></i>
                            تم الرد
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700">
                            <i class="bx bx-time-five text-sm ml-1"></i>
                            بانتظار الرد
                        </span>
                    @endif
                </div>

                <p class="text-xs sm:text-sm text-slate-500">
                    راجع تفاصيل الرسالة ثم اكتب ردًا احترافيًا لإرساله للمرسل.
                </p>

                {{-- Meta --}}
                @if(isset($contact->created_at))
                    <div class="text-xs text-slate-500">
                        <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-3 py-1">
                            <i class="bx bx-calendar text-sm"></i>
                            تاريخ الرسالة: {{ $contact->created_at->format('Y-m-d H:i') }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="{{ route('admin.contacts.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700
                           hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                >
                    <i class="bx bx-arrow-back text-base"></i>
                    رجوع
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

            {{-- Left: Message details --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Sender Card --}}
                <div class="rounded-3xl border border-white/30 bg-white/70 backdrop-blur-xl shadow-sm">
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-500/10 text-indigo-600">
                                    <i class="bx bx-user text-lg"></i>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-extrabold text-slate-900">بيانات المرسل</div>
                                    <div class="text-xs text-slate-500">تفاصيل التواصل الأساسية</div>
                                </div>
                            </div>

                            {{-- quick actions --}}
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    class="h-9 w-9 rounded-full border border-slate-200 bg-white text-slate-700 hover:bg-slate-50
                                           inline-flex items-center justify-center"
                                    onclick="navigator.clipboard.writeText('{{ $contact->email }}')"
                                    title="نسخ البريد"
                                >
                                    <i class="bx bx-copy text-base"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-3">
                                <span class="text-slate-500 font-semibold">الاسم</span>
                                <span class="text-slate-900 font-semibold">{{ $contact->name }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-3">
                                <span class="text-slate-500 font-semibold">البريد</span>
                                <a class="text-indigo-600 font-bold hover:underline" href="mailto:{{ $contact->email }}">
                                    {{ $contact->email }}
                                </a>
                            </div>

                            @if($contact->phone)
                                <div class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-3">
                                    <span class="text-slate-500 font-semibold">الهاتف</span>
                                    <a class="text-indigo-600 font-bold hover:underline" href="tel:{{ $contact->phone }}">
                                        {{ $contact->phone }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-slate-200/70 px-4 py-3">
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span class="inline-flex items-center gap-1">
                                <i class="bx bx-shield-quarter text-sm"></i>
                                بيانات للعرض فقط
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <i class="bx bx-lock-alt text-sm"></i>
                                آمن داخل لوحة الإدارة
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Subject Card --}}
                <div class="rounded-3xl border border-white/30 bg-white/70 backdrop-blur-xl shadow-sm">
                    <div class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500/10 text-emerald-600">
                                <i class="bx bx-message-detail text-lg"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-extrabold text-slate-900">الموضوع</div>
                                <div class="text-xs text-slate-500">عنوان الرسالة</div>
                            </div>
                        </div>

                        <div class="mt-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-900">
                            {{ $contact->subject }}
                        </div>
                    </div>
                </div>

                {{-- Original Message Card --}}
                <div class="rounded-3xl border border-white/30 bg-white/70 backdrop-blur-xl shadow-sm">
                    <div class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-500/10 text-amber-600">
                                <i class="bx bx-envelope-open text-lg"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-extrabold text-slate-900">نص الرسالة</div>
                                <div class="text-xs text-slate-500">محتوى الرسالة الواردة</div>
                            </div>
                        </div>

                        <div class="mt-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm text-slate-800 leading-7 whitespace-pre-wrap">
                            {{ $contact->message }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Reply --}}
            <div class="lg:col-span-3">
                <div class="rounded-3xl border border-white/30 bg-white/70 backdrop-blur-xl shadow-sm">
                    <div class="p-4 sm:p-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600/10 text-indigo-700">
                                    <i class="bx bx-edit-alt text-lg"></i>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-extrabold text-slate-900">كتابة الرد</div>
                                    <div class="text-xs text-slate-500">اكتب الرد ثم أرسله مباشرة</div>
                                </div>
                            </div>

                            <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-600">
                                <i class="bx bx-mail-send text-base"></i>
                                سيتم إرسال الرد عبر البريد
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.contacts.reply.send', $contact) }}" class="mt-4 space-y-4">
                            @csrf

                            <div class="rounded-3xl border border-slate-200 bg-white p-4">
                                <x-admin.inputs.rich-text
                                    name="reply_message"
                                    label="الرد"
                                    :value="old('reply_message', $contact->reply_message)"
                                    :required="false"
                                />
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <button
                                    class="inline-flex items-center justify-center gap-2 rounded-full bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white
                                           hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300/60"
                                    type="submit"
                                >
                                    <i class="bx bx-send text-base"></i>
                                    إرسال الرد
                                </button>

                                <a
                                    href="{{ route('admin.contacts.index') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700
                                           hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-300/40"
                                >
                                    <i class="bx bx-x text-lg"></i>
                                    إلغاء
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="border-t border-slate-200/70 px-4 py-3">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-slate-500">
                            <span class="inline-flex items-center gap-1">
                                <i class="bx bx-bulb text-sm"></i>
                                نصيحة: استخدم نبرة رسمية وواضحة واذكر تفاصيل المشكلة/الطلب.
                            </span>

                            <span class="inline-flex items-center gap-1">
                                <i class="bx bx-check-shield text-sm"></i>
                                سيتم حفظ الرد في السجل
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layout>
