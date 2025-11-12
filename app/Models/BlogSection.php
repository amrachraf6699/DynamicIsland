<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogSection extends Model
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
        'meta_title',
        'meta_description',
        'meta_keywords',
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

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
}
