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
            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-indigo-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">أدوات التحليل</h3>
                    <p class="text-xs text-slate-500 mt-1">إعدادات تتبع وتحليل زوار الموقع</p>
                </div>
                <x-admin.inputs.text name="ga_id" label="معرّف جوجل أناليتكس" :value="$data['ga_id'] ?? ''" />
                <x-admin.inputs.text name="meta_pixel_id" label="معرّف بكسل ميتا" :value="$data['meta_pixel_id'] ?? ''" />
            </section>

        @elseif($group === 'contact')
            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-emerald-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">معلومات التواصل</h3>
                    <p class="text-xs text-slate-500 mt-1">بيانات الاتصال الظاهرة للعملاء</p>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">أرقام الهواتف</label>
                    <textarea name="phones" rows="4" placeholder="أدخل رقم هاتف في كل سطر"
                        class="w-full rounded-2xl border border-slate-200 px-5 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all">{{ implode("\n", $data['phones'] ?? []) }}</textarea>
                    <p class="text-xs text-slate-400">سطر واحد لكل رقم هاتف</p>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">عناوين البريد الإلكتروني</label>
                    <textarea name="emails" rows="4" placeholder="أدخل بريد إلكتروني في كل سطر"
                        class="w-full rounded-2xl border border-slate-200 px-5 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all">{{ implode("\n", $data['emails'] ?? []) }}</textarea>
                    <p class="text-xs text-slate-400">سطر واحد لكل عنوان بريد</p>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">العنوان الفعلي</label>
                    <textarea name="address" rows="3" placeholder="أدخل العنوان الكامل"
                        class="w-full rounded-2xl border border-slate-200 px-5 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all">{{ $data['address'] ?? '' }}</textarea>
                </div>
            </section>

        @elseif($group === 'mail')
            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-blue-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">إعدادات البريد الإلكتروني</h3>
                    <p class="text-xs text-slate-500 mt-1">تكوين خادم SMTP لإرسال الرسائل</p>
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <x-admin.inputs.text name="host" label="عنوان الخادم (SMTP Host)" :value="$data['host'] ?? ''" />
                    <x-admin.inputs.text name="port" label="منفذ الخادم (SMTP Port)" :value="$data['port'] ?? ''" />
                    <x-admin.inputs.text name="username" label="اسم المستخدم" :value="$data['username'] ?? ''" />
                    <x-admin.inputs.text name="password" label="كلمة المرور" :value="$data['password'] ?? ''" />
                    <x-admin.inputs.text name="encryption" label="نوع التشفير (tls/ssl)" :value="$data['encryption'] ?? ''" />
                    <x-admin.inputs.text name="from_address" label="عنوان البريد المرسل" :value="$data['from_address'] ?? ''" />
                    <x-admin.inputs.text name="from_name" label="اسم المرسل" :value="$data['from_name'] ?? ''" />
                </div>
            </section>

        @elseif($group === 'social')
            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-pink-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">روابط التواصل الاجتماعي</h3>
                    <p class="text-xs text-slate-500 mt-1">حسابات المنصات الاجتماعية</p>
                </div>
                <div class="grid gap-6 sm:grid-cols-2">
                    <x-admin.inputs.text name="facebook" label="فيسبوك (Facebook)" :value="$data['facebook'] ?? ''" />
                    <x-admin.inputs.text name="instagram" label="إنستغرام (Instagram)" :value="$data['instagram'] ?? ''" />
                    <x-admin.inputs.text name="x" label="إكس (X - تويتر سابقاً)" :value="$data['x'] ?? ''" />
                    <x-admin.inputs.text name="linkedin" label="لينكد إن (LinkedIn)" :value="$data['linkedin'] ?? ''" />
                    <x-admin.inputs.text name="whatsapp" label="واتساب (WhatsApp)" :value="$data['whatsapp'] ?? ''" />
                    <x-admin.inputs.text name="youtube" label="يوتيوب (YouTube)" :value="$data['youtube'] ?? ''" />
                    <x-admin.inputs.text name="tiktok" label="تيك توك (TikTok)" :value="$data['tiktok'] ?? ''" />
                </div>
            </section>

        @elseif($group === 'notifications')
            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-amber-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">إعدادات الإشعارات</h3>
                    <p class="text-xs text-slate-500 mt-1">التحكم في التنبيهات البريدية</p>
                </div>
                
                <div class="space-y-5">
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <h4 class="text-sm font-bold text-slate-700 mb-4">إشعارات نموذج التواصل</h4>
                        <div class="space-y-4">
                            <x-admin.inputs.toggle name="notify_admins_contact_submit" label="تنبيه المدراء عند استقبال رسالة جديدة"
                                :value="$data['notify_admins_contact_submit'] ?? false" />
                            <x-admin.inputs.toggle name="notify_user_contact_submit" label="إرسال إشعار للعميل عند استلام الطلب"
                                :value="$data['notify_user_contact_submit'] ?? false" />
                            <x-admin.inputs.toggle name="notify_admins_contact_reply" label="تنبيه المدراء عند الرد على الرسائل"
                                :value="$data['notify_admins_contact_reply'] ?? false" />
                            <x-admin.inputs.toggle name="notify_user_contact_reply" label="إرسال نسخة إلى العميل عند الرد"
                                :value="$data['notify_user_contact_reply'] ?? false" />
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <h4 class="text-sm font-bold text-slate-700 mb-4">إشعارات طلبات الخدمات</h4>
                        <div class="space-y-4">
                            <x-admin.inputs.toggle name="notify_admins_service_request" label="تنبيه المدراء عند وصول طلب خدمة"
                                :value="$data['notify_admins_service_request'] ?? false" />
                            <x-admin.inputs.toggle name="notify_user_service_request" label="إشعار العميل باستلام طلب الخدمة"
                                :value="$data['notify_user_service_request'] ?? false" />
                        </div>
                    </div>
                </div>
            </section>

        @elseif($group === 'website')
            @php
                $fontOptions = ($fonts ?? collect())->pluck('name', 'id');
                $selectedFont = ($fonts ?? collect())->firstWhere('id', $data['font_id'] ?? null);
                $selectedFontFamily = $selectedFont->font_family ?? 'Cairo, "Helvetica Neue", Arial, sans-serif';
            @endphp

            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-purple-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">معلومات الموقع الأساسية</h3>
                    <p class="text-xs text-slate-500 mt-1">البيانات العامة والهوية الرقمية</p>
                </div>
                
                <div class="grid gap-6 sm:grid-cols-2">
                    <x-admin.inputs.text name="name" label="اسم الموقع" :value="$data['name'] ?? ''" required />
                    <x-admin.inputs.text name="tagline" label="الوصف المختصر (سطر تعريفي)" :value="$data['tagline'] ?? ''" />
                </div>

                <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-2xl p-6 border border-slate-200">
                    <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        تحسين محركات البحث (SEO)
                    </h4>
                    <div class="space-y-5">
                        <x-admin.inputs.text name="meta_title" label="عنوان صفحة البحث (Meta Title)" :value="$data['meta_title'] ?? ''" />
                        
                        <div class="space-y-2 text-right">
                            <label class="text-sm font-semibold text-slate-700" for="meta_description">
                                وصف صفحة البحث (Meta Description)
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="3" placeholder="اكتب وصفاً جذاباً يظهر في نتائج البحث..."
                                class="w-full rounded-2xl border border-slate-200 px-5 py-3 text-sm text-slate-700 shadow-sm focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all">{{ $data['meta_description'] ?? '' }}</textarea>
                            <p class="text-xs text-slate-400">
                                يظهر في نتائج محركات البحث. يُفضّل أن يكون بين 150–160 حرفاً.
                            </p>
                        </div>

                        <x-admin.inputs.text name="meta_keywords" label="الكلمات المفتاحية (Meta Keywords)"
                            :value="$data['meta_keywords'] ?? ''" placeholder="كلمة مفتاحية، كلمة أخرى، المزيد..." />
                    </div>
                </div>
            </section>

            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-cyan-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">الخط والطباعة</h3>
                    <p class="text-xs text-slate-500 mt-1">اختيار وتخصيص خط الموقع</p>
                </div>

                <x-admin.inputs.select name="font_id" label="الخط الرئيسي للموقع" :options="$fontOptions" :value="$data['font_id'] ?? ''"
                    placeholder="اختر خطاً من القائمة المحددة" required />

                <div class="space-y-3 text-right">
                    <label class="text-sm font-semibold text-slate-700" for="font-preview-input">معاينة الخط</label>
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <textarea id="font-preview-input" 
                                rows="3"
                                class="w-full rounded-2xl border-2 border-slate-200 bg-white px-5 py-3 text-sm text-slate-800 shadow-sm focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 transition-all resize-none" 
                                placeholder="ابدأ الكتابة لمعاينة الخط..." 
                                style="font-family: {{ $selectedFontFamily }};"></textarea>
                        </div>
                        <div id="font-preview-box" 
                            class="w-full rounded-2xl border-2 border-slate-200 bg-gradient-to-br from-slate-50 to-slate-100 px-5 py-4 text-base text-slate-800 shadow-inner min-h-[5rem] flex items-start" 
                            style="font-family: {{ $selectedFontFamily }};">
                            ابدأ الكتابة لمشاهدة شكل الخط المختار
                        </div>
                    </div>
                </div>
            </section>

            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-rose-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">الشعار والأيقونة</h3>
                    <p class="text-xs text-slate-500 mt-1">رفع الملفات المرئية للموقع</p>
                </div>
                <div class="grid gap-6 lg:grid-cols-2">
                    <x-admin.inputs.file name="logo" label="شعار الموقع (Logo)" :value="$data['logo'] ?? ''" />
                    <x-admin.inputs.file name="favicon" label="أيقونة الموقع (Favicon)" :value="$data['favicon'] ?? ''" />
                </div>
            </section>

            <section class="glass-panel rounded-3xl p-8 space-y-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-violet-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">ألوان الموقع</h3>
                    <p class="text-xs text-slate-500 mt-1">لوحة الألوان الأساسية</p>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="space-y-2">
                        <x-admin.inputs.text type="color" name="primary_color" label="اللون الرئيسي" :value="$data['primary_color'] ?? '#6f7bf7'" />
                        <p class="text-xs text-slate-400">اللون الأساسي للعلامة التجارية</p>
                    </div>
                    <div class="space-y-2">
                        <x-admin.inputs.text type="color" name="primary_dark_color" label="اللون الرئيسي الداكن"
                            :value="$data['primary_dark_color'] ?? '#5a66e8'" />
                        <p class="text-xs text-slate-400">نسخة داكنة من اللون الرئيسي</p>
                    </div>
                    <div class="space-y-2">
                        <x-admin.inputs.text type="color" name="secondary_color" label="اللون الثانوي"
                            :value="$data['secondary_color'] ?? '#22c55e'" />
                        <p class="text-xs text-slate-400">اللون المساعد الثاني</p>
                    </div>
                    <div class="space-y-2">
                        <x-admin.inputs.text type="color" name="accent_color" label="لون التمييز" :value="$data['accent_color'] ?? '#0ea5e9'" />
                        <p class="text-xs text-slate-400">للتأكيد على العناصر المهمة</p>
                    </div>
                    <div class="space-y-2">
                        <x-admin.inputs.text type="color" name="surface_color" label="لون الخلفيات" :value="$data['surface_color'] ?? '#f6f7fb'" />
                        <p class="text-xs text-slate-400">خلفية البطاقات والأسطح</p>
                    </div>
                    <div class="space-y-2">
                        <x-admin.inputs.text type="color" name="text_color" label="لون النصوص" :value="$data['text_color'] ?? '#111827'" />
                        <p class="text-xs text-slate-400">لون النص الأساسي</p>
                    </div>
                </div>
            </section>

            <section class="glass-panel rounded-3xl p-8 space-y-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="border-r-4 border-teal-500 pr-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-800">إعدادات النماذج</h3>
                    <p class="text-xs text-slate-500 mt-1">التحكم في نماذج الموقع التفاعلية</p>
                </div>
                <div class="space-y-4">
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <x-admin.inputs.toggle name="contact_form_enabled" label="تفعيل نموذج التواصل في الموقع"
                            :value="$data['contact_form_enabled'] ?? true" />
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                        <x-admin.inputs.toggle name="sticky_service_request" label="تثبيت نموذج طلب الخدمة (عائم)"
                            :value="$data['sticky_service_request'] ?? false" />
                    </div>
                </div>
            </section>

            @php
                $fontsJson = ($fonts ?? collect())->keyBy('id')->map(function($font) {
                    return [
                        'id' => $font->id,
                        'name' => $font->name,
                        'family' => $font->font_family,
                        'stylesheet_url' => $font->stylesheet_url,
                    ];
                })->toArray();
            @endphp
        <script>
        const initializeFontPreview = () => {
            const fontsData = @json($fontsJson);

            // Try multiple selectors to find the font select element
            const select = document.querySelector('select[name="font_id"]') || 
                        document.getElementById('font_id') ||
                        document.querySelector('[name="font_id"]');
            
            const previewBox = document.getElementById('font-preview-box');
            const previewInput = document.getElementById('font-preview-input');
            const defaultPreview = previewBox ? previewBox.textContent : '';

            const ensureLink = (font) => {
                if (!font || !font.stylesheet_url) return;
                const id = 'font-preview-link';
                let link = document.getElementById(id);
                if (!link) {
                    link = document.createElement('link');
                    link.id = id;
                    link.rel = 'stylesheet';
                    document.head.appendChild(link);
                }
                if (link.href !== font.stylesheet_url) {
                    link.href = font.stylesheet_url;
                }
            };

            const updatePreview = () => {
                if (!select || !previewBox) {
                    return;
                }
                
                const selectedValue = select.value;
                
                const selected = fontsData[selectedValue] || null;
                
                if (selected) {
                    ensureLink(selected);
                    previewBox.style.fontFamily = selected.family;
                    if (previewInput) {
                        previewInput.style.fontFamily = selected.family;
                    }
                }
            };

            // Handle preview input typing
            if (previewInput && previewBox) {
                previewInput.addEventListener('input', () => {
                    previewBox.textContent = previewInput.value || defaultPreview;
                });
            }

            // Setup event listeners for select element
            const setupSelectListeners = () => {
                if (!select) {
                    console.error('Font select element not found!');
                    return;
                }

                // Check if jQuery and Select2 are available
                if (window.jQuery && typeof jQuery(select).select2 === 'function') {
                    
                    // Use jQuery to listen to Select2 events
                    jQuery(select).on('select2:select', function(e) {
                        updatePreview();
                    });
                    
                    jQuery(select).on('change', function(e) {
                        updatePreview();
                    });
                } else {
                    // Fallback to standard DOM events
                    select.addEventListener('change', updatePreview);
                    select.addEventListener('input', updatePreview);
                }

                // Initial update after a short delay
                setTimeout(updatePreview, 300);
            };

            // Wait for Select2 to initialize if it hasn't yet
            const waitForSelect2 = () => {
                if (window.jQuery && select && jQuery(select).data('select2')) {
                    setupSelectListeners();
                    updatePreview();
                } else if (select) {
                    setTimeout(waitForSelect2, 100);
                }
            };

            // Start the initialization
            if (window.jQuery) {
                waitForSelect2();
            } else {
                // jQuery not available, use standard events
                setupSelectListeners();
                updatePreview();
            }
        };

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeFontPreview);
        } else {
            initializeFontPreview();
        }
        </script>
        @endif
    </x-admin.form>
</x-admin.layout>
