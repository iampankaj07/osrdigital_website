<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TrustedPartner extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'website_url',
        'sort_order',
        'is_active',
        'media_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Media Library relationship
    public function mediaLibrary()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    // Get logo from media library or fallback to logo field
    public function getLogoFromMediaAttribute()
    {
        if ($this->media_id) {
            $media = Media::find($this->media_id);
            return $media ? $media->getFullUrl() : null;
        }
        return null;
    }

    // Register media collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logos')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }
}
