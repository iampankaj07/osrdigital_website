<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DynamicPage extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'meta_description',
        'meta_title',
        'content_blocks',
        'template',
        'settings',
        'is_published',
        'is_homepage',
        'sort_order',
    ];

    protected $casts = [
        'content_blocks' => 'array',
        'settings' => 'array',
        'is_published' => 'boolean',
        'is_homepage' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($page) {
            // Clear cache when page is updated
            \Illuminate\Support\Facades\Cache::forget("dynamic_page_{$page->slug}");
            \Illuminate\Support\Facades\Cache::forget('all_dynamic_pages');
        });

        static::deleted(function ($page) {
            \Illuminate\Support\Facades\Cache::forget("dynamic_page_{$page->slug}");
            \Illuminate\Support\Facades\Cache::forget('all_dynamic_pages');
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeHomepage($query)
    {
        return $query->where('is_homepage', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function getUrlAttribute()
    {
        return $this->is_homepage ? '/' : "/{$this->slug}";
    }

    public function getContentBlocksDataAttribute()
    {
        if (!$this->content_blocks) {
            return [];
        }

        // Get the actual content block data
        $blockIds = array_column($this->content_blocks, 'id');
        return ContentBlock::whereIn('id', $blockIds)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('id')
            ->toArray();
    }
}
