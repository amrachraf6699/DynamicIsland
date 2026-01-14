@php
    $brand = config('admin.brand', []);
    $websiteSettings = config('settings.website', []);
    $colors = array_merge([
        'primary' => '#6f7bf7',
        'primary_dark' => '#5a66e8',
        'secondary' => '#22c55e',
        'accent' => '#0ea5e9',
        'surface' => '#f6f7fb',
        'text' => '#111827',
    ], $websiteSettings['colors'] ?? []);
    $fontConfig = $websiteSettings['font'] ?? [];
    $fontFamily = $fontConfig['font_family'] ?? "\"Cairo\", system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif";
    @if($fontStylesheet)
        <link href="{{ $fontStylesheet }}" rel="stylesheet">
    @endif
    $logoSource = $brand['logo'] ?? 'logo.png';
    $logo = \Illuminate\Support\Str::startsWith($logoSource, ['http://', 'https://']) ? $logoSource : asset($logoSource);
    $favicon = $websiteSettings['favicon_url'] ?? null;
    $faviconHref = $favicon ? (\Illuminate\Support\Str::startsWith($favicon, ['http://', 'https://']) ? $favicon : asset(ltrim($favicon, '/'))) : null;
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول | {{ config('app.name', 'Dynamic Island') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if($faviconHref)
        <link rel="icon" type="image/png" href="{{ $faviconHref }}">
    @endif

    <style>
        :root {
            --color-primary: {{ $colors['primary'] }};
            --color-primary-dark: {{ $colors['primary_dark'] }};
            --color-secondary: {{ $colors['secondary'] }};
            --color-accent: {{ $colors['accent'] }};
            --color-border: #e7eaf3;
            --color-panel: rgba(255, 255, 255, 0.96);
            --color-text: {{ $colors['text'] }};
            --color-muted: #6b7280;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: {{ $fontFamily }};
            background: radial-gradient(1200px 500px at 80% -10%, color-mix(in srgb, var(--color-primary) 20%, transparent) 0%, var(--color-panel) 55%, #f9fafb 100%);
            min-height: 100vh;
            color: var(--color-text);
            overflow-x: hidden;
        }

        .auth-backdrop {
            position: absolute;
            border-radius: 9999px;
            filter: blur(90px);
            opacity: 0.55;
            z-index: 1;
        }

        .auth-backdrop--one {
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, color-mix(in srgb, var(--color-primary) 55%, transparent), transparent 65%);
            top: -80px;
            left: 5%;
        }

        .auth-backdrop--two {
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, color-mix(in srgb, var(--color-accent) 35%, transparent), transparent 65%);
            bottom: -120px;
            right: 0;
        }

        .glass-panel {
            background: var(--color-panel);
            border: 1px solid var(--color-border);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
            border-radius: 1.75rem;
        }

        .outer-shell {
            border-radius: 2.5rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(231, 234, 243, 0.65);
            box-shadow: 0 40px 80px rgba(79, 70, 229, 0.08);
            backdrop-filter: blur(18px);
        }

        @media (min-width: 1024px) {
            .outer-shell {
                padding: 2.25rem;
            }
        }

        .illustration-card {
            border-radius: 1.75rem;
            background: linear-gradient(135deg, rgba(111, 123, 247, 0.95), rgba(56, 189, 248, 0.85));
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .illustration-card::after {
            content: '';
            position: absolute;
            inset: 20px;
            border-radius: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
            opacity: 0.65;
            pointer-events: none;
        }

        .brand-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.18);
            box-shadow: inset 0 10px 30px rgba(15, 23, 42, 0.15);
        }

        .brand-chip img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .check-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.12);
        }

        .check-icon svg {
            width: 16px;
            height: 16px;
            stroke-width: 2.4;
        }

        .form-card {
            padding: 1.75rem;
            background: rgba(255, 255, 255, 0.95);
        }

        @media (min-width: 768px) {
            .form-card {
                padding: 2.25rem;
            }
        }

        .label-text {
            font-size: 0.78rem;
            letter-spacing: 0.28em;
            font-weight: 600;
            color: var(--color-muted);
        }

        .input-field {
            width: 100%;
            margin-top: 0.5rem;
            border-radius: 1.25rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            background: rgba(255, 255, 255, 0.9);
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            color: var(--color-text);
            transition: all 0.2s ease;
        }

        .input-field::placeholder {
            color: #94a3b8;
        }

        .input-field:focus {
            outline: none;
            background: #fff;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(111, 123, 247, 0.18);
        }

        .toggle-visibility {
            position: absolute;
            top: 50%;
            inset-inline-start: 1rem;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 9999px;
            border: none;
            background: transparent;
            color: var(--color-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: color 0.2s ease, background 0.2s ease;
        }

        .toggle-visibility:hover {
            color: var(--color-primary);
            background: color-mix(in srgb, var(--color-primary) 15%, transparent);
        }

        .remember-check {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--color-muted);
        }

        .remember-check input {
            width: 1.1rem;
            height: 1.1rem;
            border-radius: 0.4rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            accent-color: var(--color-primary);
        }

        .submit-btn {
            width: 100%;
            border-radius: 1.25rem;
            padding: 0.95rem 1rem;
            background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 25px 45px color-mix(in srgb, var(--color-primary-dark) 25%, transparent);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 30px 55px color-mix(in srgb, var(--color-primary-dark) 35%, transparent);
        }

        .submit-btn:focus {
            outline: none;
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--color-primary) 20%, transparent);
        }
    </style>
