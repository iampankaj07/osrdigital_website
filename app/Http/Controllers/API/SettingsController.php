<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    /**
     * Get all public settings for frontend consumption
     */
    public function index(): JsonResponse
    {
        try {
            $settings = Setting::where('is_public', true)
                ->get()
                ->groupBy('group')
                ->map(function ($groupSettings) {
                    return $groupSettings->mapWithKeys(function ($setting) {
                        $value = $this->processSettingValue($setting);
                        return [$setting->key => $value];
                    });
                });

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
            $settings = Setting::where('is_public', true)
                ->where('group', $group)
                ->get()
                ->mapWithKeys(function ($setting) {
                    $value = $this->processSettingValue($setting);
                    return [$setting->key => $value];
                });

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
            $setting = Setting::where('key', $key)
                ->where('is_public', true)
                ->first();

            if (!$setting) {
                return response()->json([
                    'success' => false,
                    'message' => 'Setting not found or not public',
                ], 404);
            }

            $value = $this->processSettingValue($setting);

            return response()->json([
                'success' => true,
                'data' => [
                    'key' => $setting->key,
                    'value' => $value,
                    'type' => $setting->type,
                    'group' => $setting->group,
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
            $settings = Setting::where('is_public', true)
                ->get()
                ->mapWithKeys(function ($setting) {
                    $value = $this->processSettingValue($setting);
                    return [$setting->key => $value];
                });

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
     * Process setting value based on its type
     */
    private function processSettingValue(Setting $setting)
    {
        return match ($setting->type) {
            'boolean' => (bool) $setting->value,
            'integer' => (int) $setting->value,
            'float' => (float) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }
}
