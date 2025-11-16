<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول | {{ config('app.name', 'Dynamic Island') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at top, #1d4ed8, #0f172a 55%);
            min-height: 100vh;
            font-family: 'Cairo', 'Tajawal', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }
    </style>
</head>
<body class="flex items-center justify-center px-4 py-12 text-slate-100" dir="rtl">
    <div class="w-full max-w-md rounded-3xl bg-white/10 p-8 shadow-2xl backdrop-blur text-center">
        <div class="flex flex-col items-center">
            <img src="{{ asset(config('admin.brand.logo', 'logo.png')) }}" class="h-16 w-16 rounded-full border border-white/30 object-cover" alt="الشعار">
            <h1 class="mt-4 text-2xl font-semibold">مرحباً بعودتك</h1>
            <p class="mt-1 text-sm text-slate-300">سجل دخولك لإدارة لوحة التحكم</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5 text-right">
            @csrf
            <div>
                <label for="email" class="text-xs tracking-[0.4em] text-slate-400">البريد الإلكتروني</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/40"
                    placeholder="name@example.com"
                >
                @error('email')
                    <p class="mt-1 text-xs text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="text-xs tracking-[0.4em] text-slate-400">كلمة المرور</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="mt-2 w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/40"
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="mt-1 text-xs text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <label class="inline-flex items-center gap-2 text-xs text-slate-300">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/20 bg-white/10">
                تذكرني
            </label>

            <button type="submit" class="w-full rounded-2xl bg-indigo-500 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/40 hover:bg-indigo-600">
                تسجيل الدخول
            </button>
        </form>
    </div>
</body>
</html>
