@php
    $resources = collect(config('admin.resources'))->reject(fn ($item) => ($item['route'] ?? null) === 'admin.dashboard');
    $metrics = collect($metrics ?? [])->map(fn ($value) => (int) $value);
    $activities = collect($recentActivities ?? []);
    $distribution = $resources->filter(fn($r) => isset($r['route']))->mapWithKeys(function($r) use ($metrics){
        $key = $r['route'] ?? \Illuminate\Support\Str::slug($r['label']);
        return [$r['label'] => (int) ($metrics[$key] ?? 0)];
    });
    $monthly = collect($monthlyTotals ?? []);
@endphp

<x-admin.layout title="لوحة التحكم">
    <!-- البطاقات الإحصائية -->
    <section class="grid gap-3 sm:gap-4 lg:gap-6 lg:grid-cols-4">
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl border border-indigo-100 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs tracking-[0.2em] text-slate-500">إجمالي العناصر</p>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><i class="bx bx-grid"></i></span>
            </div>
            <p class="mt-2 text-2xl sm:text-3xl font-bold text-slate-900">{{ $totalCount ?? 0 }}</p>
            <p class="text-xs text-slate-500 mt-1">عبر جميع الموارد</p>
        </div>
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl border border-emerald-100 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs tracking-[0.2em] text-slate-500">الجديد هذا الشهر</p>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600"><i class="bx bx-trending-up"></i></span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <p class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $createdThisMonth ?? 0 }}</p>
                <span class="text-xs font-semibold {{ ($growthPercent ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    {{ ($growthPercent ?? 0) >= 0 ? '+' : '' }}{{ $growthPercent ?? 0 }}%
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">مقارنة بالشهر الماضي</p>
        </div>
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl border border-slate-200 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs tracking-[0.2em] text-slate-500">الموارد النشطة</p>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-slate-50 text-slate-600"><i class="bx bx-category-alt"></i></span>
            </div>
            <p class="mt-2 text-2xl sm:text-3xl font-bold text-slate-900">{{ $resources->count() }}</p>
            <p class="text-xs text-slate-500 mt-1">المُهيأة في لوحة التحكم</p>
        </div>
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl border border-amber-100 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs tracking-[0.2em] text-slate-500">متوسط لكل مورد</p>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600"><i class="bx bx-doughnut-chart"></i></span>
            </div>
            <p class="mt-2 text-2xl sm:text-3xl font-bold text-slate-900">{{ $resources->count() ? number_format(($totalCount ?? 0)/$resources->count(), 1) : 0 }}</p>
            <p class="text-xs text-slate-500 mt-1">متوسط تقريبي</p>
        </div>
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl border border-sky-100 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs tracking-[0.2em] text-slate-500">إجمالي هذا العام</p>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600"><i class="bx bx-calendar-check"></i></span>
            </div>
            <p class="mt-2 text-2xl sm:text-3xl font-bold text-slate-900">{{ $createdThisYear ?? 0 }}</p>
            <p class="text-xs text-slate-500 mt-1">منذ بداية السنة</p>
        </div>
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl border border-purple-100 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <p class="text-xs tracking-[0.2em] text-slate-500">متوسط يومي (هذا الشهر)</p>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600"><i class="bx bx-time"></i></span>
            </div>
            <p class="mt-2 text-2xl sm:text-3xl font-bold text-slate-900">{{ $dailyAvgThisMonth ?? 0 }}</p>
            <p class="text-xs text-slate-500 mt-1">إضافات يومية تقريبية</p>
        </div>
    </section>

    <!-- الرسوم البيانية -->
    <section class="mt-4 sm:mt-6 grid gap-3 sm:gap-4 lg:gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-slate-900">العناصر الجديدة شهريًا</h3>
                <span class="text-xs tracking-[0.2em] text-slate-500 bg-slate-50 px-2.5 py-1 rounded-full">آخر 12 شهرًا</span>
            </div>
            <div class="h-64">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-slate-900">توزيع الموارد</h3>
            </div>
            <div class="h-64">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </section>

    <!-- Resource Metrics Grid -->
    <section class="mt-4 sm:mt-6 glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <h3 class="text-base sm:text-lg font-semibold text-slate-900">مقاييس الموارد</h3>
        </div>
        <div class="grid gap-3 sm:gap-4 md:grid-cols-3 lg:grid-cols-4">
            @foreach($resources as $resource)
                @php
                    $routeKey = $resource['route'] ?? \Illuminate\Support\Str::slug($resource['label']);
                    $count = $metrics->get($routeKey, 0);
                @endphp
                <a href="{{ ($resource['route'] ?? false) && \Illuminate\Support\Facades\Route::has($resource['route']) ? route($resource['route']) : '#' }}"
                   class="rounded-lg sm:rounded-xl border border-slate-200 bg-white p-3 sm:p-4 text-right hover:bg-slate-50 transition block">
                    <p class="text-xs tracking-[0.2em] text-slate-500">{{ $resource['label'] }}</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-slate-900">{{ $count }}</p>
                    <p class="text-xs text-slate-500 mt-1">إجمالي العناصر</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- النشاط الأخير -->
    <section class="mt-4 sm:mt-6 glass-panel rounded-xl sm:rounded-2xl lg:rounded-3xl p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <h3 class="text-base sm:text-lg font-semibold text-slate-900">النشاط الأخير</h3>
        </div>
        <div class="rounded-2xl border border-slate-200/70 bg-white/70 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-[720px] w-full text-right text-xs sm:text-sm text-slate-700">
                    <thead class="sticky top-0 z-10 bg-white/85 backdrop-blur border-b border-slate-200/70">
                        <tr>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 font-semibold text-slate-600">المورد</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 font-semibold text-slate-600">العنوان</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 font-semibold text-slate-600">التاريخ</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 font-semibold text-slate-600">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($activities as $row)
                            <tr class="odd:bg-white even:bg-slate-50/70 hover:bg-indigo-50/50 transition">
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                    <span class="inline-flex max-w-[220px] truncate rounded-full bg-indigo-50 px-2.5 sm:px-3 py-1 text-[11px] sm:text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-100">{{ $row['resource'] }}</span>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-slate-800">
                                    {{ \Illuminate\Support\Str::limit((string)($row['title'] ?? ''), 60) }}
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-slate-600">
                                    {{ \Carbon\Carbon::parse($row['created_at'] ?? now())->locale('ar')->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                    <div class="flex items-center gap-1.5 sm:gap-2">
                                        @if(!empty($row['edit_url']))
                                            @can(($row['resource_key'] ?? '') . '.update')
                                            <a href="{{ $row['edit_url'] }}" class="inline-flex items-center rounded-xl px-2.5 sm:px-3 py-1.5 text-[11px] sm:text-xs font-semibold bg-slate-900 text-white hover:bg-slate-800 transition">تعديل</a>
                                            @endcan
                                        @endif
                                        @if(!empty($row['index_url']))
                                            @can(($row['resource_key'] ?? '') . '.read')
                                            <a href="{{ $row['index_url'] }}" class="inline-flex items-center rounded-xl px-2.5 sm:px-3 py-1.5 text-[11px] sm:text-xs font-semibold bg-white text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50 transition">فتح القائمة</a>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 sm:px-6 py-12 text-center text-slate-500">لا توجد سجلات حديثة.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Charts Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const monthlyLabels = @json($monthly->pluck('label'));
            const monthlyData = @json($monthly->pluck('count'));

            const distLabels = @json($distribution->keys()->values());
            const distData = @json($distribution->values());

            const lineCtx = document.getElementById('lineChart');
            if (lineCtx) {
                new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                            label: 'عناصر جديدة',
                            data: monthlyData,
                            fill: true,
                            borderColor: 'rgb(79, 70, 229)',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            tension: 0.35,
                            pointRadius: 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        interaction: { intersect: false, mode: 'index' },
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.06)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const doughnutCtx = document.getElementById('doughnutChart');
            if (doughnutCtx) {
                const palette = ['#6366F1','#22C55E','#F59E0B','#EF4444','#0EA5E9','#A78BFA','#10B981','#F472B6','#F97316','#84CC16'];
                new Chart(doughnutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: distLabels,
                        datasets: [{
                            data: distData,
                            backgroundColor: distLabels.map((_, i) => palette[i % palette.length]),
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            }
        });
    </script>
</x-admin.layout>
