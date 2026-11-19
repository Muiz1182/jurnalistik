<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'category',
        'user_id',
        'is_published',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'views_count' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
        static::deleting(function ($gallery) {
            if ($gallery->cover_image && !Str::startsWith($gallery->cover_image, ['http://', 'https://']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($gallery->cover_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($gallery->cover_image);
            }
            foreach ($gallery->photos as $photo) {
                $photo->delete();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('order');
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image && file_exists(public_path('storage/' . $this->cover_image))) {
            return asset('storage/' . $this->cover_image);
        }
        if ($this->cover_image && Str::startsWith($this->cover_image, ['http://', 'https://'])) {
            return $this->cover_image;
        }
        return asset('images/placeholder-gallery.jpg');
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover_image_url;
    }
}
