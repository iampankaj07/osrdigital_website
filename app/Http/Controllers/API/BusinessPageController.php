<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BusinessPage;
use Illuminate\Http\Request;

class BusinessPageController extends Controller
{
    /**
     * Get the active business page data
     */
    public function index()
    {
        try {
            $businessPage = BusinessPage::getActiveData();

            if (!$businessPage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business page not found',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $businessPage->id,
                    'title' => $businessPage->title,
                    'subtitle' => $businessPage->subtitle,
                    'description' => $businessPage->description,
                    'meta_title' => $businessPage->meta_title,
                    'meta_description' => $businessPage->meta_description,
                    'hero_image' => $businessPage->hero_image,
                    'hero_video' => $businessPage->hero_video,
                    'content_sections' => $businessPage->getFormattedContentSections(),
                    'features' => $businessPage->getFormattedFeatures(),
                    'statistics' => $businessPage->getFormattedStatistics(),
                    'call_to_action' => $businessPage->call_to_action,
                    'updated_at' => $businessPage->updated_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching business page data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific business page by ID
     */
    public function show($id)
    {
        try {
            $businessPage = BusinessPage::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $businessPage->id,
                    'title' => $businessPage->title,
                    'subtitle' => $businessPage->subtitle,
                    'description' => $businessPage->description,
                    'meta_title' => $businessPage->meta_title,
                    'meta_description' => $businessPage->meta_description,
                    'hero_image' => $businessPage->hero_image,
                    'hero_video' => $businessPage->hero_video,
                    'content_sections' => $businessPage->getFormattedContentSections(),
                    'features' => $businessPage->getFormattedFeatures(),
                    'statistics' => $businessPage->getFormattedStatistics(),
                    'call_to_action' => $businessPage->call_to_action,
                    'is_active' => $businessPage->is_active,
                    'sort_order' => $businessPage->sort_order,
                    'created_at' => $businessPage->created_at,
                    'updated_at' => $businessPage->updated_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Business page not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
