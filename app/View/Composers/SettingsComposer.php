<?php

namespace App\View\Composers;

use App\Helpers\SettingsHelper;
use Illuminate\View\View;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $settings = [
            'site_name' => SettingsHelper::getSiteName(),
            'site_tagline' => SettingsHelper::getSiteTagline(),
            'logo_light' => SettingsHelper::getLogo('light'),
            'logo_dark' => SettingsHelper::getLogo('dark'),
            'admin_logo' => SettingsHelper::getAdminLogo(),
            'default_theme' => SettingsHelper::getDefaultTheme(),
            'enable_dark_mode' => SettingsHelper::isDarkModeEnabled(),
            'maintenance_mode' => SettingsHelper::isMaintenanceMode(),
            'contact' => SettingsHelper::getContactInfo(),
            'social' => SettingsHelper::getSocialLinks(),
        ];

        $view->with('settings', $settings);
    }
}
