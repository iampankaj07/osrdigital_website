<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Associate extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'logo',
        'website',
        'is_active',
        'sort_order',
        'media_id', // For media library integration
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active associates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order associates.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get the logo URL with proper image handling
     */
    public function getLogoUrlAttribute()
    {
        // Use media library first, then fallback to ImageHelper
        $logoUrl = $this->logo_from_media;
        if ($logoUrl) {
            return $logoUrl;
        }

        return ImageHelper::getContextualImage(
            $this->attributes['logo'] ?? null,
            'logo',
            ['width' => 200, 'height' => 100, 'text' => $this->name]
        );
    }

    /**
     * Get the logo URL for admin display
     */
    public function getAdminLogoUrlAttribute()
    {
        // Use media library first, then fallback to ImageHelper
        $logoUrl = $this->logo_from_media;
        if ($logoUrl) {
            return $logoUrl;
        }

        return ImageHelper::getContextualImage(
            $this->attributes['logo'] ?? null,
            'logo',
            ['width' => 150, 'height' => 75, 'text' => $this->name]
        );
    }

    /**
     * Get the logo URL for frontend display
     */
    public function getFrontendLogoUrlAttribute()
    {
        // Use media library first, then fallback to ImageHelper
        $logoUrl = $this->logo_from_media;
        if ($logoUrl) {
            return $logoUrl;
        }

        return ImageHelper::getContextualImage(
            $this->attributes['logo'] ?? null,
            'logo',
            ['width' => 200, 'height' => 100, 'text' => $this->name]
        );
    }

    /**
     * Get logo from media library or fallback to direct URL
     */
    public function getLogoFromMediaAttribute()
    {
        // Try to get from media library first
        if ($this->media_id) {
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($this->media_id);
            if ($media) {
                return $media->getFullUrl();
            }
        }

        // Try to get from media collection
        $logoMedia = $this->getFirstMedia('logo');
        if ($logoMedia) {
            return $logoMedia->getFullUrl();
        }

        // Fallback to logo field with proper URL handling
        if ($this->logo) {
            // Check if it's already a full URL
            if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
                return $this->logo;
            }

            // Handle relative paths
            if (str_starts_with($this->logo, '/')) {
                return asset($this->logo);
            }

            // Handle storage paths
            return asset('storage/' . $this->logo);
        }

        return null;
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml']);
    }

}
