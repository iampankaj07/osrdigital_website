<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'position',
        'email',
        'phone',
        'image',
        'media_id',
        'social_links',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_url',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            if (empty($team->slug)) {
                $team->slug = Str::slug($team->name);
            }
        });

        static::updating(function ($team) {
            if ($team->isDirty('name') && empty($team->slug)) {
                $team->slug = Str::slug($team->name);
            }
        });
    }

    public function getImageUrlAttribute()
    {
        // Try media library first
        if ($this->media_id && $this->media) {
            return $this->media->getFullUrl();
        }

        // Fallback to direct image field
        if ($this->image) {
            return Storage::url($this->image);
        }

        return null;
    }

    public function media()
    {
        return $this->belongsTo(\Spatie\MediaLibrary\MediaCollections\Models\Media::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
