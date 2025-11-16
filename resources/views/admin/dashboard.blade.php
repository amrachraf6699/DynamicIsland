@php
    $resources = collect(config('admin.resources'))->reject(fn ($item) => ($item['route'] ?? null) === 'admin.dashboard');
    $metrics = collect($metrics ?? [])->map(fn ($value) => (int) $value);
    $activities = collect($recentActivities ?? []);
@endphp

<!-- Improved responsive dashboard with better grid layouts -->
<x-admin.layout title="لوحة التحكم">
    <!-- Stats Section -->
    <section class="grid gap-3 sm:gap-4 lg:gap-6 lg:grid-cols-3">
        <!-- Welcome Card -->
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl border border-indigo-500/20 p-4 sm:p-6 shadow-lg shadow-indigo-500/10">
            <p class="text-xs tracking-[0.3em] text-indigo-300/80">اليوم</p>
            <h2 class="mt-2 text-2xl sm:text-3xl font-bold text-white text-balance">{{ now()->locale('ar')->translatedFormat('l d F') }}</h2>
            <p class="mt-4 sm:mt-6 text-xs sm:text-sm text-slate-400 leading-relaxed">
                مرحباً بك في لوحة التحكم. راقب أداء نظامك من خلال المؤشرات التالية.
            </p>
        </div>

        <!-- Metrics Grid -->
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-white">مؤشرات الأداء</h3>
                <span class="text-xs tracking-[0.2em] text-slate-500 bg-slate-900/50 px-2.5 py-1 rounded-full">تحديث مباشر</span>
            </div>
            <div class="grid gap-3 sm:gap-4 md:grid-cols-3">
                @foreach($resources->take(6) as $resource)
                    @php
                        $routeKey = $resource['route'] ?? \Illuminate\Support\Str::slug($resource['label']);
                        $count = $metrics->get($routeKey, 0);
                    @endphp
                    <div class="rounded-lg sm:rounded-xl border border-slate-700/40 bg-slate-900/40 p-3 sm:p-4 text-right hover:bg-slate-900/60 transition">
                        <p class="text-xs tracking-[0.2em] text-slate-500 uppercase">{{ $resource['label'] }}</p>
                        <p class="mt-2 text-2xl sm:text-3xl font-bold text-white">{{ $count }}</p>
                        <p class="text-xs text-slate-500 mt-1">السجلات</p>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Activity & Quick Add Section -->
        <!-- Recent Activities -->
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-white">آخر التحديثات</h3>
            </div>
            <x-admin.table
            :columns="[
                ['key' => 'resource', 'label' => 'المورد', 'type' => 'badge'],
                ['key' => 'title', 'label' => 'العنوان'],
                ['key' => 'user', 'label' => 'المستخدم'],
                ['key' => 'created_at', 'label' => 'التاريخ', 'type' => 'datetime'],
                ]"
                :rows="$activities"
                :actions="[]"
                />
            </div>
        </section>
</x-admin.layout>