</head>
<body class="relative min-h-screen" dir="rtl">
    <span class="auth-backdrop auth-backdrop--one"></span>
    <span class="auth-backdrop auth-backdrop--two"></span>

    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-5xl">
            <div class="glass-panel outer-shell">
                <div class="grid items-stretch gap-6 lg:gap-8 lg:grid-cols-[1.05fr_0.95fr]">
                    <section class="illustration-card p-6 text-right text-white md:p-8">
                        <div class="relative z-10 flex h-full flex-col">
                            <div class="flex items-center justify-end gap-4">
                                <span class="brand-chip">
                                    <img src="{{ $logo }}" alt="شعار العلامة" loading="lazy">
                                </span>
                                <div class="text-right">
                                    <p class="text-xs tracking-[0.32em] text-white/70">منصة إدارة المحتوى</p>
                                    <p class="text-xl font-semibold">{{ $brand['name'] ?? config('app.name', 'Dynamic Island') }}</p>
                                </div>
                            </div>

                            <h1 class="mt-8 text-3xl font-semibold leading-relaxed">مرحباً بعودتك إلى لوحة التحكم</h1>
                            <p class="mt-3 text-sm leading-7 text-white/80">تحكّم في الصفحات، الفرق، والمحتوى من مركز واحد بواجهة سريعة وسلسة.</p>

                            <ul class="mt-8 space-y-3 text-sm leading-7 text-white/90">
                                <li class="flex items-center justify-end gap-3">
                                    <span class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span>أمان عالي للبيانات والمهام</span>
                                </li>
                                <li class="flex items-center justify-end gap-3">
                                    <span class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                        </svg>
                                    </span>
                                    <span>إدارة متقدمة للأقسام والفرق</span>
                                </li>
                                <li class="flex items-center justify-end gap-3">
                                    <span class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16m-8-8v16" />
                                        </svg>
                                    </span>
                                    <span>تحديثات فورية وإشعارات مباشرة</span>
                                </li>
                            </ul>

                            <div class="mt-auto flex items-center justify-end gap-3 pt-8 text-xs text-white/80">
                                <div class="rounded-2xl border border-white/30 bg-white/10 px-4 py-3 text-center">
                                    <p class="text-2xl font-semibold">24/7</p>
                                    <p>دعم متواصل</p>
                                </div>
                                <div class="rounded-2xl border border-white/30 bg-white/10 px-4 py-3 text-center">
                                    <p class="text-2xl font-semibold">+120</p>
                                    <p>مشروعاً نشطاً</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="glass-panel form-card text-right">
                        <div>
                            <p class="label-text">أهلاً بك</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-900">تسجيل الدخول إلى الحساب</h2>
                        </div>

                        <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-5">
                            @csrf

                            <div>
                                <label for="email" class="label-text">البريد الإلكتروني</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    class="input-field"
                                    placeholder="name@example.com"
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="label-text">كلمة المرور</label>
                                <div class="password-wrapper">
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        required
                                        class="input-field"
                                        placeholder="********"
                                    >
                                </div>
                                @error('password')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <label class="remember-check">
                                <input type="checkbox" name="remember">
                                <span>تذكرني</span>
                            </label>

                            <button type="submit" class="submit-btn">
                                تسجيل الدخول
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
