<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FilmPortfolio;
use App\Models\FilmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FilmPortfolioController extends Controller
{
    /**
     * Get all published film portfolios
     */
    public function index(Request $request)
    {
        $cacheKey = 'film_portfolios_' . md5(serialize($request->all()));
        
        return Cache::remember($cacheKey, 300, function () use ($request) {
            $query = FilmPortfolio::with('category')->published()->ordered();

            // Filter by category if provided
            if ($request->has('category') && $request->category !== 'all') {
                $query->byCategory($request->category);
            }

            // Filter by featured if provided
            if ($request->has('featured') && $request->boolean('featured')) {
                $query->featured();
            }

            $limit = $request->get('limit', 12);
            $films = $query->limit($limit)->get();

            // Transform data to include image_url for frontend compatibility
            $transformedFilms = $films->map(function ($film) {
                return [
                    'id' => $film->id,
                    'title' => $film->title,
                    'slug' => $film->slug,
                    'description' => $film->description,
                    'genre' => $film->genre,
                    'year' => $film->year,
                    'image_url' => $film->image_url,
                    'video_url' => $film->video_url,
                    'link' => $film->link,
                    'rating' => $film->rating,
                    'duration' => $film->duration,
                    'category' => $film->category,
                    'category_id' => $film->category_id,
                    'is_featured' => $film->is_featured,
                    'is_published' => $film->is_published,
                    'views' => $film->views ?? 0,
                    'created_at' => $film->created_at,
                    'updated_at' => $film->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedFilms
            ]);
        });
    }

    /**
     * Get featured film portfolios
     */
    public function featured(Request $request)
    {
        $limit = $request->get('limit', 6);
        $films = FilmPortfolio::getFeaturedFilms($limit);

        return response()->json([
            'success' => true,
            'data' => $films
        ]);
    }

    /**
     * Get films by category
     */
    public function byCategory(FilmCategory $filmCategory, Request $request)
    {
        if (!$filmCategory->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $limit = $request->get('limit', 12);
        $films = FilmPortfolio::getFilmsByCategory($filmCategory->id, $limit);

        return response()->json([
            'success' => true,
            'data' => $films
        ]);
    }

    /**
     * Get a specific film portfolio
     */
    public function show(FilmPortfolio $filmPortfolio)
    {
        if (!$filmPortfolio->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Film not found'
            ], 404);
        }

        $filmPortfolio->load('category');

        return response()->json([
            'success' => true,
            'data' => $filmPortfolio
        ]);
    }
}
