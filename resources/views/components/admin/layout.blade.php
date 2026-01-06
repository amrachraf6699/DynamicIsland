@props([
    'title' => config('app.name', 'لوحة التحكم'),
])

@php
    use Illuminate\Support\Facades\Route;

    $brand = config('admin.brand', []);
    $resources = collect(config('admin.resources', []))
        ->filter(function ($resource) {
            $routeName = $resource['route'] ?? null;
            if ($routeName === 'admin.dashboard') {
                return true;
            }
            if (!auth()->check() || !$routeName) {
                return false;
            }
            $parts = explode('.', $routeName);
            $resourceKey = $parts[1] ?? null;
            return $resourceKey && auth()->user()->can($resourceKey . '.read');
        })
        ->values()
        ->all();
    $logo = asset($brand['logo'] ?? 'logo.png');
    $loading = asset($brand['loading'] ?? 'loading.gif');
    $boxIcons = [
        'home' => 'bx-home-alt-2',
        'rectangle-group' => 'bx-category-alt',
        'document-text' => 'bx-file',
        'puzzle-piece' => 'bx-extension',
        'sparkles' => 'bx-star',
        'briefcase' => 'bx-briefcase',
        'chat-bubble-left-ellipsis' => 'bx-message-dots',
        'photo' => 'bx-image-alt',
        'users' => 'bx-group',
        'view-columns' => 'bx-layout',
        'newspaper' => 'bx-news',
        'chart-bar' => 'bx-bar-chart',
        'receipt-percent' => 'bx-receipt',
        'square-3-stack-3d' => 'bx-grid',
        'handshake' => 'bx-handshake',
        'trophy' => 'bx-trophy',
        'heart' => 'bx-heart',
    ];
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>{{ $title }} | {{ $brand['name'] ?? config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.full.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script> --}}
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #6f7bf7;
            --color-primary-dark: #5a66e8;
            --color-secondary: #22c55e;
            --color-bg: #f6f7fb;
            --color-surface: #ffffff;
            --color-border: #e7eaf3;
            --color-text: #1f2937;
            --color-text-muted: #6b7280;
            --color-panel: #ffffff;
            --color-panel-soft: #f5f7ff;
        }

        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: 'Cairo', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: radial-gradient(1200px 500px at 80% -10%, #eef1ff 0%, #f6f7fb 55%, #f9fafb 100%);
            min-height: 100vh;
            color: var(--color-text);
            overflow-x: hidden;
        }

        .glass-panel {
            background: var(--color-panel);
            border: 1px solid var(--color-border);
            box-shadow: 0 12px 32px rgba(31, 41, 55, 0.08);
            transition: all 0.3s ease;
        }

        .glass-panel:hover {
            border-color: rgba(111, 123, 247, 0.35);
            box-shadow: 0 18px 40px rgba(79, 70, 229, 0.12);
        }

        .scroll-thin::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .scroll-thin::-webkit-scrollbar-track {
            background: rgba(17, 24, 39, 0.05);
        }

        .scroll-thin::-webkit-scrollbar-thumb {
            background: rgba(111, 123, 247, 0.4);
            border-radius: 999px;
            transition: background 0.3s ease;
        }

        .scroll-thin::-webkit-scrollbar-thumb:hover {
            background: rgba(111, 123, 247, 0.65);
        }

        .select2-container--default .select2-selection--single {
            border-radius: 0.75rem;
            border: 1px solid var(--color-border);
            background-color: var(--color-panel);
            color: var(--color-text);
            height: 44px;
            padding: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            color: var(--color-text);
        }

        .select2-dropdown {
            background-color: var(--color-panel);
            border: 1px solid var(--color-border);
            border-radius: 0.75rem;
        }

        .select2-results__option {
            color: var(--color-text);
        }

        .select2-results__option--highlighted {
            background-color: var(--color-primary) !important;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 768px) {
            body {
                padding: 0;
                margin: 0;
            }
        }
    </style>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('layoutState', () => ({
                // Sidebar is open and expanded by default on desktop, hidden on mobile
                sidebarOpen: window.innerWidth >= 1024,
                sidebarCollapsed: false,
                init() {
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 1024) {
                            // Ensure the sidebar is visible and expanded on desktop
                            this.sidebarOpen = true;
                            this.sidebarCollapsed = false;
                        } else {
                            // Hide sidebar entirely on mobile; use burger to open
                            this.sidebarOpen = false;
                        }
                    });
                },
            }));
        });
    </script>
