<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organization',
        'awarded_at',
        'image',
        'link',
        'description',
        'is_active',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'awarded_at' => 'date',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}
