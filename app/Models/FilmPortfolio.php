<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FilmPortfolio extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'genre',
        'year',
        'image_url',
        'featured_image',
        'media_id',
        'gallery_images',
        'video_url',
        'link',
        'rating',
        'duration',
        'category_id',
        'is_featured',
        'is_published',
        'sort_order',
        'metadata',
        'views',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'rating' => 'decimal:1',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($film) {
            if (empty($film->slug)) {
                $film->slug = Str::slug($film->title);
            }
        });

        static::saved(function ($film) {
            Cache::forget('film_portfolios');
            Cache::forget('film_portfolios_featured');
            Cache::forget('film_portfolios_published');
        });

        static::deleted(function ($film) {
            Cache::forget('film_portfolios');
            Cache::forget('film_portfolios_featured');
            Cache::forget('film_portfolios_published');
        });
    }

    public function category()
    {
        return $this->belongsTo(FilmCategory::class, 'category_id');
    }

    public function media()
    {
        return $this->belongsTo(\Spatie\MediaLibrary\MediaCollections\Models\Media::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function getImageUrlAttribute($value)
    {
        // Use media library first, then fallback to existing logic
        if ($this->media) {
            return $this->media->getFullUrl();
        }

        // Use ImageHelper for dynamic image handling
        return ImageHelper::getContextualImage(
            $this->attributes['featured_image'] ?? $value,
            'card',
            ['width' => 400, 'height' => 300, 'text' => 'Film Portfolio']
        );
    }

    public function getFeaturedImageUrlAttribute()
    {
        // Use media library first, then fallback to existing logic
        if ($this->media) {
            return $this->media->getFullUrl();
        }

        return ImageHelper::getContextualImage(
            $this->attributes['featured_image'],
            'hero',
            ['width' => 800, 'height' => 600, 'text' => 'Featured Film']
        );
    }

    public function getThumbnailUrlAttribute()
    {
        // Use media library first, then fallback to existing logic
        if ($this->media) {
            return $this->media->getFullUrl();
        }

        return ImageHelper::getContextualImage(
            $this->attributes['featured_image'],
            'thumbnail',
            ['width' => 300, 'height' => 200, 'text' => 'Film Thumbnail']
        );
    }

    public static function getFeaturedFilms($limit = 6)
    {
        return Cache::remember('film_portfolios_featured_' . $limit, 3600, function () use ($limit) {
            return static::with('category')
                ->featured()
                ->published()
                ->ordered()
                ->limit($limit)
                ->get();
        });
    }

    public static function getPublishedFilms($limit = 12)
    {
        return Cache::remember('film_portfolios_published_' . $limit, 3600, function () use ($limit) {
            return static::with('category')
                ->published()
                ->ordered()
                ->limit($limit)
                ->get();
        });
    }

    public static function getFilmsByCategory($categoryId, $limit = 12)
    {
        return Cache::remember('film_portfolios_category_' . $categoryId . '_' . $limit, 3600, function () use ($categoryId, $limit) {
            return static::with('category')
                ->byCategory($categoryId)
                ->published()
                ->ordered()
                ->limit($limit)
                ->get();
        });
    }
}
