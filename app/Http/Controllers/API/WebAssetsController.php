<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SettingsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class WebAssetsController extends Controller
{
    /**
     * Return footer configuration for frontend footer component
     */
    public function footer(): JsonResponse
    {
        $logoSettings = SettingsHelper::getFooterLogoSettings();

        return response()->json([
            'success' => true,
            'data' => [
                'logo' => $logoSettings,
                'company' => SettingsHelper::getFooterCompanyInfo(),
                'contact' => SettingsHelper::getFooterContactInfo(),
                'quick_links' => SettingsHelper::getFooterQuickLinks(),
                'services' => SettingsHelper::getFooterServices(),
                'social_links' => SettingsHelper::getFooterSocialLinks(),
                'legal_links' => SettingsHelper::getFooterLegalLinks(),
                'copyright_text' => SettingsHelper::getFooterCopyrightText(),
            ],
        ]);
    }

    /**
     * Return a logo URL for provided type used by frontend Logo component
     */
    public function logo(string $type): JsonResponse
    {
        // Always use static logo for cloud deployment reliability
        if (file_exists(public_path('images/logo.png'))) {
            $url = asset('images/logo.png');
        } else {
            // Fallback to database settings if static file doesn't exist
            // Map frontend logo types to our logo method parameters
            $typeMap = [
                'light' => null,        // Default logo
                'dark' => 'dark',
                'admin' => 'admin',
                'mobile' => 'mobile',
                'footer' => 'footer',
                'email' => 'email',
                'seeklogo' => null,     // Default logo
                'default' => null,      // Default logo
            ];

            $logoType = $typeMap[$type] ?? null;

            // Get the logo URL using the SettingsHelper logo method
            $url = SettingsHelper::logo($logoType);
        }

        return response()->json([
            'success' => (bool) $url,
            'url' => $url,
        ]);
    }
}
