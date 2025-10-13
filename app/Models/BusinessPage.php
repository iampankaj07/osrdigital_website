<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BusinessPage extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'meta_title',
        'meta_description',
        'hero_image',
        'hero_video',
        'content_sections',
        'features',
        'statistics',
        'call_to_action',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'content_sections' => 'array',
        'features' => 'array',
        'statistics' => 'array',
        'call_to_action' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($businessPage) {
            Cache::forget('business_page_data');
        });

        static::deleted(function ($businessPage) {
            Cache::forget('business_page_data');
        });
    }

    /**
     * Get the active business page data
     */
    public static function getActiveData()
    {
        return Cache::remember('business_page_data', 3600, function () {
            return self::where('is_active', true)
                ->orderBy('sort_order')
                ->first();
        });
    }

    /**
     * Scope for active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get formatted content sections for frontend
     */
    public function getFormattedContentSections()
    {
        $sections = $this->content_sections ?? [];

        return collect($sections)->map(function ($section) {
            return [
                'id' => $section['id'] ?? uniqid(),
                'type' => $section['type'] ?? 'text',
                'title' => $section['title'] ?? '',
                'content' => $section['content'] ?? '',
                'image' => $section['image'] ?? null,
                'settings' => $section['settings'] ?? [],
            ];
        });
    }

    /**
     * Get formatted features for frontend
     */
    public function getFormattedFeatures()
    {
        $features = $this->features ?? [];

        return collect($features)->map(function ($feature) {
            return [
                'id' => $feature['id'] ?? uniqid(),
                'title' => $feature['title'] ?? '',
                'description' => $feature['description'] ?? '',
                'icon' => $feature['icon'] ?? null,
                'image' => $feature['image'] ?? null,
            ];
        });
    }

    /**
     * Get formatted statistics for frontend
     */
    public function getFormattedStatistics()
    {
        $statistics = $this->statistics ?? [];

        return collect($statistics)->map(function ($stat) {
            return [
                'id' => $stat['id'] ?? uniqid(),
                'label' => $stat['label'] ?? '',
                'value' => $stat['value'] ?? '',
                'suffix' => $stat['suffix'] ?? '',
                'icon' => $stat['icon'] ?? null,
            ];
        });
    }
}
