<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class SpecialCoverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'banner_image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($coverage) {
            if (empty($coverage->slug)) {
                $coverage->slug = Str::slug($coverage->title);
            }
        });
        static::deleting(function ($coverage) {
            if ($coverage->banner_image && !Str::startsWith($coverage->banner_image, ['http://', 'https://']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($coverage->banner_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($coverage->banner_image);
            }
            $coverage->articles()->detach();
        });
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'special_coverage_articles')
            ->withPivot('order')
            ->orderByPivot('order');
    }

    public function getBannerImageUrlAttribute(): string
    {
        if ($this->banner_image && file_exists(public_path('storage/' . $this->banner_image))) {
            return asset('storage/' . $this->banner_image);
        }
        if ($this->banner_image && Str::startsWith($this->banner_image, ['http://', 'https://'])) {
            return $this->banner_image;
        }
        return asset('images/placeholder-coverage.jpg');
    }
}