</head>
<body x-data="layoutState()" x-init="init()" dir="rtl" class="antialiased">
    <!-- Mobile overlay for sidebar -->
    <div class="fixed inset-0 z-30 bg-slate-900/40 lg:hidden transition-opacity duration-300" 
         x-show="sidebarOpen" 
         x-cloak 
         @click="sidebarOpen = false">
    </div>

    <!-- Loading indicator -->
    <div class="pointer-events-none fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50" id="global-loader">
        <img src="{{ $loading }}" alt="جاري التحميل" class="h-20 w-20 sm:h-28 sm:w-28 animate-pulse drop-shadow-lg">
    </div>

    <!-- Improved responsive sidebar with better mobile handling -->
    <aside
        class="glass-panel scroll-thin fixed inset-y-0 right-0 z-40 flex flex-col border border-slate-200 transition-all duration-300 ease-out lg:translate-x-0"
        :class="[
            sidebarOpen ? 'translate-x-0' : 'translate-x-full',
            sidebarCollapsed ? 'w-20 sm:w-24' : 'w-72 sm:w-80'
        ]"
    >
        <!-- Sidebar Header -->
        <div class="flex items-center gap-2 sm:gap-3 border-b border-white/10 px-3 sm:px-5 py-3 sm:py-4 flex-shrink-0">
            <img src="{{ $logo }}" alt="شعار الإدارة" class="h-10 sm:h-12 w-10 sm:w-12 rounded-xl sm:rounded-2xl border-2 border-indigo-400 object-cover flex-shrink-0">
            <div class="flex-1 min-w-0" x-cloak x-show="!sidebarCollapsed">
                <p class="text-xs tracking-[0.3em] text-black truncate">إدارة</p>
                <p class="text-base sm:text-lg font-semibold text-indigo-700 truncate">{{ $brand['name'] ?? config('app.name') }}</p>
            </div>
            <button
                class="flex items-center justify-center
                    w-4 h-4 sm:w-8 sm:h-8
                    rounded-full
                    bg-indigo-500/10 text-indigo-300
                    transition hover:bg-indigo-500/20
                    flex-shrink-0"
                @click="sidebarCollapsed = !sidebarCollapsed"
                :title="sidebarCollapsed ? 'توسيع القائمة' : 'طي القائمة'"
            >
                <i
                    class="bx text-lg sm:text-xl"
                    :class="sidebarCollapsed ? 'bx-chevrons-left' : 'bx-chevrons-right'"
                ></i>
            </button>

        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 px-2 sm:px-3 py-4 sm:py-6 overflow-y-auto scroll-thin">
            @foreach($resources as $resource)
                @php
                    $routeName = $resource['route'] ?? null;
                    $url = ($routeName && Route::has($routeName)) ? route($routeName) : '#';
                    $routePrefix = $routeName ? str_replace('.index', '', $routeName) : null;
                    $isActive = $routePrefix
                        ? request()->routeIs($routePrefix . '.*') || request()->routeIs($routeName)
                        : false;
                    $iconKey = $resource['icon'] ?? 'circle';
                    $iconClass = $boxIcons[$iconKey] ?? 'bx-shape-square';
                    $navClasses = $isActive
                        ? 'bg-indigo-50 border-indigo-200 text-indigo-700 shadow-sm'
                        : 'text-slate-600 border-transparent hover:bg-slate-50';
                    // derive permission key from route, e.g. admin.pages.index -> pages.read
                    $parts = $routeName ? explode('.', $routeName) : [];
                    $resourceKey = $parts[1] ?? null;
                    $canView = ($routeName === 'admin.dashboard') || ($resourceKey && auth()->check() && auth()->user()->can($resourceKey . '.read'));
                @endphp
                @if($canView)
                <a
                    href="{{ $url }}"
                    class="group flex items-center gap-2 sm:gap-3 rounded-lg sm:rounded-2xl px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-medium transition border {{ $navClasses }}"
                    :class="sidebarCollapsed ? 'justify-center' : 'justify-start'"
                >
                    <span class="flex h-8 sm:h-10 w-8 sm:w-10 items-center justify-center rounded-lg sm:rounded-xl bg-indigo-50 text-indigo-500 transition group-hover:bg-indigo-100 flex-shrink-0">
                        <i class="bx {{ $iconClass }} text-base sm:text-xl"></i>
                    </span>
                    <span class="transition truncate" x-cloak x-show="!sidebarCollapsed">{{ $resource['label'] }}</span>
                </a>
                @endif
            @endforeach
        </nav>

        <!-- Sidebar Footer -->
        <div class="border-t border-slate-200 px-2 sm:px-4 py-3 sm:py-4 flex-shrink-0">
            <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-center gap-2 rounded-lg sm:rounded-2xl bg-indigo-600 hover:bg-indigo-500 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition">
                <i class="bx bx-show text-base sm:text-lg"></i>
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">عرض الموقع</span>
            </a>
            <a href="https://wa.me/+2010631563994" target="_blank" class="mt-3 flex items-center justify-center gap-2 rounded-lg sm:rounded-2xl border border-slate-200 bg-white py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                <i class="bx bx-message-dots text-base sm:text-lg"></i>
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">تواصل مع المطور</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div
        class="flex-1 transition-all duration-300 ease-out flex flex-col min-h-screen"
        :class="sidebarCollapsed ? 'lg:mr-24' : 'lg:mr-80'"
    >
        <!-- Header -->
        <header class="flex flex-col gap-3 sm:gap-4 px-3 sm:px-6 lg:px-8 pt-3 sm:pt-4 flex-shrink-0">
            <div class="glass-panel flex items-center justify-between rounded-xl sm:rounded-2xl lg:rounded-3xl px-3 sm:px-6 py-3 sm:py-4">
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <button class="rounded-lg sm:rounded-2xl border border-slate-200 p-2 sm:p-3 text-slate-700 lg:hidden flex-shrink-0 hover:bg-slate-50" 
                            @click="sidebarOpen = !sidebarOpen">
                        <i class="bx" :class="sidebarOpen ? 'bx-x' : 'bx-menu'" style="font-size: 1.25rem;"></i>
                    </button>
                    <div class="text-right min-w-0">
                        <p class="text-xs text-slate-500 hidden sm:block">مرحباً بك في</p>
                        <h1 class="text-lg sm:text-2xl font-semibold text-slate-900 truncate">{{ $title }}</h1>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    <a href="{{ route('admin.profile.edit') }}" class="hidden sm:flex items-center gap-2 rounded-lg sm:rounded-2xl border border-slate-200 px-2 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                        <i class="bx bx-user-circle text-base sm:text-lg"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button class="flex items-center gap-2 rounded-lg sm:rounded-2xl border border-slate-200 px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                            <i class="bx bx-log-out text-base sm:text-lg"></i>
                            <span class="hidden lg:inline">تسجيل الخروج</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 space-y-4 sm:space-y-6 px-3 sm:px-6 lg:px-8 py-4 sm:py-6 overflow-y-auto scroll-thin">
            @if (session('success'))
                <div class="rounded-lg sm:rounded-2xl border border-emerald-200 bg-emerald-50 px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-emerald-700 flex items-center gap-2">
                    <i class="bx bx-check-circle flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-lg sm:rounded-2xl border border-rose-200 bg-rose-50 px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-rose-700 flex items-center gap-2">
                    <i class="bx bx-x-circle flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loader = document.getElementById('global-loader');
        const showLoader = () => {
            if (!loader) return;
            loader.classList.remove('hidden');
            loader.classList.add('flex');
        };

        document.querySelectorAll('a[href]').forEach((link) => {
            const href = link.getAttribute('href') || '';
            if (href.startsWith('#') || link.getAttribute('target') === '_blank') return;
            link.addEventListener('click', (event) => {
                if (
                    event.defaultPrevented ||
                    event.button !== 0 ||
                    event.metaKey ||
                    event.ctrlKey ||
                    event.shiftKey ||
                    event.altKey
                ) {
                    return;
                }
                showLoader();
            });
        });

        document.querySelectorAll('form').forEach((form) => {
            form.addEventListener('submit', () => {
                showLoader();
            });
        });

        if (window.tinymce) {
            tinymce.init({
                selector: '.js-richtext',
                license_key: 'gpl',
                plugins: 'link lists code table image media',
                toolbar: 'undo redo | formatselect | bold italic underline | alignright aligncenter alignleft | bullist numlist outdent indent | link image media table | code',
                height: 300,
                skin: 'oxide',
                content_style: 'body { direction: rtl; font-family: Cairo, sans-serif; font-size: 14px; color: #1f2937; background: #ffffff; }',
                branding: false,
                relative_urls: false,
                directionality: 'rtl',
                language: 'ar',
            });
        }

        if (window.jQuery) {
            $('.js-dropify').dropify({
                messages: {
                    default: 'اسحب الملف أو انقر للرفع',
                    replace: 'اسحب أو انقر للاستبدال',
                    remove: 'إزالة',
                    error: 'خطأ في رفع الملف',
                },
            });

            $('.js-select2').select2({
                language: 'ar',
                dir: 'rtl',
                width: '100%',
                placeholder: 'اختر من القائمة',
            });
        }

        document.querySelectorAll('form[data-confirm="true"]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();

                if (window.Swal) {
                    Swal.fire({
                        title: 'تأكيد الحذف',
                        text: 'هل أنت متأكد من حذف هذا العنصر؟ لا يمكن التراجع.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'نعم، احذف',
                        cancelButtonText: 'إلغاء',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    if (confirm('هل أنت متأكد من حذف هذا العنصر؟')) {
                        form.submit();
                    }
                }
            });
        });
    });
</script>
</html>
