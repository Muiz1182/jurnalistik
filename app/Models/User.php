<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'phone',
        'avatar',
        'bio',
        'title',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function editedArticles(): HasMany
    {
        return $this->hasMany(Article::class, 'editor_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ArticleRevision::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(EditorialAssignment::class, 'reporter_id');
    }

    // Role helper checks
    public function isSuperAdmin(): bool
    {
        return $this->role && $this->role->slug === 'super-admin';
    }

    public function isPemimpinRedaksi(): bool
    {
        return $this->role && in_array($this->role->slug, ['super-admin', 'pemimpin-redaksi']);
    }

    public function isEditor(): bool
    {
        return $this->role && in_array($this->role->slug, ['super-admin', 'pemimpin-redaksi', 'editor']);
    }

    public function isReporter(): bool
    {
        return $this->role && in_array($this->role->slug, ['super-admin', 'pemimpin-redaksi', 'editor', 'reporter']);
    }

    public function isFotografer(): bool
    {
        return $this->role && $this->role->slug === 'fotografer';
    }

    public function hasRole(string|array $roles): bool
    {
        if (!$this->role) return false;
        if (is_string($roles)) {
            return $this->role->slug === $roles;
        }
        return in_array($this->role->slug, $roles);
    }

    public function canAccessDashboard(): bool
    {
        return $this->isReporter() || $this->isFotografer();
    }

    public function canReviewArticles(): bool
    {
        return $this->isPemimpinRedaksi();
    }

    public function canApproveArticles(): bool
    {
        return $this->isPemimpinRedaksi();
    }

    public function canPublishArticles(): bool
    {
        return $this->isPemimpinRedaksi();
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(public_path('storage/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        // Consistent SVG avatar based on initials
        $initials = strtoupper(substr($this->name, 0, 2));
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&background=0A2540&color=FFFFFF&size=128";
    }
}
