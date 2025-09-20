<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;


Route::get('/', function () {
    return view('app'); // This should load your React app
});

// Theme Settings Test Route (for development)
Route::get('/theme-test', function () {
    return view('theme-test');
});

// News Routes - if you want React to handle these, remove these routes
Route::get('/news', function () {
    return view('app'); // Let React handle this route
});

Route::get('/news/{slug}', function ($slug) {
    // If you want Laravel to handle individual news items, keep this
    // Otherwise, let React handle it and remove this route
    $news = \App\Models\News::where('slug', $slug)
        ->where('status', 'published')
        ->where('published_at', '<=', now())
        ->firstOrFail();

    // Optionally increment view count
    $news->increment('views');

    return view('news.show', compact('news'));
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
                'image' => $item->image_url, // This will use the accessor we created
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
                'image' => $item->image_url, // This will use the accessor we created
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
            'image' => $portfolio->image_url, // This will use the accessor we created
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
    Route::get('/team', function () {
        return response()->json(\App\Models\Team::active()->ordered()->get()->map(function($team) {
            return [
                'id' => $team->id,
                'name' => $team->name,
                'slug' => $team->slug,
                'position' => $team->position,
                'description' => $team->description,
                'email' => $team->email,
                'phone' => $team->phone,
                'image' => $team->image_url,
                'social_links' => $team->social_links,
                'sort_order' => $team->sort_order,
            ];
        }));
    });

    Route::get('/team/{slug}', function ($slug) {
        $team = \App\Models\Team::where('slug', $slug)->where('is_active', true)->first();
        if (!$team) {
            return response()->json(['error' => 'Team member not found'], 404);
        }

        return response()->json([
            'id' => $team->id,
            'name' => $team->name,
            'slug' => $team->slug,
            'position' => $team->position,
            'description' => $team->description,
            'email' => $team->email,
            'phone' => $team->phone,
            'image' => $team->image_url,
            'social_links' => $team->social_links,
            'sort_order' => $team->sort_order,
        ]);
    });

    // News API
    Route::get('/news', function () {
        return response()->json(\App\Models\News::published()->recent()->get());
    });

    // Single News Post API
    Route::get('/news/{slug}', function ($slug) {
        $news = \App\Models\News::where('slug', $slug)->where('status', 'published')->where('published_at', '<=', now())->first();
        if (!$news) {
            return response()->json(['error' => 'News post not found'], 404);
        }
        // Optionally increment view count
        $news->increment('views');
        return response()->json($news);
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

        try {
            // Send email directly using Laravel Mail
            \Illuminate\Support\Facades\Mail::to(config('mail.from.address'))
                ->send(new \App\Mail\ContactFormSubmission($validated));

            return response()->json([
                'message' => 'Thank you for your message! We will get back to you within 24 hours.',
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Contact form submission failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Sorry, there was an error sending your message. Please try again later.',
                'status' => 'error'
            ], 500);
        }
    });

    // Logo API
    Route::get('/logo/{type?}', function ($type = 'default') {
        // Always use static logo for cloud deployment reliability
        if (file_exists(public_path('images/logo.png'))) {
            $url = asset('images/logo.png');
            $filename = 'logo.png';
        } else {
            // Fallback to database settings if static file doesn't exist
            $settingKeyMap = [
                'default' => 'site_logo',
                'seeklogo' => 'site_logo',
                'main' => 'site_logo',
                'dark' => 'logo_dark',
                'mobile' => 'logo_mobile',
                'admin' => 'logo_admin',
                'light' => 'logo_light',
                'footer' => 'logo_footer',
                'email' => 'logo_email'
            ];

            $settingKey = $settingKeyMap[$type] ?? 'site_logo';
            $logoPath = \App\Helpers\SettingsHelper::get($settingKey);

            if ($logoPath) {
                $url = \Illuminate\Support\Facades\Storage::url($logoPath);
                $filename = basename($logoPath);
            } else {
                // Fallback to default logo
                $fallbackFile = 'osrdigital-seeklogo.svg';
                $url = \Illuminate\Support\Facades\Storage::url('logos/' . $fallbackFile);
                $filename = $fallbackFile;
            }
        }

        return response()->json([
            'url' => $url,
            'type' => $type,
            'filename' => $filename
        ]);
    });

    // Pages API (for dynamic content)
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

    // Settings API
    Route::get('/settings/flat', function () {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        return response()->json($settings);
    });
});

// Catch-all route for React SPA (place this at the end)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
