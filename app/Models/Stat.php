<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Stat extends Model
{
    protected $fillable = [
        'title',
        'value',
        'description',
        'icon',
        'color',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($stat) {
            Cache::forget('stats_active');
            Cache::forget('stats_featured');
        });

        static::deleted(function ($stat) {
            Cache::forget('stats_active');
            Cache::forget('stats_featured');
        });
    }

    /**
     * Get active stats
     */
    public static function getActive()
    {
        return Cache::remember('stats_active', 3600, function () {
            return static::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }

    /**
     * Get featured stats
     */
    public static function getFeatured()
    {
        return Cache::remember('stats_featured', 3600, function () {
            return static::where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('sort_order')
                ->get();
        });
    }

    /**
     * Scope for active stats
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured stats
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordered stats
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
