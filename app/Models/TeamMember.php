<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'position',
        'department',
        'description',
        'avatar',
        'media_id',
        'linkedin',
        'twitter',
        'email',
        'phone',
        'social_links',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'social_links' => 'array',
    ];

    protected $appends = [
        'image_url',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function media()
    {
        return $this->belongsTo(\Spatie\MediaLibrary\MediaCollections\Models\Media::class, 'media_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($teamMember) {
            if (empty($teamMember->slug)) {
                $teamMember->slug = Str::slug($teamMember->name);
            }
        });

        static::updating(function ($teamMember) {
            if ($teamMember->isDirty('name') && empty($teamMember->slug)) {
                $teamMember->slug = Str::slug($teamMember->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getAvatarUrlAttribute()
    {
        // First check if we have a media library item
        if ($this->media_id && $this->media) {
            return $this->media->getFullUrl();
        }

        // Then check if we have a direct avatar path
        if ($this->avatar) {
            // If it's already a full URL, return it
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            // Otherwise, generate storage URL
            return Storage::url($this->avatar);
        }

        return null;
    }

    public function getImageUrlAttribute()
    {
        return $this->getAvatarUrlAttribute();
    }

    public function getImageAttribute()
    {
        return $this->avatar_url;
    }
}
