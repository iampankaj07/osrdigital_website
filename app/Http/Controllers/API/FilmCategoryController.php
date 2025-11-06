<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FilmCategory;
use Illuminate\Http\Request;

class FilmCategoryController extends Controller
{
    /**
     * Get all active film categories
     */
    public function index()
    {
        $categories = FilmCategory::getActiveCategories();
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get a specific film category
     */
    public function show(FilmCategory $filmCategory)
    {
        if (!$filmCategory->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $filmCategory
        ]);
    }
}
