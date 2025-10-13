<?php

use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\WebAssetsController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\Api\HeroSectionController;
use App\Http\Controllers\API\HeroSliderController;
use App\Http\Controllers\Api\AssociateController;
use App\Http\Controllers\Api\ImageUploadController;
use App\Http\Controllers\API\DistributionServiceController;
use App\Http\Controllers\API\GlobalImpactController;
use App\Http\Controllers\API\FilmCategoryController;
use App\Http\Controllers\API\FilmPortfolioController;
use App\Http\Controllers\API\TestimonialController;
use App\Http\Controllers\Api\MissionVisionController;
use App\Http\Controllers\Api\CoreValueController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TrustedPartnerController;
use App\Http\Controllers\Api\PartnershipBenefitController;
use App\Http\Controllers\Api\TeamMemberController;
use App\Http\Controllers\Api\TeamValueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Team API routes
Route::apiResource('teams', TeamController::class);

// Additional team routes
Route::get('teams-active', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Team::active()->ordered()->get(),
        'message' => 'Active teams retrieved successfully'
    ]);
});

// Hero Slider API routes
Route::get('hero-sliders', [HeroSliderController::class, 'index']);

// Settings API routes
Route::prefix('settings')->group(function () {
    Route::get('/', [SettingsController::class, 'index']);
    Route::get('/flat', [SettingsController::class, 'flat']);
    Route::get('/theme', [SettingsController::class, 'theme']);
    Route::get('/group/{group}', [SettingsController::class, 'getByGroup']);
    Route::get('/{key}', [SettingsController::class, 'show']);
});

// Web assets (footer, logo) routes for frontend
Route::get('/footer', [WebAssetsController::class, 'footer']);
Route::get('/settings/footer', [WebAssetsController::class, 'footer']);
Route::get('/logo/{type}', [WebAssetsController::class, 'logo']);

// Pages API routes
Route::prefix('pages')->group(function () {
    Route::get('/', [PageController::class, 'index']);
    Route::get('/slug/{slug}', [PageController::class, 'getBySlug']);
    Route::get('/{slug}', [PageController::class, 'show']);
});

// Dynamic Pages API
Route::get('/dynamic-page/{slug}', function($slug) {
    $page = \App\Helpers\ContentManager::getDynamicPage($slug);
    if (!$page) {
        return response()->json(['error' => 'Page not found'], 404);
    }
    return response()->json($page);
});

Route::get('/homepage', function() {
    $page = \App\Helpers\ContentManager::getHomepage();
    if (!$page) {
        return response()->json(['error' => 'Homepage not found'], 404);
    }
    return response()->json($page);
});

Route::get('/content-blocks', function() {
    return response()->json(\App\Helpers\ContentManager::getAllContentBlocks());
});

// Hero Sections API
Route::get('/hero-sections', [HeroSectionController::class, 'index']);
Route::get('/hero-sections/page/{page}', [HeroSectionController::class, 'getByPage']);

// Associates API
Route::get('/associates', [AssociateController::class, 'index']);
Route::get('/associates/type/{type}', [AssociateController::class, 'getByType']);

// Distribution Services API
Route::get('/distribution-services', [DistributionServiceController::class, 'index']);
Route::get('/distribution-services/{distributionService}', [DistributionServiceController::class, 'show']);

// Global Impact API
Route::get('/global-impact', [GlobalImpactController::class, 'index']);

// Film Categories API
Route::get('/film-categories', [FilmCategoryController::class, 'index']);
Route::get('/film-categories/{filmCategory}', [FilmCategoryController::class, 'show']);

// Film Portfolios API
Route::get('/film-portfolios', [FilmPortfolioController::class, 'index']);
Route::get('/film-portfolios/featured', [FilmPortfolioController::class, 'featured']);
Route::get('/film-portfolios/category/{filmCategory}', [FilmPortfolioController::class, 'byCategory']);
Route::get('/film-portfolios/{filmPortfolio}', [FilmPortfolioController::class, 'show']);

// Testimonials API
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/testimonials/featured', [TestimonialController::class, 'featured']);
Route::get('/testimonials/{testimonial}', [TestimonialController::class, 'show']);

// Mission & Vision API
Route::get('/mission-vision', [MissionVisionController::class, 'index']);

// Core Values API
Route::get('/core-values', [CoreValueController::class, 'index']);

// Services API
Route::get('/services', [ServiceController::class, 'index']);

// Trusted Partners API
Route::get('/trusted-partners', [TrustedPartnerController::class, 'index']);

// Partnership Benefits API
Route::get('/partnership-benefits', [PartnershipBenefitController::class, 'index']);

// Team Members API
Route::get('/team-members', [TeamMemberController::class, 'index']);

// Team Values API
Route::get('/team-values', [TeamValueController::class, 'index']);

// News API
Route::get('/news', [\App\Http\Controllers\API\NewsController::class, 'index']);
Route::get('/news/featured', [\App\Http\Controllers\API\NewsController::class, 'featured']);
Route::get('/news/latest', [\App\Http\Controllers\API\NewsController::class, 'latest']);
Route::get('/news/{slug}', [\App\Http\Controllers\API\NewsController::class, 'show']);


// Image Upload API - Admin only (Legacy - now using Livewire file uploads)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/upload/associate-image', [ImageUploadController::class, 'uploadAssociateImage']);
    Route::delete('/upload/delete-image', [ImageUploadController::class, 'deleteImage']);
});
