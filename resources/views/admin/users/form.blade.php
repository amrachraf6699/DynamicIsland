@php
    $isEdit = $user?->exists;
    $title = $isEdit ? 'تحرير مستخدم' : 'إنشاء مستخدم';
    $action = $isEdit ? route('admin.users.update', $user) : route('admin.users.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<x-admin.layout :title="$title">
    <x-admin.form :action="$action" :method="$method" submit-label="حفظ المستخدم">
        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-[0_8px_24px_rgba(15,23,42,0.08)] grid gap-3 sm:gap-4 md:gap-6 md:grid-cols-2">
            <x-admin.inputs.text name="name" label="الاسم" :value="old('name', $user->name)" required />
            <x-admin.inputs.text name="email" label="البريد الإلكتروني" :value="old('email', $user->email)" required />
            <x-admin.inputs.text name="password" label="كلمة المرور" type="password" />
            <x-admin.inputs.text name="password_confirmation" label="تأكيد كلمة المرور" type="password" />
            <x-admin.inputs.select name="roles" label="الأدوار" :options="$rolesOptions" :value="old('roles', $selectedRoles)" :multiple="true" :colspan="2" />
        </section>
    </x-admin.form>
</x-admin.layout>


