<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'is_published',
        'featured_image',
        'template_type',
        // About template fields
        'about_mission',
        'about_mission_title',
        'about_vision',
        'about_vision_title',
        'about_what_we_do_title',
        'about_what_we_do_description',
        'about_youtube_link',
        'about_services',
        'about_stat_1_value',
        'about_stat_1_label',
        'about_stat_2_value',
        'about_stat_2_label',
        'about_stat_3_value',
        'about_stat_3_label',
        'about_stat_4_value',
        'about_stat_4_label',
        'about_primary_button_text',
        'about_secondary_button_text',
        'about_hero_badge_text',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'about_services' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
