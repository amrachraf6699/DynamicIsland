@php
    $title = 'الملف الشخصي';
@endphp

<x-admin.layout :title="$title">
    <x-admin.form :action="route('admin.profile.update')" method="PUT" submit-label="تحديث الملف الشخصي">
        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-[0_8px_24px_rgba(15,23,42,0.08)]">
            <div class="mb-4 border-b border-slate-200 pb-3">
                <h3 class="text-sm font-semibold text-slate-800 tracking-wide">البيانات الأساسية</h3>
                <p class="text-xs text-slate-500 mt-1">قم بتحديث اسمك وبريدك الإلكتروني.</p>
            </div>
            <div class="grid gap-3 sm:gap-4 md:gap-6 md:grid-cols-2">
                <x-admin.inputs.text name="name" label="الاسم" :value="old('name', $user->name)" required />
                <x-admin.inputs.text name="email" label="البريد الإلكتروني" :value="old('email', $user->email)" required />
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-[0_8px_24px_rgba(15,23,42,0.08)]">
            <div class="mb-4 border-b border-slate-200 pb-3">
                <h3 class="text-sm font-semibold text-slate-800 tracking-wide">تغيير كلمة المرور</h3>
                <p class="text-xs text-slate-500 mt-1">اترك الحقول فارغة إذا كنت لا تريد التغيير.</p>
            </div>
            <div class="grid gap-3 sm:gap-4 md:gap-6 md:grid-cols-2">
                <x-admin.inputs.text name="password" label="كلمة المرور الجديدة" type="password" />
                <x-admin.inputs.text name="password_confirmation" label="تأكيد كلمة المرور" type="password" />
            </div>
        </section>
    </x-admin.form>
</x-admin.layout>
