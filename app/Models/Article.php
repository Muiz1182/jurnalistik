<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

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
                while (static::withTrashed()->where('slug', $slug)->exists()) {
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
            ->where('published_at', '>=', now()->subDays($days))
            ->orderByDesc('views_count');
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
