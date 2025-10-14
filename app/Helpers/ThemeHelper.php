<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class ThemeHelper
{
    /**
     * Get a theme setting value
     */
    public static function get(string $key, $default = null)
    {
        // Try to get from GeneralSetting model first
        if (Schema::hasTable('general_settings')) {
            try {
                $setting = \App\Models\GeneralSetting::first();
                if ($setting && isset($setting->{$key})) {
                    return $setting->{$key};
                }
            } catch (\Exception $e) {
                Log::warning("Failed to get setting from GeneralSetting: {$key}", ['error' => $e->getMessage()]);
            }
        }

        // Final fallback to config file
        return config("general.{$key}", $default);
    }

    /**
     * Get logo URL
     */
    public static function logo(): ?string
    {
        // First try to get logo from media library via Settings model
        try {
            $settingsModel = \App\Models\Setting::where('key', 'app_settings')->first();
            if ($settingsModel) {
                $logoMedia = $settingsModel->getFirstMedia('logo');
                if ($logoMedia) {
                    return $logoMedia->getUrl();
                }
            }
        } catch (\Exception $e) {
            Log::warning("Failed to get logo from media library", ['error' => $e->getMessage()]);
        }

        // Fallback to Settings model value
        $logoUrl = \App\Models\Setting::getValue('site_logo');
        if ($logoUrl && str_starts_with($logoUrl, 'http')) {
            return $logoUrl;
        }

        // Always use static logo file for cloud deployment reliability
        if (file_exists(public_path('images/logo.png'))) {
            return asset('images/logo.png');
        }

        // Fallback to database settings if static file doesn't exist
        $logoPath = static::get('site_logo');
        if ($logoPath) {
            // Handle both relative and absolute paths
            if (str_starts_with($logoPath, 'http')) {
                return $logoPath;
            }

            // Check if file exists and generate appropriate URL
            $fullPath = storage_path('app/public/' . $logoPath);
            if (file_exists($fullPath)) {
                return asset('storage/' . $logoPath);
            }

            // Log missing file for debugging
            Log::warning('Logo file not found: ' . $fullPath);
        }

        // Return a placeholder or null if no default logo exists
        return null;
    }

    /**
     * Get favicon URL
     */
    public static function favicon(): ?string
    {
        // First try to get favicon from media library via Settings model
        try {
            $settingsModel = \App\Models\Setting::where('key', 'app_settings')->first();
            if ($settingsModel) {
                $faviconMedia = $settingsModel->getFirstMedia('favicon');
                if ($faviconMedia) {
                    return $faviconMedia->getUrl();
                }
            }
        } catch (\Exception $e) {
            Log::warning("Failed to get favicon from media library", ['error' => $e->getMessage()]);
        }

        // Fallback to Settings model value
        $faviconUrl = \App\Models\Setting::getValue('site_favicon');
        if ($faviconUrl && str_starts_with($faviconUrl, 'http')) {
            return $faviconUrl;
        }

        $faviconPath = static::get('site_favicon');
        if ($faviconPath) {
            // Handle both relative and absolute paths
            if (str_starts_with($faviconPath, 'http')) {
                return $faviconPath;
            }
            // Generate the correct storage URL
            return asset('storage/' . $faviconPath);
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
                'contact_email' => static::get('contact_email'),
                'contact_phone' => static::get('contact_phone'),
                'office_address' => static::get('office_address'),
            ];

            // Add logo URL using the logo() method
            $logoUrl = static::logo();
            if ($logoUrl) {
                $result['site_logo'] = $logoUrl;
            }

            // Add favicon URL using the favicon() method
            $faviconUrl = static::favicon();
            if ($faviconUrl) {
                $result['site_favicon'] = $faviconUrl;
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
