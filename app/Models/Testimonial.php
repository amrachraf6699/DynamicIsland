<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testmonials';

    protected $fillable = [
        'is_active',
        'name',
        'job_title',
        'company',
        'img',
        'content',
        'rating',
        'service_id',
        'project_id',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'rating' => 'integer',
    ];

    public function getImgUrlAttribute(): ?string
    {
        return $this->img ? Storage::url($this->img) : null;
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
