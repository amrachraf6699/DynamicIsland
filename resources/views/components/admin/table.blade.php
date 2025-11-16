@props([
    'columns' => [],
    'rows' => collect(),
    'resource' => null,
    'actions' => [],
])

@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Str;
    use Illuminate\Support\Carbon;

    $columns = collect($columns);
@endphp

<!-- Responsive table with better mobile handling -->
<div class="glass-panel overflow-hidden rounded-xl sm:rounded-2xl lg:rounded-3xl">
    <div class="overflow-x-auto scroll-thin">
        <table class="w-full divide-y divide-slate-700/40 text-xs sm:text-sm text-slate-200 text-right">
            <thead class="bg-slate-900/60 text-xs sm:text-sm tracking-wide text-slate-400 sticky top-0">
                <tr>
                    @foreach($columns as $column)
                        <th scope="col" class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-right font-semibold">
                            <div class="flex items-center gap-2 justify-end">
                                <span class="truncate">{{ $column['label'] ?? strtoupper($column['key']) }}</span>
                                @if(($column['sortable'] ?? true) && request('sort') === ($column['key'] ?? null))
                                    <svg class="h-3 sm:h-4 w-3 sm:w-4 flex-shrink-0 {{ request('direction', 'desc') === 'desc' ? 'rotate-180' : '' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4.5 15.75 7.5-7.5 7.5 7.5"/>
                                    </svg>
                                @endif
                            </div>
                        </th>
                    @endforeach
                    <th class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-right font-semibold">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/30">
                @forelse($rows as $row)
                    <tr class="hover:bg-white/5 transition">
                        @foreach($columns as $column)
                            @php
                                $key = $column['key'];
                                $value = data_get($row, $key);
                            @endphp
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                @if (is_bool($value))
                                    <span class="inline-flex items-center rounded-full px-2.5 sm:px-3 py-1 text-xs font-semibold {{ $value ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                                        {{ $value ? 'مفعل' : 'معطل' }}
                                    </span>
                                @elseif ($column['type'] ?? '' === 'badge')
                                    <span class="rounded-full bg-indigo-500/20 px-2.5 sm:px-3 py-1 text-xs text-indigo-300 inline-block max-w-full truncate">{{ $value }}</span>
                                @elseif (($column['type'] ?? '') === 'datetime' && $value)
                                    <span class="text-slate-300 text-xs sm:text-sm">{{ Carbon::parse($value)->locale('ar')->translatedFormat('d M Y') }}</span>
                                @else
                                    <span class="text-slate-200 line-clamp-2 sm:line-clamp-1 text-xs sm:text-sm">{{ Str::limit($value, 40) }}</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-right">
                            <div class="flex items-center justify-start gap-1 sm:gap-2 flex-wrap">
                                @foreach($actions as $action)
                                    @php
                                        $routeName = $action['route'] ?? null;
                                        $url = ($routeName && Route::has($routeName)) ? route($routeName, $row) : '#';
                                        $label = $action['label'] ?? 'تحرير';
                                        $type = $action['type'] ?? 'link';
                                    @endphp
                                    @if ($type === 'delete')
                                        <form method="POST" action="{{ $url }}" data-confirm="true" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg sm:rounded-2xl border border-rose-500/60 px-2 sm:px-3 py-1 text-xs font-semibold text-rose-300 hover:bg-rose-500/10 transition">
                                                {{ $label }}
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ $url }}" class="rounded-lg sm:rounded-2xl border border-slate-600/60 px-2 sm:px-3 py-1 text-xs font-semibold text-slate-300 hover:bg-white/10 transition inline-block">
                                            {{ $label }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $columns->count() + 1 }}" class="px-3 sm:px-6 py-8 sm:py-12 text-center text-slate-500 text-xs sm:text-sm">
                            <i class="bx bx-inbox text-3xl sm:text-4xl block mb-2 opacity-50"></i>
                            لا توجد بيانات متاحة حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
