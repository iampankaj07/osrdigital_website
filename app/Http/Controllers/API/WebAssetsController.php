<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SettingsHelper;
use App\Http\Controllers\Controller;
use App\Models\FooterSettings;
use Illuminate\Http\JsonResponse;

class WebAssetsController extends Controller
{
    /**
     * Return footer configuration for frontend footer component
     */
    public function footer(): JsonResponse
    {
        $footer = FooterSettings::getActive();

        // Transform data to match React component structure
        $data = [
            'company' => [
                'name' => $footer->company_name ?? 'OSR Digital',
                'description' => $footer->company_description ?? 'Premium movie distribution company'
            ],
            'contact' => [
                'email' => $footer->email ?? 'hello@osrdigital.com',
                'phone' => $footer->phone ?? '+1 (555) 123-4567',
                'address' => $footer->address ?? 'Los Angeles, CA'
            ],
            'quick_links' => $footer->quick_links ?? [],
            'services' => [
                ['text' => 'Digital Streaming', 'icon' => 'faPlay'],
                ['text' => 'Theatrical Release', 'icon' => 'faFilm'],
                ['text' => 'Global Distribution', 'icon' => 'faGlobeAmericas'],
                ['text' => 'Content Acquisition', 'icon' => 'faShoppingCart'],
                ['text' => 'Marketing Strategy', 'icon' => 'faChartLine'],
                ['text' => 'Rights Management', 'icon' => 'faShieldAlt']
            ],
            'social_links' => $this->formatSocialLinks($footer->social_links ?? []),
            'legal_links' => [
                ['text' => 'Privacy Policy', 'url' => '/privacy', 'icon' => 'faShieldAlt'],
                ['text' => 'Terms of Service', 'url' => '/terms', 'icon' => 'faShieldAlt'],
                ['text' => 'Cookie Policy', 'url' => '/cookies', 'icon' => 'faShieldAlt']
            ],
            'copyright_text' => $footer->copyright_text ?? '© 2025 OSR Digital. All rights reserved.'
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Format social links for React component
     */
    private function formatSocialLinks($socialLinks): array
    {
        $formatted = [];

        foreach ($socialLinks as $link) {
            if (is_array($link) && isset($link['platform']) && isset($link['url'])) {
                $formatted[$link['platform']] = [
                    'url' => $link['url'],
                    'icon' => $this->getSocialIcon($link['platform'])
                ];
            }
        }

        return $formatted;
    }

    /**
     * Get social media icon name
     */
    private function getSocialIcon($platform): string
    {
        $icons = [
            'facebook' => 'faFacebookBrand',
            'twitter' => 'faTwitterBrand',
            'linkedin' => 'faLinkedinBrand',
            'instagram' => 'faInstagramBrand',
            'youtube' => 'faYoutubeBrand',
            'tiktok' => 'faTiktokBrand'
        ];

        return $icons[$platform] ?? 'faCircle';
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
