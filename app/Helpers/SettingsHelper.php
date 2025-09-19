<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get a public setting value
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("public_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = Setting::where('key', $key)
                             ->where('is_public', true)
                             ->first();

            if (!$setting) {
                return $default;
            }

            // Convert value based on type
            $value = $setting->value;

            if ($setting->type === 'boolean') {
                return (bool) $value;
            }

            if ($setting->type === 'json') {
                return json_decode($value, true);
            }

            if ($setting->type === 'integer') {
                return (int) $value;
            }

            return $value;
        });
    }

    /**
     * Get all public settings
     */
    public static function all(): array
    {
        return Cache::remember('all_public_settings', 3600, function () {
            return Setting::getPublicSettings();
        });
    }

    /**
     * Get logo based on theme
     */
    public static function getLogo(?string $theme = null): ?string
    {
        $theme = $theme ?? self::get('default_theme', 'light');

        if ($theme === 'dark') {
            return self::get('logo_dark') ?? self::get('logo_light');
        }

        return self::get('logo_light') ?? self::get('logo_dark');
    }

    /**
     * Get admin logo
     */
    public static function getAdminLogo(): ?string
    {
        return self::get('logo_admin') ?? self::getLogo();
    }

    /**
     * Get mobile logo
     */
    public static function getMobileLogo(): ?string
    {
        return self::get('logo_mobile') ?? self::getLogo();
    }

    /**
     * Get footer logo
     */
    public static function getFooterLogo(): ?string
    {
        return self::get('logo_footer') ?? self::getLogo();
    }

    /**
     * Get email logo
     */
    public static function getEmailLogo(): ?string
    {
        return self::get('logo_email') ?? self::getLogo();
    }

    /**
     * Get favicon
     */
    public static function getFavicon(): ?string
    {
        return self::get('favicon');
    }

    /**
     * Get site name/title
     */
    public static function getSiteTitle(): string
    {
        return self::get('site_title', config('app.name', 'OSR Digital'));
    }

    /**
     * Get site description
     */
    public static function getSiteDescription(): ?string
    {
        return self::get('site_description');
    }

    /**
     * Get site name (legacy method)
     */
    public static function getSiteName(): string
    {
        return self::getSiteTitle();
    }

    /**
     * Get site tagline
     */
    public static function getSiteTagline(): ?string
    {
        return self::get('site_tagline');
    }

    /**
     * Check if dark mode is enabled
     */
    public static function isDarkModeEnabled(): bool
    {
        return (bool) self::get('enable_dark_mode', true);
    }

    /**
     * Get default theme
     */
    public static function getDefaultTheme(): string
    {
        return self::get('default_theme', 'light');
    }

    /**
     * Check if site is in maintenance mode
     */
    public static function isMaintenanceMode(): bool
    {
        return (bool) self::get('maintenance_mode', false);
    }

    /**
     * Get contact information
     */
    public static function getContactInfo(): array
    {
        return [
            'phone' => self::get('contact_phone'),
            'email' => self::get('contact_email'),
            'address' => self::get('contact_address'),
            'hours' => self::get('business_hours'),
        ];
    }

    /**
     * Get social media links
     */
    public static function getSocialLinks(): array
    {
        return [
            'facebook' => self::get('social_facebook'),
            'twitter' => self::get('social_twitter'),
            'instagram' => self::get('social_instagram'),
            'linkedin' => self::get('social_linkedin'),
            'youtube' => self::get('social_youtube'),
        ];
    }

    /**
     * Clear settings cache
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }

    /**
     * Get footer logo settings
     */
    public static function getFooterLogoSettings(): array
    {
        return [
            'height' => (int) self::get('footer_logo_height', 48),
            'width' => (int) self::get('footer_logo_width', 120),
            'opacity' => (float) self::get('footer_logo_opacity', 0.9),
            'show' => (bool) self::get('footer_show_logo', true),
        ];
    }

    /**
     * Get footer company information
     */
    public static function getFooterCompanyInfo(): array
    {
        return [
            'name' => self::get('footer_company_name', 'OSR Digital'),
            'description' => self::get('footer_description', 'Bringing stories to screens worldwide through strategic content acquisition and YouTube publishing.'),
        ];
    }

    /**
     * Get footer contact information
     */
    public static function getFooterContactInfo(): array
    {
        return [
            'email' => self::get('footer_contact_email', 'hello@osrdigital.com'),
            'phone' => self::get('footer_contact_phone', '+1 (555) 123-4567'),
            'address' => self::get('footer_contact_address', 'Los Angeles, CA'),
        ];
    }

    /**
     * Get footer quick links
     */
    public static function getFooterQuickLinks(): array
    {
        return self::get('footer_quick_links', [
            ['text' => 'About Us', 'url' => '#about'],
            ['text' => 'Our Business', 'url' => '#business'],
            ['text' => 'Portfolio', 'url' => '#portfolio'],
            ['text' => 'Partners', 'url' => '#partners'],
        ]);
    }

    /**
     * Get footer services
     */
    public static function getFooterServices(): array
    {
        return self::get('footer_services', [
            'Movie Rights Acquisition',
            'Music Publishing',
            'Short Film Distribution',
            'Content Strategy',
        ]);
    }

    /**
     * Get footer copyright text
     */
    public static function getFooterCopyrightText(): string
    {
        return self::get('footer_copyright_text', '© 2025 OSR Digital. All rights reserved.');
    }
}
