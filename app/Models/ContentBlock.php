<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = [
        'type',
        'name',
        'data',
        'settings',
        'category',
        'is_reusable',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'data' => 'array',
        'settings' => 'array',
        'is_reusable' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($block) {
            \Illuminate\Support\Facades\Cache::forget("content_block_{$block->id}");
            \Illuminate\Support\Facades\Cache::forget('all_content_blocks');
        });

        static::deleted(function ($block) {
            \Illuminate\Support\Facades\Cache::forget("content_block_{$block->id}");
            \Illuminate\Support\Facades\Cache::forget('all_content_blocks');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeReusable($query)
    {
        return $query->where('is_reusable', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function getRenderedDataAttribute()
    {
        return $this->data;
    }
}
