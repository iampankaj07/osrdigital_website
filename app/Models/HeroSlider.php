<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HeroSlider extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'media_id',
        'button_text',
        'button_url',
        'button_text_secondary',
        'button_url_secondary',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected $appends = [
        'image_url'
    ];

    public function mediaRecord()
    {
        return $this->belongsTo(\Spatie\MediaLibrary\MediaCollections\Models\Media::class, 'media_id');
    }

    public function getImageUrlAttribute()
    {
        // First try the direct media_id relationship
        if ($this->media_id && $this->mediaRecord) {
            return $this->mediaRecord->getFullUrl();
        }

        // Fallback to Spatie media collection
        $media = $this->getFirstMedia('media-library');
        if ($media) {
            return $media->getFullUrl();
        }

        // Return null if no image available
        return null;
    }

    /**
     * Scope for active slides
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered slides
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Check if primary button should be displayed
     */
    public function shouldShowButton()
    {
        return !empty($this->button_text) && !empty($this->button_url);
    }

    /**
     * Check if secondary button should be displayed
     */
    public function shouldShowSecondaryButton()
    {
        return !empty($this->button_text_secondary) && !empty($this->button_url_secondary);
    }
}
