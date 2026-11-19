<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EditorialMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'division',
        'class_or_grade',
        'photo',
        'bio',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (EditorialMember $member) {
            if ($member->photo && !Str::startsWith($member->photo, ['http://', 'https://']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($member->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($member->photo);
            }
        });
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('storage/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }
        if ($this->photo && Str::startsWith($this->photo, ['http://', 'https://'])) {
            return $this->photo;
        }
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&background=0A2540&color=FFFFFF&size=200";
    }
}
