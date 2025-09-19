<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of published pages.
     */
    public function index()
    {
        try {
            $pages = Page::published()
                ->select(['id', 'title', 'slug', 'excerpt', 'featured_image', 'created_at'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $pages,
                'message' => 'Pages retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve pages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified page by slug.
     */
    public function show($slug)
    {
        try {
            $page = Page::where('slug', $slug)
                ->published()
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $page,
                'message' => 'Page retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get page content by slug for frontend
     */
    public function getBySlug($slug)
    {
        try {
            $page = Page::where('slug', $slug)
                ->published()
                ->first();

            if (!$page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'title' => $page->title,
                    'content' => $page->content,
                    'excerpt' => $page->excerpt,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                    'featured_image' => $page->featured_image,
                    'slug' => $page->slug,
                    'created_at' => $page->created_at,
                    'updated_at' => $page->updated_at,
                ],
                'message' => 'Page content retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve page content',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
