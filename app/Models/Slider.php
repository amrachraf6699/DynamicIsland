<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'button',
        'url',
        'is_active',
        'img',
        'service_id',
        'text_align_horizontal',
        'text_align_vertical',
        'button_align_horizontal',
        'button_align_vertical',
        'text_color',
        'button_color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImgUrlAttribute(): ?string
    {
        return $this->img ? Storage::url($this->img) : null;
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
