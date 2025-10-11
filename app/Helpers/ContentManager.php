<?php

namespace App\Helpers;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ContentManager
{
    /**
     * Get all content for the frontend in a single, structured call
     */
    public static function getAllContent(): array
    {
        return Cache::remember('all_frontend_content', 3600, function () {
            $content = [];

            // 1. Global Settings (from Setting model)
            $content['settings'] = Setting::where('is_public', true)->pluck('value', 'key')->toArray();

            // 2. Dynamic Pages (from DynamicPage model)
            $content['dynamic_pages'] = \App\Models\DynamicPage::published()->ordered()->get()->map(function ($page) {
                return [
                    'id' => $page->id,
                    'slug' => $page->slug,
                    'title' => $page->title,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                    'template' => $page->template,
                    'settings' => $page->settings ?? [],
                    'content_blocks' => $page->content_blocks_data,
                    'url' => $page->url,
                    'is_homepage' => $page->is_homepage,
                    'created_at' => $page->created_at,
                    'updated_at' => $page->updated_at,
                ];
            })->keyBy('slug')->toArray();

            // 3. Pages (from Page model) - Legacy support
            $content['pages'] = Page::published()->get()->keyBy('slug')->toArray();

            // 4. News (from News model)
            $content['news'] = \App\Models\News::published()->recent()->get()->toArray();

            // 5. Portfolio (from Portfolio model)
            $portfolioItems = \App\Models\Portfolio::published()->orderBy('created_at', 'desc')->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'slug' => $item->slug,
                    'title' => $item->title,
                    'description' => strip_tags($item->description),
                    'type' => $item->type,
                    'category' => $item->category,
                    'views' => $item->views,
                    'image' => $item->image_url,
                    'is_featured' => $item->is_featured,
                    'created_at' => $item->created_at,
                ];
            });
            $content['portfolio'] = [
                'all' => $portfolioItems->toArray(),
                'featured' => $portfolioItems->where('is_featured', true)->take(6)->toArray(),
            ];

            // 6. Partners (removed - using Associates instead)
            $content['partners'] = [];

