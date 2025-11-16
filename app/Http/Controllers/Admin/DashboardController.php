<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'recentActivities' => $this->recentActivities($resources),
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
}
