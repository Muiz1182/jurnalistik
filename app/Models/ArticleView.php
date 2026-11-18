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
     * Track an article view safely with deduplication (once per IP or session per day)
     */
    public static function track(Article $article, string $ipAddress, ?string $sessionId = null): bool
    {
        $today = now()->toDateString();
        
        $alreadyViewed = static::where('article_id', $article->id)
            ->where('viewed_date', $today)
            ->where(function ($q) use ($ipAddress, $sessionId) {
                $q->where('ip_address', $ipAddress);
                if ($sessionId) {
                    $q->orWhere('session_id', $sessionId);
                }
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
            return true;
        }

        return false;
    }
}
