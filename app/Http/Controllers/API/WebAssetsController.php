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
                'copyright_text' => SettingsHelper::getFooterCopyrightText(),
            ],
        ]);
    }

    /**
     * Return a logo URL for provided type used by frontend Logo component
     */
    public function logo(string $type): JsonResponse
    {
        $map = [
            'light' => 'logo_light',
            'dark' => 'logo_light', // Use same logo for consistency
            'admin' => 'logo_light', // Use same logo for consistency  
            'mobile' => 'logo_light', // Use same logo for consistency
            'footer' => 'logo_light', // Use same logo for consistency
            'email' => 'logo_light', // Use same logo for consistency
            'seeklogo' => 'logo_light',
            'default' => 'logo_light',
        ];

        $key = $map[$type] ?? 'logo_light';
        $url = SettingsHelper::get($key);

        // Fallback: try theme-aware logo
        if (!$url) {
            $url = SettingsHelper::getLogo();
        }

        return response()->json([
            'success' => (bool) $url,
            'url' => $url,
        ]);
    }
}
