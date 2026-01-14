@php
if (! isset($bulkRoute)) {
    $bulkRoute = null;
}
$bulkFormId = $bulkRoute ? uniqid('bulk-form-') : null;
@endphp

@if($bulkRoute)
<form method="POST" action="{{ $bulkRoute }}" id="{{ $bulkFormId }}" class="space-y-3" data-bulk-form data-confirm="true">
    @csrf
    @method('DELETE')
@endif

<div class="rounded-2xl border border-slate-200/70 bg-white/70 shadow-sm backdrop-blur overflow-hidden">
    <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 left-0 w-8 bg-gradient-to-r from-white/90 to-transparent md:hidden"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white/90 to-transparent md:hidden"></div>

        <div class="overflow-x-auto">
            <table class="min-w-[720px] w-full text-right text-xs sm:text-sm text-slate-700">
                <thead class="sticky top-0 z-10 bg-white/85 backdrop-blur border-b border-slate-200/70">
                    <tr>
                        @if($bulkRoute)
                        <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 font-semibold text-slate-600 whitespace-nowrap align-middle">
                            <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-600" data-bulk-check-all>
                        </th>
                        @endif
                        @foreach($columns as $column)
                        <th scope="col" class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 font-semibold text-slate-600 whitespace-nowrap">
                            <div class="inline-flex items-center gap-2 justify-end">
                                <span class="truncate max-w-[18ch] sm:max-w-none">
                                    {{ $column['label'] ?? strtoupper($column['key']) }}
                                </span>

                                @if(($column['sortable'] ?? true) && request('sort') === ($column['key'] ?? null))
                                <svg class="h-3.5 w-3.5 text-slate-500 transition {{ request('direction', 'desc') === 'desc' ? 'rotate-180' : '' }}"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                </svg>
                                @endif
                            </div>
                        </th>
                        @endforeach

                        <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 font-semibold text-slate-600 whitespace-nowrap sticky left-0 bg-white/85 backdrop-blur">
                            الإجراءات
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($rows as $row)
                    @php
                    $rowKey = method_exists($row, 'getKey') ? $row->getKey() : data_get($row, 'id');
                    @endphp
                    <tr class="odd:bg-white even:bg-slate-50/70 hover:bg-purple-50/70 hover:shadow-[inset_0_0_0_9999px_rgba(168,85,247,0.06)] hover:shadow-sm hover:-translate-y-[1px] transition-all duration-200">
                        @if($bulkRoute)
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 align-middle">
                            <input type="checkbox" name="ids[]" value="{{ $rowKey }}" class="h-4 w-4 rounded border-slate-300 text-indigo-600" data-bulk-checkbox>
                        </td>
                        @endif
                        @foreach($columns as $column)
                        @php
                        $key = $column['key'];
                        $value = data_get($row, $key);
                        @endphp

                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 align-middle">
                            @if (is_bool($value))
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 sm:px-3 py-1 text-[11px] sm:text-xs font-semibold ring-1 ring-inset {{ $value ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-rose-50 text-rose-700 ring-rose-200' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $value ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $value ? 'نعم' : 'لا' }}
                            </span>

                            @elseif (($column['type'] ?? '') === 'badge')
                            <span class="inline-flex max-w-[220px] truncate rounded-full bg-indigo-50 px-2.5 sm:px-3 py-1 text-[11px] sm:text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-100">
                                {{ $value }}
                            </span>

                            @elseif (($column['type'] ?? '') === 'datetime' && $value)
                            <span class="text-slate-600">
                                {{ \Carbon\Carbon::parse($value)->locale('ar')->translatedFormat('d M Y') }}
                            </span>

                            @else
                            <span class="text-slate-800">
                                {{ \Illuminate\Support\Str::limit((string)$value, 60) }}
                            </span>
                            @endif
                        </td>
                        @endforeach

                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 align-middle sticky left-0 backdrop-blur bg-inherit">
                            <div class="flex items-center justify-start gap-1.5 sm:gap-2 flex-wrap">
                                @foreach($actions as $action)
                                @php
                                $routeName = $action['route'] ?? null;
                                $url = ($routeName && \Illuminate\Support\Facades\Route::has($routeName)) ? route($routeName, $row) : '#';
                                $label = $action['label'] ?? 'تفاصيل';
                                $type = $action['type'] ?? 'link';
                                $variant = $action['variant'] ?? null;
                                $ability = $action['ability'] ?? null;
                                if (! $ability) {
                                    $ability = 'read';
                                    if ($type === 'delete' || ($routeName && str_ends_with($routeName, '.destroy'))) {
                                        $ability = 'delete';
                                    } elseif ($type === 'create' || ($routeName && str_ends_with($routeName, '.create'))) {
                                        $ability = 'create';
                                    } elseif ($type === 'link' || ($routeName && (str_ends_with($routeName, '.edit') || str_ends_with($routeName, '.update')))) {
                                        $ability = 'update';
                                    }
                                }
                                @endphp
                                @can(($resource ?? null) ? ($resource . '.' . $ability) : $ability)
                                @if ($type === 'delete')
                                <form method="POST" action="{{ $url }}" class="inline" data-confirm="true">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-xl px-2.5 sm:px-3 py-1.5 text-[11px] sm:text-xs font-semibold bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200 hover:bg-rose-100 transition">
                                        {{ $label }}
                                    </button>
                                </form>
                                @else
                                <a href="{{ $url }}" class="inline-flex items-center rounded-xl px-2.5 sm:px-3 py-1.5 text-[11px] sm:text-xs font-semibold {{ $variant === 'primary' ? 'bg-slate-900 text-white hover:bg-slate-800' : 'bg-white text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50' }} transition">
                                    {{ $label }}
                                </a>
                                @endif
                                @endcan
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($columns) + ($bulkRoute ? 2 : 1) }}" class="px-4 sm:px-6 py-12 text-center text-slate-500">
                            لا توجد بيانات متاحة حالياً.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($bulkRoute)
    <div class="flex items-center justify-end">
        <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-rose-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-rose-500/20 hover:bg-rose-600 disabled:opacity-40" data-bulk-submit disabled>
            حذف المحدد
        </button>
    </div>
</form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('{{ $bulkFormId }}');
            if (!form) return;
            const master = form.querySelector('[data-bulk-check-all]');
            const checkboxes = Array.from(form.querySelectorAll('[data-bulk-checkbox]'));
            const submitBtn = form.querySelector('[data-bulk-submit]');

            const updateState = () => {
                const hasChecked = checkboxes.some((cb) => cb.checked);
                submitBtn.disabled = !hasChecked;
                if (master) {
                    const allChecked = checkboxes.length > 0 && checkboxes.every((cb) => cb.checked);
                    master.checked = allChecked;
                    master.indeterminate = !allChecked && hasChecked;
                }
            };

            if (master) {
                master.addEventListener('change', () => {
                    checkboxes.forEach((cb) => {
                        cb.checked = master.checked;
                    });
                    updateState();
                });
            }

            checkboxes.forEach((cb) => {
                cb.addEventListener('change', updateState);
            });

            updateState();
        });
    </script>
@endif
