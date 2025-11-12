<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;
    use GeneratesSlug;

    protected $fillable = [
        'is_active',
        'is_featured',
        'title',
        'slug',
        'cover',
        'content',
        'excerpt',
        'blog_section_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
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

    public function section(): BelongsTo
    {
        return $this->belongsTo(BlogSection::class, 'blog_section_id');
    }
}
