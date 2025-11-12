<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'title',
        'cover',
        'content',
        'demo',
        'live_preview',
        'client',
        'location',
        'date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'date' => 'date',
    ];

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

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }
}
