<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;
    use GeneratesSlug;

    protected $fillable = [
        'slug',
        'meta_title',
        'meta_description',
        'featured',
        'meta_keywords',
        'title',
        'cover',
        'content',
        'requestable',
        'delivery_days',
        'is_active',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'requestable' => 'boolean',
        'is_active' => 'boolean',
        'delivery_days' => 'integer',
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

    public function teamMembers(): MorphToMany
    {
        return $this->morphToMany(TeamMember::class, 'memberable', 'team_memberables')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }
}
