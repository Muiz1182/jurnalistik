<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::deleting(function (Article $article) {
            // Delete physical featured image from public storage
            if ($article->featured_image && !Str::startsWith($article->featured_image, ['http://', 'https://']) && Storage::disk('public')->exists($article->featured_image)) {
                Storage::disk('public')->delete($article->featured_image);
            }

            // Cleanup relationships and child records before permanent deletion
            $article->tags()->detach();
            $article->specialCoverages()->detach();
            $article->bookmarks()->delete();
            $article->comments()->delete();
            $article->revisions()->delete();
            $article->views()->delete();
            EditorialAssignment::where('article_id', $article->id)->update(['article_id' => null]);
        });
    }

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'content',
        'category_id',
        'user_id',
        'editor_id',
        'photographer_name',
        'featured_image',
        'image_caption',
        'status',
        'published_at',
        'scheduled_for',
        'is_breaking',
        'is_headline',
        'is_featured',
        'is_editor_pick',
        'allow_comments',
        'views_count',
        'shares_count',
        'seo_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'scheduled_for' => 'datetime',
            'is_breaking' => 'boolean',
            'is_headline' => 'boolean',
            'is_featured' => 'boolean',
            'is_editor_pick' => 'boolean',
            'allow_comments' => 'boolean',
            'views_count' => 'integer',
            'shares_count' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $baseSlug = Str::slug($article->title);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }
                $article->slug = $slug;
            }
            if (empty($article->excerpt) && !empty($article->content)) {
                $plain = strip_tags($article->content);
                $article->excerpt = Str::limit($plain, 180, '...');
            }
        });
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ArticleRevision::class)->latest();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('status', 'approved')->whereNull('parent_id')->with('replies');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }

    public function specialCoverages(): BelongsToMany
    {
        return $this->belongsToMany(SpecialCoverage::class, 'special_coverage_articles');
    }

    // Scopes
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeBreaking(Builder $query): Builder
    {
        return $query->published()->where('is_breaking', true)->latest('published_at');
    }

    public function scopeHeadlines(Builder $query): Builder
    {
        return $query->published()->where('is_headline', true)->latest('published_at');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->published()->where('is_featured', true)->latest('published_at');
    }

    public function scopePopular(Builder $query, int $days = 30): Builder
    {
        return $query->published()
            ->when($days > 0, fn($q) => $q->where('published_at', '>=', now()->subDays($days)))
            ->orderByDesc('views_count')
            ->latest('published_at');
    }

    /**
     * Get top popular published articles with smart fallback:
     * - First priority: Most viewed articles published in the recent period ($days)
     * - Second priority: If fewer than $limit, seamlessly backfill with all-time most viewed published articles
     * - Third priority: Break any ties with latest published_at
     * Guarantees returning up to $limit articles as long as published articles exist.
     *
     * @param int $limit Number of popular articles to return (default 5)
     * @param int $days Recency window in days (default 30)
     * @param int|array|null $excludeId ID or array of IDs to exclude (e.g. current article)
     * @return \Illuminate\Database\Eloquent\Collection<int, Article>
     */
    public static function getPopular(int $limit = 5, int $days = 30, int|array|null $excludeId = null)
    {
        $excludeIds = is_array($excludeId) ? $excludeId : ($excludeId ? [$excludeId] : []);

        $baseQuery = static::published()
            ->when(!empty($excludeIds), fn($q) => $q->whereNotIn('id', $excludeIds))
            ->with(['category', 'author']);

        // 1. Articles with views published in the recent window
        $recent = (clone $baseQuery)
            ->where('published_at', '>=', now()->subDays($days))
            ->orderByDesc('views_count')
            ->latest('published_at')
            ->take($limit)
            ->get();

        if ($recent->count() >= $limit) {
            return $recent;
        }

        // 2. Backfill with all-time most viewed / latest published articles
        $allExclude = array_merge($excludeIds, $recent->pluck('id')->toArray());
        $remaining = $limit - $recent->count();

        $backfill = (clone $baseQuery)
            ->whereNotIn('id', $allExclude)
            ->orderByDesc('views_count')
            ->latest('published_at')
            ->take($remaining)
            ->get();

        return $recent->concat($backfill);
    }

    // PostgreSQL Full Text Search Scope
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        // Clean query terms for PostgreSQL tsquery
        $cleanTerm = trim(preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $term));
        if (empty($cleanTerm)) {
            return $query;
        }

        if (config('database.default') === 'pgsql') {
            return $query->where(function ($q) use ($cleanTerm) {
                $q->whereRaw(
                    "to_tsvector('indonesian', coalesce(title, '') || ' ' || coalesce(subtitle, '') || ' ' || coalesce(excerpt, '') || ' ' || coalesce(content, '')) @@ plainto_tsquery('indonesian', ?)",
                    [$cleanTerm]
                )->orWhere('title', 'ilike', "%{$cleanTerm}%")
                 ->orWhere('subtitle', 'ilike', "%{$cleanTerm}%")
                 ->orWhere('excerpt', 'ilike', "%{$cleanTerm}%");
            })->orderByRaw(
                "ts_rank(to_tsvector('indonesian', coalesce(title, '') || ' ' || coalesce(subtitle, '') || ' ' || coalesce(excerpt, '') || ' ' || coalesce(content, '')), plainto_tsquery('indonesian', ?)) DESC",
                [$cleanTerm]
            );
        }

        return $query->where(function ($q) use ($cleanTerm) {
            $q->where('title', 'like', "%{$cleanTerm}%")
              ->orWhere('excerpt', 'like', "%{$cleanTerm}%")
              ->orWhere('content', 'like', "%{$cleanTerm}%");
        });
    }

    // Accessors & Helpers
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return max(1, (int) $minutes);
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image && file_exists(public_path('storage/' . $this->featured_image))) {
            return asset('storage/' . $this->featured_image);
        }
        if ($this->featured_image && Str::startsWith($this->featured_image, ['http://', 'https://'])) {
            return $this->featured_image;
        }
        // Editorial placeholder image
        return asset('images/placeholder-news.jpg');
    }

    public function isBookmarkedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }
}
