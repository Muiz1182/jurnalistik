<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'episode_number',
        'description',
        'host',
        'guest',
        'youtube_url',
        'youtube_id',
        'audio_url',
        'thumbnail',
        'duration',
        'user_id',
        'published_at',
        'is_published',
        'listens_count',
    ];

    protected function casts(): array
    {
        return [
            'episode_number' => 'integer',
            'published_at' => 'datetime',
            'is_published' => 'boolean',
            'listens_count' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($podcast) {
            if (empty($podcast->slug)) {
                $podcast->slug = Str::slug($podcast->title);
            }
            if (empty($podcast->youtube_id) && !empty($podcast->youtube_url)) {
                $podcast->youtube_id = Video::extractYoutubeId($podcast->youtube_url);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && file_exists(public_path('storage/' . $this->thumbnail))) {
            return asset('storage/' . $this->thumbnail);
        }
        if ($this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
        }
        return asset('images/placeholder-podcast.jpg');
    }

    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }
}
