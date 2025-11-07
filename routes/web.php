<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ImageController;


Route::get('/', function () {
    return view('app'); // This should load your React app
});

// Storage serving route (for shared hosting without symlinks)
// This route serves files from storage/app/public when symlinks are not available
Route::get('/storage/{path}', [App\Http\Controllers\StorageController::class, 'serve'])
    ->where('path', '.*')
    ->name('storage.serve');

// Livewire minified asset route (serves static published assets)
// This handles requests to /livewire/livewire.min.js with or without query parameters
// MUST be before catch-all route to ensure it's matched
Route::get('/livewire/livewire.min.js', function () {
    // Try multiple possible locations
    $possiblePaths = [
        public_path('vendor/livewire/livewire.min.js'),
        public_path('livewire/livewire.min.js'),
        base_path('public/vendor/livewire/livewire.min.js'),
    ];

    $filePath = null;
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            $filePath = $path;
            break;
        }
    }

    if (!$filePath || !file_exists($filePath)) {
        // Log for debugging
        abort(404, 'Livewire minified file not found');
    }

    $content = file_get_contents($filePath);
    if ($content === false) {
        abort(500, 'Failed to read Livewire file');
    }

    return response($content, 200)
        ->header('Content-Type', 'application/javascript; charset=utf-8')
        ->header('Cache-Control', 'public, max-age=31536000');
})->name('livewire.min.js');

// Image serving routes - MUST be before catch-all route
Route::get('/images/{path}', [ImageController::class, 'serve'])->where('path', '.*');
Route::get('/images/optimized/{width}x{height}/{path}', [ImageController::class, 'optimized'])->where('path', '.*');
// Placeholder route removed - no longer generating placeholder images
Route::get('/api/images/{path}/info', [ImageController::class, 'info'])->where('path', '.*');

// Public image testing endpoints
Route::get('/public-debug/image-serving', [App\Http\Controllers\PublicImageTestController::class, 'testImageServing']);
Route::get('/public-test-image/{filename}', [App\Http\Controllers\PublicImageTestController::class, 'serveTestImage']);

// Simple debug endpoint for Laravel Cloud
Route::get('/debug-storage', function() {
    $associatesPath = storage_path('app/public/associates');
    $files = [];

    if (is_dir($associatesPath)) {
        $files = array_map(function($file) {
            return [
                'name' => basename($file),
                'path' => $file,
                'size' => filesize($file),
                'modified' => filemtime($file)
            ];
        }, glob($associatesPath . '/*'));
    }

    return response()->json([
        'associates_path' => $associatesPath,
        'exists' => is_dir($associatesPath),
        'files' => $files,
        'test_file' => '60fb5eec-00e1-4742-9eb2-ba5fb93c7ec3.png',
        'test_exists' => file_exists($associatesPath . '/60fb5eec-00e1-4742-9eb2-ba5fb93c7ec3.png')
    ]);
});

// Debug routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/debug/cloud-storage', [App\Http\Controllers\Admin\CloudDebugController::class, 'debugStorage']);
    Route::get('/debug/image-serving', [App\Http\Controllers\ImageTestController::class, 'testImageServing']);
    Route::get('/test-image/{filename}', [App\Http\Controllers\ImageTestController::class, 'serveTestImage']);
});




// News Routes - if you want React to handle these, remove these routes
Route::get('/news', function () {
    return view('app'); // Let React handle this route
});


Route::get('/news/{slug}', function ($slug) {
    // If you want Laravel to handle individual news items, keep this
    // Otherwise, let React handle it and remove this route
    $news = \App\Models\News::with(['category', 'media'])
        ->where('slug', $slug)
        ->where('status', 'published')
        ->where('published_at', '<=', now())
        ->firstOrFail();

    // Optionally increment view count
    $news->increment('views');

    return view('news.show', compact('news'));
});

// API Routes for React - Unified Content Management
use App\Http\Controllers\Api\ContentController;

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

    // Hero Slider API
    Route::get('/hero-slider', function () {
        $heroSliders = \App\Models\HeroSlider::active()->ordered()->get();
        return response()->json([
            'success' => true,
            'data' => $heroSliders->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'title' => $slider->title,
                    'subtitle' => $slider->subtitle,
                    'description' => $slider->description,
                    'image' => $slider->image ? asset('storage/' . $slider->image) : null,
                    'button_text' => $slider->button_text,
                    'button_url' => $slider->button_url,
                    'button_text_secondary' => $slider->button_text_secondary,
                    'button_url_secondary' => $slider->button_url_secondary,
                    'shouldShowButton' => $slider->shouldShowButton(),
                    'shouldShowSecondaryButton' => $slider->shouldShowSecondaryButton(),
                    'sort_order' => $slider->sort_order,
                ];
            })
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

// Team routes are handled by API routes (apiResource)

// Legal Pages routes
Route::get('/privacy-policy', [App\Http\Controllers\LegalPageController::class, 'privacyPolicy'])->name('legal.privacy-policy');
Route::get('/terms-of-service', [App\Http\Controllers\LegalPageController::class, 'termsOfService'])->name('legal.terms-of-service');
Route::get('/cookies-policy', [App\Http\Controllers\LegalPageController::class, 'cookiesPolicy'])->name('legal.cookies-policy');
Route::get('/legal/{slug}', [App\Http\Controllers\LegalPageController::class, 'show'])->name('legal.show');

// Catch-all route for React SPA (place this at the end)
// NOTE: This must come AFTER all other specific routes, but the web server should serve static assets
// The web server (public/.htaccess or nginx) should handle /build/* and /storage/* before this
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!build/|storage/|assets/|api/|admin/|debug|images|livewire|\.well-known).*$');
