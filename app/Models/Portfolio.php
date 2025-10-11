<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Portfolio extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'excerpt',
        'type',
        'image_url',
        'featured_image',
        'gallery_images',
        'video_url',
        'views',
        'likes',
        'category',
        'client_name',
        'project_date',
        'project_url',
        'github_url',
        'technologies',
        'industry',
        'completion_time',
        'difficulty_level',
        'team_size',
        'project_status',
        'challenges_solved',
        'results_achieved',
        'custom_css',
        'metadata',
        'is_featured',
        'is_published',
        'status',
    ];

    protected $casts = [
        'metadata' => 'array',
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'project_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->title);
            }
        });

        static::saved(function ($portfolio) {
            Cache::forget('portfolio.featured.*');
            Cache::forget('portfolio.published.*');
        });

        static::deleted(function ($portfolio) {
            Cache::forget('portfolio.featured.*');
            Cache::forget('portfolio.published.*');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getImageUrlAttribute($value)
    {
        // Use ImageHelper for dynamic image handling
        return ImageHelper::getContextualImage(
            $this->attributes['featured_image'] ?? $value,
            'card',
            ['width' => 400, 'height' => 300, 'text' => 'Portfolio Item']
        );
    }

    public function getFeaturedImageUrlAttribute()
    {
        return ImageHelper::getContextualImage(
            $this->attributes['featured_image'],
            'hero',
            ['width' => 800, 'height' => 600, 'text' => 'Featured Portfolio']
        );
    }

    public function getThumbnailUrlAttribute()
    {
        return ImageHelper::getContextualImage(
            $this->attributes['featured_image'],
            'thumbnail',
            ['width' => 300, 'height' => 200, 'text' => 'Portfolio Thumbnail']
        );
    }

    // Cache methods for performance
    public static function getFeaturedPortfolios($limit = 6)
    {
        return Cache::remember('portfolio.featured.' . $limit, 3600, function () use ($limit) {
            return static::featured()
                ->published()
                ->limit($limit)
                ->select(['id', 'title', 'slug', 'description', 'featured_image', 'type', 'client_name'])
                ->get();
        });
    }

    public static function getPublishedPortfolios($limit = 12)
    {
        return Cache::remember('portfolio.published.' . $limit, 3600, function () use ($limit) {
            return static::published()
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->select(['id', 'title', 'slug', 'description', 'featured_image', 'type'])
                ->get();
        });
    }
}
