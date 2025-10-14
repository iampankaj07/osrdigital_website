<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'role',
        'company',
        'content',
        'project',
        'avatar_url',
        'media_id',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($testimonial) {
            Cache::forget('testimonials');
            Cache::forget('testimonials_featured');
            Cache::forget('testimonials_published');
        });

        static::deleted(function ($testimonial) {
            Cache::forget('testimonials');
            Cache::forget('testimonials_featured');
            Cache::forget('testimonials_published');
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function media()
    {
        return $this->belongsTo(\Spatie\MediaLibrary\MediaCollections\Models\Media::class);
    }

    public function getAvatarUrlAttribute($value)
    {
        // Use media library first, then fallback to existing logic
        if ($this->media) {
            return $this->media->getFullUrl();
        }

        // Use ImageHelper for dynamic image handling
        return ImageHelper::getContextualImage(
            $value,
            'avatar',
            ['width' => 64, 'height' => 64, 'text' => $this->name]
        );
    }

    public static function getFeaturedTestimonials($limit = 4)
    {
        return Cache::remember('testimonials_featured_' . $limit, 3600, function () use ($limit) {
            return static::featured()
                ->published()
                ->ordered()
                ->limit($limit)
                ->get();
        });
    }

    public static function getPublishedTestimonials($limit = 10)
    {
        return Cache::remember('testimonials_published_' . $limit, 3600, function () use ($limit) {
            return static::published()
                ->ordered()
                ->limit($limit)
                ->get();
        });
    }
}
