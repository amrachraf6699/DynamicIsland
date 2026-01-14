@php
    $titles = [
        'analytics' => 'تحليلات (Analytics)',
        'contact' => 'قنوات التواصل',
        'mail' => 'البريد (SMTP)',
        'social' => 'وسائل التواصل الاجتماعي',
        'notifications' => 'الإشعارات والتنبيهات',
        'website' => 'الموقع والهوية البصرية',
    ];
    $title = $titles[$group] ?? 'الإعدادات';
@endphp

<x-admin.layout :title="$title">
    <x-admin.form :action="route('admin.settings.update', $group)" method="PUT" submit-label="حفظ الإعدادات">
        @if($group === 'analytics')
            <section class="glass-panel rounded-3xl p-5 space-y-4">
                <x-admin.inputs.text name="ga_id" label="Google Analytics ID" :value="$data['ga_id'] ?? ''" />
                <x-admin.inputs.text name="meta_pixel_id" label="Meta Pixel ID" :value="$data['meta_pixel_id'] ?? ''" />
            </section>
        @elseif($group === 'contact')
            <section class="glass-panel rounded-3xl p-5 space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">أرقام الهواتف (سطر لكل رقم)</label>
                    <textarea name="phones" rows="4"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm">{{ implode("\n", $data['phones'] ?? []) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">عناوين البريد (سطر لكل بريد)</label>
                    <textarea name="emails" rows="4"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm">{{ implode("\n", $data['emails'] ?? []) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">العنوان</label>
                    <textarea name="address" rows="3"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm">{{ $data['address'] ?? '' }}</textarea>
                </div>
            </section>
        @elseif($group === 'mail')
            <section class="glass-panel rounded-3xl p-5 grid gap-4 sm:grid-cols-2">
                <x-admin.inputs.text name="host" label="SMTP Host" :value="$data['host'] ?? ''" />
                <x-admin.inputs.text name="port" label="SMTP Port" :value="$data['port'] ?? ''" />
                <x-admin.inputs.text name="username" label="اسم المستخدم" :value="$data['username'] ?? ''" />
                <x-admin.inputs.text name="password" label="كلمة المرور" :value="$data['password'] ?? ''" />
                <x-admin.inputs.text name="encryption" label="التشفير (tls/ssl)" :value="$data['encryption'] ?? ''" />
                <x-admin.inputs.text name="from_address" label="عنوان الإرسال" :value="$data['from_address'] ?? ''" />
                <x-admin.inputs.text name="from_name" label="اسم المرسل" :value="$data['from_name'] ?? ''" />
            </section>
        @elseif($group === 'social')
            <section class="glass-panel rounded-3xl p-5 grid gap-4 sm:grid-cols-2">
                <x-admin.inputs.text name="facebook" label="Facebook" :value="$data['facebook'] ?? ''" />
                <x-admin.inputs.text name="instagram" label="Instagram" :value="$data['instagram'] ?? ''" />
                <x-admin.inputs.text name="x" label="X (Twitter)" :value="$data['x'] ?? ''" />
                <x-admin.inputs.text name="linkedin" label="LinkedIn" :value="$data['linkedin'] ?? ''" />
                <x-admin.inputs.text name="whatsapp" label="WhatsApp" :value="$data['whatsapp'] ?? ''" />
                <x-admin.inputs.text name="youtube" label="YouTube" :value="$data['youtube'] ?? ''" />
                <x-admin.inputs.text name="tiktok" label="TikTok" :value="$data['tiktok'] ?? ''" />
            </section>
        @elseif($group === 'notifications')
            <section class="glass-panel rounded-3xl p-5 space-y-4">
                <x-admin.inputs.toggle name="notify_admins_contact_submit" label="تنبيه المدراء عند استقبال رسالة جديدة"
                    :value="$data['notify_admins_contact_submit'] ?? false" />
                <x-admin.inputs.toggle name="notify_user_contact_submit" label="إرسال إشعار للعميل عند استلام الطلب"
                    :value="$data['notify_user_contact_submit'] ?? false" />
                <x-admin.inputs.toggle name="notify_admins_contact_reply" label="تنبيه المدراء عند الرد على الرسائل"
                    :value="$data['notify_admins_contact_reply'] ?? false" />
                <x-admin.inputs.toggle name="notify_user_contact_reply" label="إرسال نسخة إلى العميل عند الرد"
                    :value="$data['notify_user_contact_reply'] ?? false" />
                <x-admin.inputs.toggle name="notify_admins_service_request" label="تنبيه المدراء عند وصول طلب خدمة"
                    :value="$data['notify_admins_service_request'] ?? false" />
                <x-admin.inputs.toggle name="notify_user_service_request" label="إشعار العميل باستلام طلب الخدمة"
                    :value="$data['notify_user_service_request'] ?? false" />
            </section>
        @elseif($group === 'website')
            <section class="glass-panel rounded-3xl p-5 grid gap-4 sm:grid-cols-2">
                <x-admin.inputs.text name="name" label="اسم الموقع" :value="$data['name'] ?? ''" required />

                <x-admin.inputs.text name="tagline" label="الوصف المختصر (سطر تعريفي)" :value="$data['tagline'] ?? ''" />

                <x-admin.inputs.text name="meta_title" label="عنوان الميتا (Meta Title)" :value="$data['meta_title'] ?? ''"
                    colspan="2" />

                <div class="space-y-2 text-right sm:col-span-2">
                    <label class="text-xs font-semibold tracking-widest text-slate-600" for="meta_description">
                        وصف الميتا (Meta Description)
                    </label>

                    <textarea id="meta_description" name="meta_description" rows="3"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40">{{ $data['meta_description'] ?? '' }}</textarea>

                    <p class="text-xs text-slate-400">
                        يظهر في نتائج محركات البحث. يفضّل أن يكون بين 150–160 حرفًا.
                    </p>
                </div>

                <x-admin.inputs.text name="meta_keywords" label="الكلمات المفتاحية (Meta Keywords)"
                    :value="$data['meta_keywords'] ?? ''" placeholder="كلمة مفتاحية، كلمة أخرى" colspan="2" />

                <x-admin.inputs.file name="logo" label="شعار الموقع" :value="$data['logo'] ?? ''" colspan="2" />

                <x-admin.inputs.file name="favicon" label="أيقونة الموقع (Favicon)" :value="$data['favicon'] ?? ''"
                    colspan="2" />
            </section>


            <section class="glass-panel rounded-3xl p-5 grid gap-4 sm:grid-cols-3">
                <x-admin.inputs.text type="color" name="primary_color" label="اللون الرئيسي" :value="$data['primary_color'] ?? '#6f7bf7'" />
                <x-admin.inputs.text type="color" name="primary_dark_color" label="اللون الرئيسي الداكن"
                    :value="$data['primary_dark_color'] ?? '#5a66e8'" />
                <x-admin.inputs.text type="color" name="secondary_color" label="اللون الثانوي"
                    :value="$data['secondary_color'] ?? '#22c55e'" />
                <x-admin.inputs.text type="color" name="accent_color" label="لون المساندة" :value="$data['accent_color'] ?? '#0ea5e9'" />
                <x-admin.inputs.text type="color" name="surface_color" label="لون الخلفيات" :value="$data['surface_color'] ?? '#f6f7fb'" />
                <x-admin.inputs.text type="color" name="text_color" label="لون النصوص" :value="$data['text_color'] ?? '#111827'" />
            </section>

            <section class="glass-panel rounded-3xl p-5 space-y-4">
                <x-admin.inputs.toggle name="contact_form_enabled" label="تفعيل نموذج التواصل بالموقع"
                    :value="$data['contact_form_enabled'] ?? true" />
                <x-admin.inputs.toggle name="sticky_service_request" label="تثبيت نموذج طلب الخدمة"
                    :value="$data['sticky_service_request'] ?? false" />
            </section>
        @endif
    </x-admin.form>
</x-admin.layout>