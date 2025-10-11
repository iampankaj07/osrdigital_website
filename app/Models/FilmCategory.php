<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FilmCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saved(function ($category) {
            Cache::forget('film_categories');
            Cache::forget('film_categories_active');
        });
        
        static::deleted(function ($category) {
            Cache::forget('film_categories');
            Cache::forget('film_categories_active');
        });
    }

    public function filmPortfolios()
    {
        return $this->hasMany(FilmPortfolio::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public static function getActiveCategories()
    {
        return Cache::remember('film_categories_active', 3600, function () {
            return static::active()->ordered()->get();
        });
    }

    public static function getAllCategories()
    {
        return Cache::remember('film_categories', 3600, function () {
            return static::ordered()->get();
        });
    }
}
