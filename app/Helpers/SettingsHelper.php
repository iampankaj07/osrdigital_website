<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\GeneralSetting;

class SettingsHelper
{
    /**
     * Get a public setting value
     */
    public static function get(string $key, $default = null)
    {
        $value = ThemeHelper::get($key, $default);

        // Provide fallbacks for logo keys to use site_logo if specific logos aren't set
        if (is_null($value) && in_array($key, ['logo_light', 'logo_dark', 'logo_admin', 'logo_mobile', 'logo_footer', 'logo_email'])) {
            $value = ThemeHelper::get('site_logo', $default);
        }

        return $value;
    }

    /**
     * Get all public settings
     */
    public static function all(): array
    {
        return ThemeHelper::allForFrontend();
    }

    /**
     * Get logo based on theme
     */
    public static function logo(?string $type = null): ?string
    {
        // Always use static logo file for cloud deployment reliability
        if (file_exists(public_path('images/logo.png'))) {
            return asset('images/logo.png');
        }

        // Fallback to database settings if static file doesn't exist
        // Map logo types to ThemeHelper keys
        $keyMap = [
            null => 'logo_light',        // Default logo
            'light' => 'logo_light',
            'dark' => 'logo_dark',
            'admin' => 'logo_admin',
            'mobile' => 'logo_mobile',
            'footer' => 'logo_footer',
            'email' => 'logo_email',
        ];

        $settingKey = $keyMap[$type] ?? 'logo_light';

        // Use ThemeHelper to get the logo path from more_configs
        $logoPath = ThemeHelper::get($settingKey);

        if (!$logoPath) {
            // Fallback to site_logo if no specific logo type is set
            $logoPath = ThemeHelper::get('site_logo');
        }

        if (!$logoPath) {
            return asset('images/logo-placeholder.svg');
        }

        // Check if the path is already a full URL
        if (str_starts_with($logoPath, 'http')) {
            return $logoPath;
        }

        // Check if file exists in storage
        if (Storage::disk('public')->exists($logoPath)) {
            return asset('storage/' . $logoPath);
        }

        Log::warning('Logo file not found in storage: ' . $logoPath);
        return asset('images/logo-placeholder.svg');
    }

    /**
     * Get admin logo
     */
    public static function getAdminLogo(): ?string
    {
        $logoPath = self::getAdminLogoPath();
        if ($logoPath) {
            // Handle both relative and absolute paths
            if (str_starts_with($logoPath, 'http')) {
                return $logoPath;
            }
            // Generate the correct storage URL
            return asset('storage/' . $logoPath);
        }
        return self::logo();
    }

    /**
     * Get admin logo path (without Storage::url)
     */
    public static function getAdminLogoPath(): ?string
    {
        return self::get('logo_admin') ?? self::get('logo_light') ?? self::get('site_logo');
    }

    /**
     * Get mobile logo
     */
    public static function getMobileLogo(): ?string
    {
        return self::get('logo_mobile') ?? self::logo();
    }

    /**
     * Get footer logo
     */
    public static function getFooterLogo(): ?string
    {
        return self::get('logo_footer') ?? self::logo();
    }

    /**
     * Get email logo
     */
    public static function getEmailLogo(): ?string
    {
        return self::get('logo_email') ?? self::logo();
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
        $company = ThemeHelper::company();
        return $company['name'] ?? config('app.name', 'OSR Digital');
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
        $services = self::get('footer_services', [
            ['service' => 'Content Acquisition'],
            ['service' => 'YouTube Publishing'],
            ['service' => 'Digital Distribution'],
            ['service' => 'Rights Management'],
            ['service' => 'Content Strategy'],
        ]);

        // Convert from repeater format to simple array
        if (is_array($services) && isset($services[0]['service'])) {
            return array_map(fn($item) => $item['service'], $services);
        }

        // Fallback for legacy format
        return $services ?: [
            'Content Acquisition',
            'YouTube Publishing',
            'Digital Distribution',
            'Rights Management',
            'Content Strategy',
        ];
    }

    /**
     * Get footer copyright text
     */
    public static function getFooterCopyrightText(): string
    {
        return self::get('footer_copyright_text', '© 2025 OSR Digital. All rights reserved.');
    }

    /**
     * Get footer social links
     */
    public static function getFooterSocialLinks(): array
    {
        return self::get('footer_social_links', [
            'youtube' => 'https://youtube.com/@osrdigital',
            'twitter' => 'https://twitter.com/osrdigital',
            'linkedin' => 'https://linkedin.com/company/osrdigital',
            'instagram' => 'https://instagram.com/osrdigital',
        ]);
    }

    /**
     * Get footer legal links
     */
    public static function getFooterLegalLinks(): array
    {
        return self::get('footer_legal_links', [
            ['text' => 'Privacy Policy', 'url' => '/privacy'],
            ['text' => 'Terms of Service', 'url' => '/terms'],
            ['text' => 'Cookie Policy', 'url' => '/cookies'],
        ]);
    }
}
