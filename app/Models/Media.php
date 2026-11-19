<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::deleting(function (Media $media) {
            if ($media->filepath && Storage::disk('public')->exists($media->filepath)) {
                Storage::disk('public')->delete($media->filepath);
            }
        });
    }

    protected $fillable = [
        'user_id',
        'filename',
        'filepath',
        'mime_type',
        'file_size',
        'caption',
        'alt_text',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->filepath);
    }
}
