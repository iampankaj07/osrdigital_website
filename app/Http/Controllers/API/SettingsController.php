<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ThemeHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Get all public settings for frontend consumption organized by groups
     */
    public function index(): JsonResponse
    {
        try {
            $allSettings = ThemeHelper::allForFrontend();

            // Organize by logical groups
            $settings = [
                'application' => [
                    'site_name' => $allSettings['site_name'] ?? null,
                    'site_description' => $allSettings['site_description'] ?? null,
                    'theme_color' => $allSettings['theme_color'] ?? null,
                ],
                'branding' => [
                    'site_logo' => $allSettings['site_logo'] ?? null,
                    'site_favicon' => $allSettings['site_favicon'] ?? null,
                ],
                'contact' => [
                    'support_email' => $allSettings['support_email'] ?? null,
                    'support_phone' => $allSettings['support_phone'] ?? null,
                ],
                'social' => $allSettings['social_network'] ?? [],
                'seo' => [
                    'seo_title' => $allSettings['seo_title'] ?? null,
                    'seo_keywords' => $allSettings['seo_keywords'] ?? null,
                ],
                'custom' => $this->getCustomSettings($allSettings),
            ];

            return response()->json([
                'success' => true,
                'data' => $settings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch settings',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get settings by specific group
     */
    public function getByGroup(string $group): JsonResponse
    {
        try {
            $settings = match ($group) {
                'application', 'app' => [
                    'site_name' => ThemeHelper::company()['name'],
                    'site_description' => ThemeHelper::company()['tagline'],
                    'theme_color' => ThemeHelper::colors()['primary'],
                ],
                'branding' => [
                    'site_logo' => ThemeHelper::logo(),
                    'site_favicon' => ThemeHelper::favicon(),
                ],
                'contact' => [
                    'support_email' => ThemeHelper::company()['email'],
                    'support_phone' => ThemeHelper::company()['phone'],
                ],
                'social' => ThemeHelper::social(),
                'seo' => ThemeHelper::seo(),
                'analytics' => ThemeHelper::analytics(),
                'header' => ThemeHelper::header(),
                'footer' => ThemeHelper::footer(),
                default => []
            };

            return response()->json([
                'success' => true,
                'data' => $settings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Failed to fetch {$group} settings",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a specific setting by key
     */
    public function show(string $key): JsonResponse
    {
        try {
            $value = ThemeHelper::get($key);

            if ($value === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Setting not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'key' => $key,
                    'value' => $value,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch setting',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get flattened settings for easier frontend consumption
     */
    public function flat(): JsonResponse
    {
        try {
            $settings = ThemeHelper::allForFrontend();

            return response()->json([
                'success' => true,
                'data' => $settings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch settings',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get comprehensive theme data for frontend
     */
    public function theme(): JsonResponse
    {
        try {
            $settings = [
                'company' => ThemeHelper::company(),
                'colors' => ThemeHelper::colors(),
                'social' => ThemeHelper::social(),
                'header' => ThemeHelper::header(),
                'footer' => ThemeHelper::footer(),
                'seo' => ThemeHelper::seo(),
                'analytics' => ThemeHelper::analytics(),
                'branding' => [
                    'logo' => ThemeHelper::logo(),
                    'favicon' => ThemeHelper::favicon(),
                ],
                'features' => [
                    'dark_mode_enabled' => ThemeHelper::isDarkModeEnabled(),
                ],
            ];

            return response()->json([
                'success' => true,
                'data' => $settings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch theme settings',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Extract custom settings from more_configs
     */
    private function getCustomSettings(array $allSettings): array
    {
        $coreKeys = [
            'site_name', 'site_description', 'theme_color', 'support_email',
            'support_phone', 'site_logo', 'site_favicon', 'social_network',
            'seo_title', 'seo_keywords'
        ];

        $customSettings = [];
        foreach ($allSettings as $key => $value) {
            if (!in_array($key, $coreKeys)) {
                $customSettings[$key] = $value;
            }
        }

        return $customSettings;
    }
}
