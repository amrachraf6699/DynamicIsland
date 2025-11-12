<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;

class TeamMember extends Model
{
    use HasFactory;
    use GeneratesSlug;

    protected $fillable = [
        'is_active',
        'name',
        'slug',
        'img',
        'job_title',
        'bio',
        'joined_at',
        'email',
        'phone',
        'whatsapp',
        'facebook',
        'instagram',
        'tiktok',
        'behance',
        'youtube',
        'twitter',
        'linkedin',
        'github',
        'order',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'joined_at' => 'date',
    ];

    public function setNameAttribute(?string $value): void
    {
        $this->attributes['name'] = $value;

        if ($value !== null) {
            $this->attributes['slug'] = $this->generateUniqueSlug($value);
        }
    }

    public function getImgUrlAttribute(): ?string
    {
        return $this->img ? Storage::url($this->img) : null;
    }

    public function relations(): HasMany
    {
        return $this->hasMany(TeamMemberRelation::class);
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'memberable', 'team_memberables')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function services(): MorphToMany
    {
        return $this->morphedByMany(Service::class, 'memberable', 'team_memberables')
            ->withPivot('role')
            ->withTimestamps();
    }
}
