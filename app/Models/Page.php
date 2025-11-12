<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'page_group_id',
        'parent_id',
        'is_active',
        'visitable',
        'order',
        'title',
        'cover',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'visitable' => 'boolean',
        'order' => 'integer',
    ];

    public function setTitleAttribute(?string $value): void
    {
        $this->attributes['title'] = $value;

        if ($value !== null) {
            $this->attributes['slug'] = $this->generateUniqueSlug($value);
        }
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(PageGroup::class, 'page_group_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function partials(): HasMany
    {
        return $this->hasMany(Partial::class);
    }

    protected function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'page';
        $slug = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($this->exists, fn ($query) => $query->whereKeyNot($this->getKey()))
                ->exists()
        ) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
