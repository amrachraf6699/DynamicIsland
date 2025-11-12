<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait GeneratesSlug
{
    protected function generateUniqueSlug(string $value, string $column = 'slug'): string
    {
        $base = Str::slug($value) ?: Str::slug(class_basename($this)) ?: 'item';
        $slug = $base;
        $counter = 1;

        while ($this->slugExists($slug, $column)) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    protected function slugExists(string $slug, string $column): bool
    {
        return static::where($column, $slug)
            ->when($this->exists, fn (Builder $query) => $query->whereKeyNot($this->getKey()))
            ->exists();
    }
}
