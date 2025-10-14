<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Get all published news articles
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'media'])->published()->recent();

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            if (is_numeric($request->category)) {
                $query->where('category_id', $request->category);
            } else {
                $query->whereHas('category', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }
        }

        // Get featured articles
        if ($request->has('featured') && $request->featured) {
            $query->where('featured', true);
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $news = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $news->items(),
            'pagination' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total(),
            ]
        ]);
    }

    /**
     * Get a single news article
     */
    public function show($slug)
    {
        $news = News::with(['category', 'media'])->published()->where('slug', $slug)->first();

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News article not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Get featured articles
     */
    public function featured()
    {
        $featured = News::with(['category', 'media'])
            ->published()
            ->where('featured', true)
            ->recent()
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $featured
        ]);
    }

    /**
     * Get latest news
     */
    public function latest()
    {
        $latest = News::with(['category', 'media'])
            ->published()
            ->recent()
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $latest
        ]);
    }
}
