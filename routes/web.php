<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

// API Routes for React (add these as you develop features)
Route::prefix('api')->group(function () {
    Route::get('/featured-content', function () {
        return response()->json(\App\Models\Portfolio::published()->featured()->limit(6)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'slug' => $item->slug,
                'title' => $item->title,
                'type' => ucfirst($item->type),
                'views' => number_format($item->views) . ' views',
                'image' => $item->image_url,
                'category' => $item->category,
                'description' => $item->description
            ];
        }));
    });

    Route::get('/stats', function () {
        return response()->json([
            ['number' => '500+', 'label' => 'Movies Published', 'icon' => '🎬'],
            ['number' => '2,000+', 'label' => 'Songs Released', 'icon' => '🎵'],
            ['number' => '800+', 'label' => 'Short Films', 'icon' => '🎥'],
            ['number' => '50M+', 'label' => 'Total Views', 'icon' => '👁️']
        ]);
    });

    // Portfolio API
    Route::get('/portfolio', function () {
        return response()->json(\App\Models\Portfolio::published()->orderBy('created_at', 'desc')->get()->map(function($item) {
            return [
                'id' => $item->id,
                'slug' => $item->slug,
                'title' => $item->title,
                'description' => strip_tags($item->description),
                'type' => $item->type,
                'category' => $item->category,
                'views' => $item->views,
                'image' => $item->image_url ?: 'https://images.pexels.com/photos/7991579/pexels-photo-7991579.jpeg?auto=compress&cs=tinysrgb&w=800',
                'is_featured' => $item->is_featured,
                'created_at' => $item->created_at,
            ];
        }));
    });

    Route::get('/portfolio/{slug}', function ($slug) {
        $portfolio = \App\Models\Portfolio::where('slug', $slug)->where('is_published', true)->first();

        if (!$portfolio) {
            return response()->json(['error' => 'Portfolio item not found'], 404);
        }

        // Increment view count
        $portfolio->increment('views');

        return response()->json([
            'id' => $portfolio->id,
            'title' => $portfolio->title,
            'slug' => $portfolio->slug,
            'description' => $portfolio->description,
            'content' => $portfolio->content,
            'image' => $portfolio->image_url ?: 'https://images.pexels.com/photos/7991579/pexels-photo-7991579.jpeg?auto=compress&cs=tinysrgb&w=800',
            'video_url' => $portfolio->video_url,
            'type' => $portfolio->type,
            'category' => $portfolio->category,
            'views' => $portfolio->views,
            'is_featured' => $portfolio->is_featured,
            'meta_title' => $portfolio->meta_title,
            'meta_description' => $portfolio->meta_description,
            'created_at' => $portfolio->created_at,
            'updated_at' => $portfolio->updated_at,
        ]);
    });

    // Partners API
    Route::get('/partners', function () {
        return response()->json(\App\Models\Partner::active()->get());
    });
  // Teams API
    Route::get('/teams', function () {
        return response()->json(\App\Models\Teams::active()->get());
    });

    // News API
    Route::get('/news', function () {
        return response()->json(\App\Models\News::published()->recent()->get());
    });

    // Contact form submission
    Route::post('/contact', function (Illuminate\Http\Request $request) {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:general,partnership,content,support,media'
        ]);

        // Save to database
        \App\Models\Contact::create($validated);

        return response()->json([
            'message' => 'Thank you for your message! We will get back to you within 24 hours.',
            'status' => 'success'
        ]);
    });    // Pages API (for dynamic content)
    Route::get('/pages', function () {
        return response()->json(\App\Models\Page::published()->get());
    });

    Route::get('/pages/{slug}', function ($slug) {
        $page = \App\Models\Page::where('slug', $slug)->where('is_published', true)->first();

        if (!$page) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        return response()->json($page);
    });
});