            // 7. Team (from Team model)
            $content['team'] = \App\Models\Team::active()->ordered()->get()->map(function ($team) {
                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'slug' => $team->slug,
                    'position' => $team->position,
                    'description' => $team->description,
                    'email' => $team->email,
                    'phone' => $team->phone,
                    'image' => $team->image_url,
                    'social_links' => $team->social_links,
                    'sort_order' => $team->sort_order,
                ];
            })->toArray();

            // 8. Business (removed - using Associates instead)
            $content['business'] = [];

            // 9. Content Blocks (reusable blocks)
            $content['content_blocks'] = \App\Models\ContentBlock::active()->reusable()->ordered()->get()->map(function ($block) {
                return [
                    'id' => $block->id,
                    'type' => $block->type,
                    'name' => $block->name,
                    'data' => $block->data,
                    'settings' => $block->settings ?? [],
                    'category' => $block->category,
                ];
            })->keyBy('id')->toArray();

            // 10. Dynamic Stats (from Settings)
            $content['stats'] = [
                ['number' => self::getSetting('stats_movies_count', '500+'), 'label' => self::getSetting('stats_movies_label', 'Movies Published'), 'icon' => '🎬'],
                ['number' => self::getSetting('stats_songs_count', '2,000+'), 'label' => self::getSetting('stats_songs_label', 'Songs Released'), 'icon' => '🎵'],
                ['number' => self::getSetting('stats_films_count', '800+'), 'label' => self::getSetting('stats_films_label', 'Short Films'), 'icon' => '🎥'],
                ['number' => self::getSetting('stats_views_count', '50M+'), 'label' => self::getSetting('stats_views_label', 'Total Views'), 'icon' => '👁️']
            ];

            return $content;
        });
    }

    /**
     * Get a specific setting by key
     */
    public static function getSetting(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Get a specific page by slug
     */
    public static function getPageBySlug(string $slug)
    {
        return Page::where('slug', $slug)->where('is_published', true)->first();
    }

    /**
     * Get all settings (public and private)
     */
    public static function getAllSettings(): array
    {
        return Cache::remember('all_settings_flat', 3600, function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get logo URL based on type
     */
    public static function getLogoUrl(?string $type = 'default'): string
    {
        // Prioritize static file for reliability
        if (file_exists(public_path('images/logo.png'))) {
            return asset('images/logo.png');
        }

        // Fallback to database settings
        $settings = self::getAllSettings();
        $settingKeyMap = [
            'default' => 'site_logo',
            'seeklogo' => 'site_logo',
            'main' => 'site_logo',
            'dark' => 'logo_dark',
            'mobile' => 'logo_mobile',
            'admin' => 'logo_admin',
            'light' => 'logo_light',
            'footer' => 'logo_footer',
            'email' => 'logo_email'
        ];

        $settingKey = $settingKeyMap[$type] ?? 'site_logo';
        $logoPath = $settings[$settingKey] ?? null;

        if ($logoPath) {
            // Check if the path is already a full URL
            if (filter_var($logoPath, FILTER_VALIDATE_URL)) {
                return $logoPath;
            }
            // Assume it's a storage path
            return \Illuminate\Support\Facades\Storage::url($logoPath);
        }

        // Fallback to default logo if nothing is set
        return asset('images/logo-placeholder.png');
    }

    /**
     * Get a specific dynamic page by slug
     */
    public static function getDynamicPage(string $slug)
    {
        return Cache::remember("dynamic_page_{$slug}", 3600, function () use ($slug) {
            $page = \App\Models\DynamicPage::where('slug', $slug)
                ->where('is_published', true)
                ->first();
            
            if (!$page) {
                return null;
            }

            return [
                'id' => $page->id,
                'slug' => $page->slug,
                'title' => $page->title,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'template' => $page->template,
                'settings' => $page->settings ?? [],
                'content_blocks' => $page->content_blocks_data,
                'url' => $page->url,
                'is_homepage' => $page->is_homepage,
                'created_at' => $page->created_at,
                'updated_at' => $page->updated_at,
            ];
        });
    }

    /**
     * Get homepage dynamic page
     */
    public static function getHomepage()
    {
        return Cache::remember('homepage_dynamic', 3600, function () {
            $page = \App\Models\DynamicPage::where('is_homepage', true)
                ->where('is_published', true)
                ->first();
            
            if (!$page) {
                return null;
            }

            return [
                'id' => $page->id,
                'slug' => $page->slug,
                'title' => $page->title,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'template' => $page->template,
                'settings' => $page->settings ?? [],
                'content_blocks' => $page->content_blocks_data,
                'url' => $page->url,
                'is_homepage' => $page->is_homepage,
                'created_at' => $page->created_at,
                'updated_at' => $page->updated_at,
            ];
        });
    }

    /**
     * Get all content blocks
     */
    public static function getAllContentBlocks()
    {
        return Cache::remember('all_content_blocks', 3600, function () {
            return \App\Models\ContentBlock::active()->ordered()->get()->map(function ($block) {
                return [
                    'id' => $block->id,
                    'type' => $block->type,
                    'name' => $block->name,
                    'data' => $block->data,
                    'settings' => $block->settings ?? [],
                    'category' => $block->category,
                    'is_reusable' => $block->is_reusable,
                ];
            })->toArray();
        });
    }

    /**
     * Clear all content manager cache
     */
    public static function clearCache(): void
    {
        Cache::forget('all_frontend_content');
        Cache::forget('all_settings_flat');
        Cache::forget('all_content_blocks');
        Cache::forget('homepage_dynamic');
        
        // Clear individual setting caches
        $settings = Setting::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
        
        // Clear page caches
        Page::all()->each(function ($page) {
            Cache::forget("page_{$page->slug}");
        });

        // Clear dynamic page caches
        \App\Models\DynamicPage::all()->each(function ($page) {
            Cache::forget("dynamic_page_{$page->slug}");
        });
    }
}