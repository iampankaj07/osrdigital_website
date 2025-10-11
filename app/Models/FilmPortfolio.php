<?php

namespace App\Models;

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
        'gallery_images',
        'video_url',
        'rating',
        'duration',
        'category_id',
        'is_featured',
        'is_published',
        'sort_order',
        'metadata',
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
        if (!empty($this->attributes['featured_image'])) {
            return asset('storage/' . $this->attributes['featured_image']);
        }

        if (!empty($value)) {
            return $value;
        }

        return 'https://images.pexels.com/photos/7991579/pexels-photo-7991579.jpeg?auto=compress&cs=tinysrgb&w=800';
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
