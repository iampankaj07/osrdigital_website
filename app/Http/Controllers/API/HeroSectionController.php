<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    /**
     * Get hero section by page
     */
    public function getByPage($page)
    {
        $heroSection = HeroSection::getByPage($page);
        
        if (!$heroSection) {
            return response()->json([
                'success' => false,
                'message' => 'Hero section not found for page: ' . $page
            ], 404);
        }

        // Add computed properties for frontend
        $heroSection->shouldShowButton = $heroSection->shouldShowButton();
        $heroSection->shouldShowSecondaryButton = $heroSection->shouldShowSecondaryButton();

        return response()->json([
            'success' => true,
            'data' => $heroSection
        ]);
    }

    /**
     * Get all hero sections
     */
    public function index()
    {
        $heroSections = HeroSection::where('is_active', true)
            ->orderBy('page')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $heroSections
        ]);
    }
}