<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $service->meta_title ?? $service->title }} | {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col gap-8 px-4 py-10 lg:flex-row lg:gap-10">
        <section class="flex-1 space-y-6 rounded-3xl bg-white p-6 shadow-xl shadow-slate-200/50">
            <div class="space-y-3">
                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">الخدمة</p>
                <h1 class="text-3xl font-semibold text-slate-900">{{ $service->title }}</h1>
                @if($service->delivery_days)
                    <p class="text-sm text-slate-500">متوسط مدة التنفيذ: {{ $service->delivery_days }} يوم</p>
                @endif
            </div>

            @if($service->cover_url)
                <img src="{{ $service->cover_url }}" alt="{{ $service->title }}" class="w-full rounded-2xl object-cover shadow-md">
            @endif

            <article class="prose prose-slate max-w-none prose-p:leading-loose prose-headings:font-semibold prose-headings:text-slate-900 prose-p:text-slate-700 prose-a:text-indigo-600" dir="rtl">
                {!! $service->content !!}
            </article>
        </section>

        <aside class="w-full lg:w-80 {{ $stickyForm ? 'lg:sticky lg:top-8' : '' }}">
            @if(session('success'))
                <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if($service->requestable)
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-lg shadow-slate-200/60">
                    <h2 class="text-xl font-semibold text-slate-900">اطلب الخدمة الآن</h2>
                    <p class="mt-1 text-sm text-slate-500">سنقوم بالتواصل معك لتأكيد الطلب وتحديد التفاصيل.</p>

                    <form method="POST" action="{{ route('services.requests.store', $service) }}" class="mt-5 space-y-4">
                        @csrf
                        <div class="space-y-2">
                            <label for="name" class="text-xs font-semibold tracking-[0.3em] text-slate-500">الاسم الكامل</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200" placeholder="أدخل اسمك">
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-xs font-semibold tracking-[0.3em] text-slate-500">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200" placeholder="name@example.com">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-semibold tracking-[0.3em] text-slate-500">رقم الهاتف</label>
                            <div class="flex gap-2">
                                <input type="text" name="phone_country_code" value="{{ old('phone_country_code', '+20') }}" class="w-24 rounded-2xl border border-slate-200 bg-white px-3 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200" placeholder="+20">
                                <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="flex-1 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-200" placeholder="رقم الهاتف">
                            </div>
                            <p class="text-xs text-slate-400">يجب إدخال البريد أو الهاتف على الأقل.</p>
                        </div>

                        <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/40 transition hover:bg-indigo-500">إرسال الطلب</button>
                    </form>
                </div>
            @else
                <div class="rounded-3xl border border-slate-200 bg-white p-5 text-center text-sm text-slate-500">
                    هذه الخدمة لا تستقبل طلبات مباشرة حالياً.
                </div>
            @endif

            <div class="mt-6 space-y-3 rounded-3xl border border-slate-200 bg-white p-5 shadow-lg shadow-slate-200/60">
                <h3 class="text-base font-semibold text-slate-900">بيانات التواصل</h3>
                @if(!empty($contact['phones']))
                    <div>
                        <p class="text-xs font-semibold tracking-[0.3em] text-slate-500">الهاتف</p>
                        <ul class="mt-1 space-y-1 text-sm text-slate-700">
                            @foreach($contact['phones'] as $phone)
                                <li>{{ $phone }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(!empty($contact['emails']))
                    <div>
                        <p class="text-xs font-semibold tracking-[0.3em] text-slate-500">البريد</p>
                        <ul class="mt-1 space-y-1 text-sm text-slate-700">
                            @foreach($contact['emails'] as $contactEmail)
                                <li>{{ $contactEmail }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(!empty($contact['address']))
                    <div>
                        <p class="text-xs font-semibold tracking-[0.3em] text-slate-500">العنوان</p>
                        <p class="mt-1 text-sm text-slate-700">{{ $contact['address'] }}</p>
                    </div>
                @endif
            </div>
        </aside>
    </div>
</body>
</html>
