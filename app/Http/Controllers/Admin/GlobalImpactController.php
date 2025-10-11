<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GlobalImpactController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display the Global Impact settings form
     */
    public function index()
    {
        $settings = AdminSettings::getGroup('global_impact');
        
        // Default values if settings don't exist
        $defaults = [
            'title' => 'Our Global Impact',
            'subtitle' => 'Numbers that speak to our commitment to bringing quality content to global audiences',
            'stats' => [
                ['number' => '500+', 'label' => 'Movies Published', 'icon' => '🎬'],
                ['number' => '2,000+', 'label' => 'Songs Released', 'icon' => '🎵'],
                ['number' => '800+', 'label' => 'Short Films', 'icon' => '🎥'],
                ['number' => '50M+', 'label' => 'Total Views', 'icon' => '👁️']
            ]
        ];

        $data = array_merge($defaults, $settings);
        
        return view('admin.global-impact.index', compact('data'));
    }

    /**
     * Update Global Impact settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'stats' => 'required|array|min:1|max:6',
            'stats.*.number' => 'required|string|max:50',
            'stats.*.label' => 'required|string|max:100',
        ]);

        // Update title and subtitle
        AdminSettings::set('global_impact_title', $request->title, 'string', 'global_impact', 'Global Impact section title', true);
        AdminSettings::set('global_impact_subtitle', $request->subtitle, 'string', 'global_impact', 'Global Impact section subtitle', true);
        
        // Update stats
        AdminSettings::set('global_impact_stats', $request->stats, 'json', 'global_impact', 'Global Impact statistics', true);

        // Clear cache
        Cache::forget('global_impact_settings');
        Cache::forget('public_settings');

        return redirect()->route('admin.global-impact.index')
            ->with('success', 'Global Impact settings updated successfully!');
    }
}
