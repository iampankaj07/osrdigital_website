<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ImageController;


Route::get('/', function () {
    return view('app'); // This should load your React app
});

// File upload routes for FilePond
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/film-portfolios/upload', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadFilmImage'])->name('admin.film-portfolios.upload');
    Route::post('/admin/testimonials/upload', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadTestimonialAvatar'])->name('admin.testimonials.upload');
    Route::post('/upload/general-logo', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadGeneralLogo']);
    Route::post('/upload/general-favicon', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadGeneralFavicon']);
    Route::post('/upload/associate-image', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadAssociateImage']);
    Route::post('/upload/associate-image-cloud', [App\Http\Controllers\Admin\CloudFileUploadController::class, 'uploadAssociateImage']);
    Route::get('/debug/cloud-storage', [App\Http\Controllers\Admin\CloudDebugController::class, 'debugStorage']);
    Route::post('/upload/partner-logo', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadPartnerLogo']);
    Route::post('/upload/team-member-avatar', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadTeamMemberAvatar']);
    Route::post('/upload/film-portfolio-image', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadFilmPortfolioImage']);
    Route::post('/upload/testimonial-image', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadTestimonialImage']);
    Route::post('/upload/news-featured-image', [App\Http\Controllers\Admin\FileUploadController::class, 'uploadNewsFeaturedImage']);
});


// Theme Settings Test Route (for development)
Route::get('/theme-test', function () {
    return view('theme-test');
});

// News Routes - if you want React to handle these, remove these routes
Route::get('/news', function () {
    return view('app'); // Let React handle this route
});

// Image serving routes
Route::get('/images/{path}', [ImageController::class, 'serve'])->where('path', '.*');
Route::get('/images/optimized/{width}x{height}/{path}', [ImageController::class, 'optimized'])->where('path', '.*');
Route::get('/placeholder/{width}x{height}', [ImageController::class, 'placeholder'])->where(['width' => '[0-9]+', 'height' => '[0-9]+']);
Route::get('/api/images/{path}/info', [ImageController::class, 'info'])->where('path', '.*');

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

// API Routes for React - Unified Content Management
use App\Http\Controllers\API\ContentController;

Route::prefix('api')->group(function () {
    
    // Unified content API - get all content in one call
    Route::get('/content', [ContentController::class, 'getAllContent']);
    
    // Individual content endpoints
    Route::get('/pages/{slug}', [ContentController::class, 'getPage']);
    Route::get('/settings/{key}', [ContentController::class, 'getSetting']);
    Route::get('/settings', [ContentController::class, 'getAllSettings']);
    
    // Legacy endpoints for backward compatibility
    Route::get('/featured-content', function () {
        $content = \App\Helpers\ContentManager::getAllContent();
        return response()->json($content['portfolio']['featured']);
    });

    Route::get('/stats', function () {
        $content = \App\Helpers\ContentManager::getAllContent();
        return response()->json($content['stats']);
    });

    Route::get('/portfolio', function () {
        $content = \App\Helpers\ContentManager::getAllContent();
        return response()->json($content['portfolio']['all']);
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
            'image' => $portfolio->image_url,
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

    Route::get('/partners', function () {
        $content = \App\Helpers\ContentManager::getAllContent();
        return response()->json($content['partners']);
    });

    Route::get('/team', function () {
        $content = \App\Helpers\ContentManager::getAllContent();
        return response()->json($content['team']);
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


    // Contact form submission
    Route::post('/contact', function (Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:general,partnership,content,support,media'
        ]);

        try {
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
        $logoUrl = \App\Helpers\ContentManager::getLogoUrl($type);
        return response()->json([
            'url' => $logoUrl,
            'type' => $type,
            'filename' => basename($logoUrl)
        ]);
    });
});

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Admin routes
require __DIR__.'/admin.php';

// Catch-all route for React SPA (place this at the end)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
