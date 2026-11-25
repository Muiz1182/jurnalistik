<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'ip_address',
        'session_id',
        'viewed_date',
        'viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'viewed_date' => 'date',
            'viewed_at' => 'datetime',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Track an article view safely with deduplication:
     * - Prevents rapid refresh/spam within the same session using session memory and session_id
     * - Does not lock out different students/users on the same school WiFi or local IP
     * - Smoothly increments views_count both in DB and on the $article instance in memory
     */
    public static function track(Article $article, string $ipAddress, ?string $sessionId = null): bool
    {
        // 1. In-session fast check (prevents DB overhead on rapid F5 / refresh)
        $sessionKey = 'viewed_article_' . $article->id;
        if (session()->has($sessionKey)) {
            $lastViewed = (int) session()->get($sessionKey);
            // Cooldown of 1 hour (3600 seconds) per browsing session
            if (now()->timestamp - $lastViewed < 3600) {
                return false;
            }
        }

        $today = now()->toDateString();
        
        // 2. Database deduplication check:
        // When sessionId is present, match by (article_id, viewed_date, session_id).
        // When sessionId is null (e.g. CLI or stateless), fall back to (article_id, viewed_date, ip_address).
        // This fixes the bug where multiple clients sharing the same IP (127.0.0.1 or school Wi-Fi) were blocked.
        $alreadyViewed = static::where('article_id', $article->id)
            ->where('viewed_date', $today)
            ->when($sessionId, function ($q) use ($sessionId) {
                $q->where('session_id', $sessionId);
            }, function ($q) use ($ipAddress) {
                $q->where('ip_address', $ipAddress);
            })
            ->exists();

        if (!$alreadyViewed) {
            static::create([
                'article_id' => $article->id,
                'ip_address' => $ipAddress,
                'session_id' => $sessionId,
                'viewed_date' => $today,
                'viewed_at' => now(),
            ]);

            $article->increment('views_count');
            // Keep the in-memory object count fresh for the current request
            $article->views_count = (int) $article->views_count;
            session()->put($sessionKey, now()->timestamp);
            return true;
        }

        session()->put($sessionKey, now()->timestamp);
        return false;
    }
}
