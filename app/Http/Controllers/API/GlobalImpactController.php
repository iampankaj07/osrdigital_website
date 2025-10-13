<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdminSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GlobalImpactController extends Controller
{
    /**
     * Get Global Impact settings for frontend
     */
    public function index()
    {
        $data = Cache::remember('global_impact_settings', 3600, function () {
            $settings = AdminSettings::getGroup('global_impact');

            // Default values if settings don't exist
            $defaults = [
                'title' => 'Our Global Impact',
                'subtitle' => 'Numbers that speak to our commitment to bringing quality content to global audiences',
                'stats' => [
                    ['number' => '500+', 'label' => 'Movies Published', 'icon' => 'fas fa-film'],
                    ['number' => '2,000+', 'label' => 'Songs Released', 'icon' => 'fas fa-music'],
                    ['number' => '800+', 'label' => 'Short Films', 'icon' => 'fas fa-video'],
                    ['number' => '50M+', 'label' => 'Total Views', 'icon' => 'fas fa-eye']
                ]
            ];

            // Map the specific keys from admin settings
            $result = [
                'title' => $settings['global_impact_title'] ?? $defaults['title'],
                'subtitle' => $settings['global_impact_subtitle'] ?? $defaults['subtitle'],
                'stats' => $settings['global_impact_stats'] ?? $defaults['stats']
            ];

            return $result;
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
