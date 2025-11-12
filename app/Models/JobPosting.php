<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;
    use GeneratesSlug;

    protected $fillable = [
        'is_active',
        'is_featured',
        'title',
        'slug',
        'department',
        'location',
        'employment_type',
        'description',
        'requirements',
        'responsibilities',
        'experience_level',
        'salary_min',
        'salary_max',
        'currency',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function setTitleAttribute(?string $value): void
    {
        $this->attributes['title'] = $value;

        if ($value !== null) {
            $this->attributes['slug'] = $this->generateUniqueSlug($value);
        }
    }
}
