<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'icon',
        'image',
        'features',
        'pricing',
        'is_featured',
        'is_active',
        'sort_order',
        'slug',
    ];

    protected $casts = [
        'features' => 'array',
        'pricing' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($service) {
            Cache::forget('services_active');
            Cache::forget('services_featured');
        });

        static::deleted(function ($service) {
            Cache::forget('services_active');
            Cache::forget('services_featured');
        });
    }

    /**
     * Get active services
     */
    public static function getActive()
    {
        return Cache::remember('services_active', 3600, function () {
            return static::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }

    /**
     * Get featured services
     */
    public static function getFeatured()
    {
        return Cache::remember('services_featured', 3600, function () {
            return static::where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('sort_order')
                ->get();
        });
    }

    /**
     * Scope for active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured services
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordered services
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
