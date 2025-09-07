<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        // If there's a featured_image, use that with storage URL
        if (!empty($this->attributes['featured_image'])) {
            return asset('storage/' . $this->attributes['featured_image']);
        }

        // Otherwise return the direct image_url if it exists
        if (!empty($value)) {
            return $value;
        }

        // Default fallback image
        return 'https://images.pexels.com/photos/7991579/pexels-photo-7991579.jpeg?auto=compress&cs=tinysrgb&w=800';
    }
}
