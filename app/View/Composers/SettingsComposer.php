<?php

namespace App\View\Composers;

use App\Helpers\SettingsHelper;
use App\Helpers\ThemeHelper;
use Illuminate\View\View;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $company = ThemeHelper::company();
        $colors = ThemeHelper::colors();
        $social = ThemeHelper::social();
        $seo = ThemeHelper::seo();

        $settings = [
            // Core site information
            'site_name' => $company['name'],
            'site_tagline' => $company['tagline'],
            'site_description' => $company['tagline'],

            // Logos and branding
            'logo' => ThemeHelper::logo(),
            'logo_light' => ThemeHelper::logo(),
            'logo_dark' => ThemeHelper::logo(),
            'admin_logo' => ThemeHelper::logo(),
            'favicon' => ThemeHelper::favicon(),

            // Theme and colors
            'theme_color' => $colors['primary'],
            'primary_color' => $colors['primary'],
            'secondary_color' => $colors['secondary'],
            'default_theme' => SettingsHelper::getDefaultTheme(),
            'enable_dark_mode' => ThemeHelper::isDarkModeEnabled(),

            // Contact information
            'contact' => [
                'email' => $company['email'],
                'phone' => $company['phone'],
                'address' => $company['address'],
            ],
            'support_email' => $company['email'],
            'support_phone' => $company['phone'],

            // Social media
            'social' => $social,
            'social_facebook' => $social['facebook'],
            'social_twitter' => $social['twitter'],
            'social_linkedin' => $social['linkedin'],

            // SEO
            'seo_title' => $seo['title'],
            'seo_keywords' => $seo['keywords'],
            'seo_metadata' => $seo['metadata'],

            // Header and footer
            'header' => ThemeHelper::header(),
            'footer' => ThemeHelper::footer(),

            // Analytics
            'analytics' => ThemeHelper::analytics(),

            // Maintenance and other settings
            'maintenance_mode' => SettingsHelper::isMaintenanceMode(),

            // All frontend settings (for comprehensive access)
            'all' => ThemeHelper::allForFrontend(),
        ];

        $view->with('settings', $settings);
    }
}
