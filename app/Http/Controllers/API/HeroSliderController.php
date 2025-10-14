<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;

class HeroSliderController extends Controller
{
    /**
     * Get all active hero sliders
     */
    public function index()
    {
        try {
            $sliders = HeroSlider::where('is_active', true)
                ->with(['mediaRecord', 'media']) // Load both relationships
                ->orderBy('sort_order', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $sliders
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch hero sliders',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
