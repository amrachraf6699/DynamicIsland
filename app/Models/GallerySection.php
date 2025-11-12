<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class GallerySection extends Model
{
    use HasFactory;
    use GeneratesSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_active',
        'is_featured',
        'order',
        'cover',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function setTitleAttribute(?string $value): void
    {
        $this->attributes['title'] = $value;

        if ($value !== null) {
            $this->attributes['slug'] = $this->generateUniqueSlug($value);
        }
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover ? Storage::url($this->cover) : null;
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}
