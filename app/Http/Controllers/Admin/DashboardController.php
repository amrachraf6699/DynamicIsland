<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route as RouteFacade;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $resources = collect(config('admin.resources', []))
            ->filter(fn ($resource) => ($resource['route'] ?? null) !== 'admin.dashboard');

        $metrics = $resources
            ->filter(fn ($resource) => isset($resource['model']))
            ->mapWithKeys(function ($resource) {
                $modelClass = $resource['model'];
                if (! class_exists($modelClass)) {
                    return [];
                }

                $key = $resource['route'] ?? Str::slug($resource['label']);

                return [$key => $modelClass::count()];
            });

        // High-level KPIs
        $totalCount = (int) $metrics->sum();

        $startOfThisMonth = now()->startOfMonth();
        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();
        $startOfYear = now()->startOfYear();

        $createdThisMonth = $resources
            ->filter(fn ($resource) => isset($resource['model']) && class_exists($resource['model']))
            ->sum(function ($resource) use ($startOfThisMonth) {
                $modelClass = $resource['model'];
                return (int) $modelClass::where('created_at', '>=', $startOfThisMonth)->count();
            });

        $createdLastMonth = $resources
            ->filter(fn ($resource) => isset($resource['model']) && class_exists($resource['model']))
            ->sum(function ($resource) use ($startOfLastMonth, $endOfLastMonth) {
                $modelClass = $resource['model'];
                return (int) $modelClass::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
            });

        $growthPercent = $createdLastMonth > 0
            ? round((($createdThisMonth - $createdLastMonth) / $createdLastMonth) * 100)
            : ($createdThisMonth > 0 ? 100 : 0);

        $createdThisYear = $resources
            ->filter(fn ($resource) => isset($resource['model']) && class_exists($resource['model']))
            ->sum(function ($resource) use ($startOfYear) {
                $modelClass = $resource['model'];
                return (int) $modelClass::where('created_at', '>=', $startOfYear)->count();
            });

        $daysElapsedThisMonth = max(1, now()->day);
        $dailyAvgThisMonth = round($createdThisMonth / $daysElapsedThisMonth, 1);

        $topResource = $resources
            ->filter(fn ($resource) => isset($resource['model']) && class_exists($resource['model']))
            ->map(function ($resource) {
                $modelClass = $resource['model'];
                $count = (int) $modelClass::count();
                return [
                    'label' => $resource['label'] ?? 'مورد',
                    'route' => $resource['route'] ?? null,
                    'count' => $count,
                ];
            })
            ->sortByDesc('count')
            ->first();

        // Monthly totals across all resources (last 12 months)
        $months = collect(range(0, 11))->reverse()->map(fn ($i) => now()->subMonths($i)->startOfMonth());
        $monthlyTotals = $months->map(function ($month) use ($resources) {
            $start = $month->copy();
            $end = $month->copy()->endOfMonth();
            $count = $resources
                ->filter(fn ($r) => isset($r['model']) && class_exists($r['model']))
                ->sum(function ($r) use ($start, $end) {
                    $modelClass = $r['model'];
                    return (int) $modelClass::whereBetween('created_at', [$start, $end])->count();
                });

            return [
                'label' => $month->translatedFormat('M Y'),
                'count' => $count,
            ];
        });

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'recentActivities' => $this->recentActivitiesWithActions($resources),
            'totalCount' => $totalCount,
            'createdThisMonth' => $createdThisMonth,
            'growthPercent' => $growthPercent,
            'monthlyTotals' => $monthlyTotals,
            'createdThisYear' => $createdThisYear,
            'dailyAvgThisMonth' => $dailyAvgThisMonth,
            'topResource' => $topResource,
        ]);
    }

    protected function recentActivities(Collection $resources): Collection
    {
        return $resources
            ->filter(fn ($resource) => isset($resource['model']))
            ->flatMap(function ($resource) {
                $modelClass = $resource['model'];

                if (! class_exists($modelClass)) {
                    return collect();
                }

                return $modelClass::query()
                    ->latest('updated_at')
                    ->take(3)
                    ->get()
                    ->map(function ($record) use ($resource) {
                        return [
                            'resource' => $resource['label'],
                            'title' => $record->title ?? $record->name ?? $record->slug ?? ('#' . $record->getKey()),
                            'user' => method_exists($record, 'updatedBy') ? optional($record->updatedBy)->name : 'النظام',
                            'created_at' => $record->updated_at ?? $record->created_at,
                        ];
                    });
            })
            ->sortByDesc('created_at')
            ->values()
            ->take(10);
    }

    protected function recentActivitiesWithActions(Collection $resources): Collection
    {
        return $resources
            ->filter(fn ($resource) => isset($resource['model']))
            ->flatMap(function ($resource) {
                $modelClass = $resource['model'];

                if (! class_exists($modelClass)) {
                    return collect();
                }

                $indexRoute = $resource['route'] ?? null;
                $editRoute = $indexRoute ? str_replace('.index', '.edit', $indexRoute) : null;
                $parts = $indexRoute ? explode('.', $indexRoute) : [];
                $resourceKey = $parts[1] ?? null;

                return $modelClass::query()
                    ->latest('updated_at')
                    ->take(3)
                    ->get()
                    ->map(function ($record) use ($resource, $indexRoute, $editRoute, $resourceKey) {
                        $editUrl = ($editRoute && RouteFacade::has($editRoute)) ? route($editRoute, $record) : null;
                        $indexUrl = ($indexRoute && RouteFacade::has($indexRoute)) ? route($indexRoute) : null;

                        return [
                            'resource' => $resource['label'],
                            'title' => $record->title ?? $record->name ?? $record->slug ?? ('#' . $record->getKey()),
                            'created_at' => $record->updated_at ?? $record->created_at,
                            'edit_url' => $editUrl,
                            'index_url' => $indexUrl,
                            'resource_key' => $resourceKey,
                        ];
                    });
            })
            ->sortByDesc('created_at')
            ->values()
            ->take(10);
    }
}
