@php
    $title = 'الملف الشخصي';
@endphp

<x-admin.layout :title="$title">
    <x-admin.form :action="route('admin.profile.update')" method="PUT" submit-label="حفظ الملف الشخصي">
        <!-- المعلومات الأساسية -->
        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-[0_8px_24px_rgba(15,23,42,0.08)]">
            <div class="mb-4 border-b border-slate-200 pb-3">
                <h3 class="text-sm font-semibold text-slate-800 tracking-wide">المعلومات الأساسية</h3>
                <p class="text-xs text-slate-500 mt-1">يمكنك تحديث بيانات حسابك الأساسية.</p>
            </div>
            <div class="grid gap-3 sm:gap-4 md:gap-6 md:grid-cols-2">
                <x-admin.inputs.text name="name" label="الاسم" :value="old('name', $user->name)" required />
                <x-admin.inputs.text name="email" label="البريد الإلكتروني" :value="old('email', $user->email)" required />
            </div>
        </section>

        <!-- تغيير كلمة المرور -->
        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-[0_8px_24px_rgba(15,23,42,0.08)]">
            <div class="mb-4 border-b border-slate-200 pb-3">
                <h3 class="text-sm font-semibold text-slate-800 tracking-wide">تغيير كلمة المرور</h3>
                <p class="text-xs text-slate-500 mt-1">اترك الحقول فارغة إذا لا ترغب في التغيير.</p>
            </div>
            <div class="grid gap-3 sm:gap-4 md:gap-6 md:grid-cols-2">
                <x-admin.inputs.text name="password" label="كلمة المرور الجديدة" type="password" />
                <x-admin.inputs.text name="password_confirmation" label="تأكيد كلمة المرور الجديدة" type="password" />
            </div>
        </section>

        <!-- الأدوار والتصاريح -->
        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-[0_8px_24px_rgba(15,23,42,0.08)]">
            <div class="mb-4 border-b border-slate-200 pb-3">
                <h3 class="text-sm font-semibold text-slate-800 tracking-wide">الأدوار المخصصة</h3>
                <p class="text-xs text-slate-500 mt-1">تعكس الأدوار مستوى الوصول داخل لوحة التحكم.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @forelse(($roles ?? collect()) as $role)
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-100">
                        {{ $role }}
                    </span>
                @empty
                    <span class="text-xs text-slate-500">لا توجد أدوار.</span>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-[0_8px_24px_rgba(15,23,42,0.08)]">
            <div class="mb-4 border-b border-slate-200 pb-3">
                <h3 class="text-sm font-semibold text-slate-800 tracking-wide">التصاريح </h3>
                <p class="text-xs text-slate-500 mt-1">قائمة بالتصاريح الممنوحة لهذا الحساب.</p>
            </div>
            <div class="grid gap-3 sm:gap-4 md:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @forelse(($permissionsLocalized ?? collect()) as $entry)
                    <div class="rounded-xl border border-slate-200 bg-white p-3 sm:p-4">
                        <div class="mb-2 text-xs font-semibold text-slate-700">{{ $entry['resource_label'] }}</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($entry['actions'] as $actionLabel)
                                <span class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-[11px] font-medium text-slate-700 ring-1 ring-inset ring-slate-200">
                                    {{ $actionLabel }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <span class="text-xs text-slate-500">لا توجد تصاريح.</span>
                @endforelse
            </div>
        </section>
    </x-admin.form>
</x-admin.layout>
