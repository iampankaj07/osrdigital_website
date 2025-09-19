<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ThemeHelper
{
    /**
     * Get a theme setting value
     */
    public static function get(string $key, $default = null)
    {
        return db_config("general.{$key}", $default);
    }

    /**
     * Get logo URL
     */
    public static function logo(): ?string
    {
        $logoPath = static::get('site_logo');
        if ($logoPath) {
            return Storage::url($logoPath);
        }
        return null;
    }

    /**
     * Get favicon URL
     */
    public static function favicon(): ?string
    {
        $faviconPath = static::get('site_favicon');
        if ($faviconPath) {
            return Storage::url($faviconPath);
        }
        return null;
    }

    /**
     * Get company information
     */
    public static function company(): array
    {
        return [
            'name' => static::get('site_name', 'OSR Digital'),
            'tagline' => static::get('site_description', 'Your digital partner'),
            'email' => static::get('support_email') ?: static::get('contact_email'),
            'phone' => static::get('support_phone') ?: static::get('contact_phone'),
            'address' => static::get('office_address'),
        ];
    }

    /**
     * Get theme colors
     */
    public static function colors(): array
    {
        return [
            'primary' => static::get('theme_color') ?: static::get('primary_color', '#3b82f6'),
            'secondary' => static::get('secondary_color', '#64748b'),
        ];
    }

    /**
     * Get social media links
     */
    public static function social(): array
    {
        $socialNetwork = static::get('social_network');
        $socialData = [];

        if ($socialNetwork && is_string($socialNetwork)) {
            $socialData = json_decode($socialNetwork, true) ?? [];
        } elseif (is_array($socialNetwork)) {
            $socialData = $socialNetwork;
        }

        return [
            'facebook' => $socialData['facebook'] ?? static::get('facebook_url'),
            'twitter' => $socialData['twitter'] ?? static::get('twitter_url'),
            'linkedin' => $socialData['linkedin'] ?? static::get('linkedin_url'),
        ];
    }

    /**
     * Get header settings
     */
    public static function header(): array
    {
        return [
            'cta_text' => static::get('header_cta_text', 'Get Started'),
            'cta_url' => static::get('header_cta_url', '/contact'),
        ];
    }

    /**
     * Get footer settings
     */
    public static function footer(): array
    {
        return [
            'copyright' => static::get('footer_copyright', 'Copyright © 2025 OSR Digital. All rights reserved.'),
            'description' => static::get('footer_description'),
        ];
    }

    /**
     * Check if dark mode is enabled
     */
    public static function isDarkModeEnabled(): bool
    {
        return (bool) static::get('dark_mode_enabled', false);
    }

    /**
     * Get SEO settings
     */
    public static function seo(): array
    {
        $metadata = static::get('seo_metadata');
        $metadataArray = [];

        if ($metadata && is_string($metadata)) {
            $metadataArray = json_decode($metadata, true) ?? [];
        } elseif (is_array($metadata)) {
            $metadataArray = $metadata;
        }

        return [
            'title' => static::get('seo_title'),
            'keywords' => static::get('seo_keywords'),
            'metadata' => $metadataArray,
        ];
    }

    /**
     * Get analytics settings
     */
    public static function analytics(): array
    {
        return [
            'google_analytics_id' => static::get('google_analytics_id'),
            'posthog_html_snippet' => static::get('posthog_html_snippet'),
        ];
    }

    /**
     * Get all theme settings for frontend
     */
    public static function allForFrontend(): array
    {
        return Cache::remember('theme_frontend_settings', 3600, function () {
            $result = [
                'site_name' => static::get('site_name'),
                'site_description' => static::get('site_description'),
                'theme_color' => static::get('theme_color'),
                'support_email' => static::get('support_email'),
                'support_phone' => static::get('support_phone'),
                'seo_title' => static::get('seo_title'),
                'seo_keywords' => static::get('seo_keywords'),
            ];

            // Add logo and favicon URLs
            $logoPath = static::get('site_logo');
            if ($logoPath) {
                $result['site_logo'] = Storage::url($logoPath);
            }
            
            $faviconPath = static::get('site_favicon');
            if ($faviconPath) {
                $result['site_favicon'] = Storage::url($faviconPath);
            }

            // Add social networks
            $socialNetwork = static::get('social_network');
            if ($socialNetwork) {
                if (is_string($socialNetwork)) {
                    $result['social_network'] = json_decode($socialNetwork, true);
                } else {
                    $result['social_network'] = $socialNetwork;
                }
            }

            return $result;
        });
    }

    /**
     * Clear theme settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('theme_frontend_settings');
    }
}
