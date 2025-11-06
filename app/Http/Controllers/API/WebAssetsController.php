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

        // Get social media from main Settings table (social media tab)
        $socialMediaSettings = $this->getSocialMediaFromSettings();

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
            'quick_links' => $this->formatQuickLinks($footer->quick_links ?? []),
            'services' => $this->formatServices($footer->services ?? []),
            'social_links' => $socialMediaSettings,
            'legal_links' => [
                ['text' => 'Privacy Policy', 'url' => '/privacy-policy', 'icon' => 'faShieldAlt'],
                ['text' => 'Terms of Service', 'url' => '/terms-of-service', 'icon' => 'faShieldAlt'],
                ['text' => 'Cookie Policy', 'url' => '/cookies-policy', 'icon' => 'faShieldAlt']
            ],
            'copyright_text' => $footer->copyright_text ?? '© 2025 OSR Digital. All rights reserved.'
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Get social media URLs from main Settings table
     */
    private function getSocialMediaFromSettings(): array
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');

        $socialLinks = [];

        $socialPlatforms = [
            'facebook' => 'facebook_url',
            'twitter' => 'twitter_url',
            'instagram' => 'instagram_url',
            'linkedin' => 'linkedin_url',
            'youtube' => 'youtube_url'
        ];

        foreach ($socialPlatforms as $platform => $settingKey) {
            $url = $settings->get($settingKey);
            if ($url) {
                $socialLinks[$platform] = [
                    'url' => $url,
                    'icon' => $this->getSocialIcon($platform)
                ];
            }
        }

        return $socialLinks;
    }

    /**
     * Format quick links for React component
     */
    private function formatQuickLinks($quickLinks): array
    {
        if (!is_array($quickLinks)) {
            return [];
        }

        return array_map(function($link) {
            return [
                'text' => $link['title'] ?? $link['text'] ?? '',
                'url' => $link['url'] ?? '',
                'icon' => $link['icon'] ?? 'faGlobe'
            ];
        }, $quickLinks);
    }

    /**
     * Format services for React component
     */
    private function formatServices($services): array
    {
        // If no services in footer settings, use defaults
        if (!is_array($services) || empty($services)) {
            return [
                ['text' => 'Digital Streaming', 'icon' => 'faPlay'],
                ['text' => 'Theatrical Release', 'icon' => 'faFilm'],
                ['text' => 'Global Distribution', 'icon' => 'faGlobeAmericas'],
                ['text' => 'Content Acquisition', 'icon' => 'faShoppingCart'],
                ['text' => 'Marketing Strategy', 'icon' => 'faChartLine'],
                ['text' => 'Rights Management', 'icon' => 'faShieldAlt']
            ];
        }

        return array_map(function($service) {
            return [
                'text' => $service['text'] ?? $service['name'] ?? '',
                'icon' => $service['icon'] ?? 'faCircle'
            ];
        }, $services);
    }

    /**
     * Format social links for React component (legacy method)
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

    /**
     * Return contact page configuration for frontend contact component
     */
    public function contactPage(): JsonResponse
    {
        // Transform data to match React component structure
        $data = [
            'hero' => [
                'title' => SettingsHelper::get('contact_hero_title', 'Contact Us'),
                'subtitle' => SettingsHelper::get('contact_hero_subtitle', 'Get in Touch'),
                'description' => SettingsHelper::get('contact_hero_description', 'We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.')
            ],
            'form' => [
                'title' => SettingsHelper::get('contact_form_title', 'Send us a Message'),
                'description' => SettingsHelper::get('contact_form_description', 'Fill out the form below and we\'ll get back to you within 24 hours.')
            ],
            'contact' => [
                'email' => SettingsHelper::get('contact_email', 'hello@osrdigital.com'),
                'phone' => SettingsHelper::get('contact_phone', '+1 (555) 123-4567'),
                'address' => SettingsHelper::get('contact_address', 'Los Angeles, CA')
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

}
