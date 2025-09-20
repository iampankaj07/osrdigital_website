<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_name',
        'tags',
        'status',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
    ];

    // Cache frequently accessed data
    protected static $cacheTags = ['news'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });

        static::saved(function ($news) {
            Cache::forget('news.published.*');
            Cache::forget('news.featured.*');
        });

        static::deleted(function ($news) {
            Cache::forget('news.published.*');
            Cache::forget('news.featured.*');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Cache methods for performance
    public static function getPublishedNews($limit = 10)
    {
        return Cache::remember('news.published.' . $limit, 3600, function () use ($limit) {
            return static::published()
                ->recent()
                ->limit($limit)
                ->select(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'author_name'])
                ->get();
        });
    }

    public static function getFeaturedNews($limit = 5)
    {
        return Cache::remember('news.featured.' . $limit, 3600, function () use ($limit) {
            return static::published()
                ->recent()
                ->limit($limit)
                ->get();
        });
    }
}
