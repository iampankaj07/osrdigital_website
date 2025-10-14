<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssociateController;
use App\Http\Controllers\Admin\CoreValueController;
use App\Http\Controllers\Admin\DistributionServiceController;
use App\Http\Controllers\Admin\FilmCategoryController;
use App\Http\Controllers\Admin\FilmPortfolioController;
use App\Http\Controllers\Admin\GlobalImpactController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\MissionVisionController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PartnershipBenefitController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TeamValueController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TrustedPartnerController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Hero Slider Management
    Route::resource('/hero-slider', HeroSliderController::class)->names('hero-slider');

    // Associates Management
    Route::get('/associates', [AssociateController::class, 'index'])->name('associates.index');

    // Testimonials Management
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    // Core Values Management (Livewire)
    Route::get('/core-values', [CoreValueController::class, 'index'])->name('core-values.index');

    // Services Management (Livewire)
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

    // Business Pages Management (Livewire)
    Route::get('/business-pages', [\App\Http\Controllers\Admin\BusinessPageController::class, 'index'])->name('business-pages.index');

    // Distribution Services Management (Livewire)
    Route::get('/distribution-services', [DistributionServiceController::class, 'index'])->name('distribution-services.index');

    // Trusted Partners Management (Livewire)
    Route::get('/trusted-partners', [TrustedPartnerController::class, 'index'])->name('trusted-partners.index');

    // Partnership Benefits Management (Livewire)
    Route::get('/partnership-benefits', [PartnershipBenefitController::class, 'index'])->name('partnership-benefits.index');

    // Team Members Management (Livewire)
    Route::get('/team-members', [TeamMemberController::class, 'index'])->name('team-members.index');

    // Team Values Management (Livewire)
    Route::get('/team-values', [TeamValueController::class, 'index'])->name('team-values.index');

    // Film Portfolios Management (Livewire)
    Route::get('/film-portfolios', [FilmPortfolioController::class, 'index'])->name('film-portfolios.index');

    // Film Categories Management (Livewire)
    Route::get('/film-categories', [FilmCategoryController::class, 'index'])->name('film-categories.index');

    // Settings Management
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    // Footer Settings Management (Livewire)
    Route::get('/footer', function() {
        return view('admin.footer.index-livewire');
    })->name('footer.index');





    // News Management
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');

    // News Categories Management
    Route::get('/news-categories', [NewsCategoryController::class, 'index'])->name('news-categories.index');

    // User Roles Management
    Route::get('/user-roles', [UserRoleController::class, 'index'])->name('user-roles.index');

    // Permissions Management
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Distribution Services Management
    Route::get('/global-impact', [GlobalImpactController::class, 'index'])->name('global-impact.index');

    Route::get('/mission-vision', [MissionVisionController::class, 'index'])->name('mission-vision.index');

    // Media Library (Livewire)
    Route::get('/media-library', function() {
        return view('admin.media-library.index');
    })->name('media-library.index');

    // Media Upload and API Routes
    Route::get('/media-library/api', [\App\Http\Controllers\Admin\MediaUploadController::class, 'api'])->name('media-library.api');
    Route::post('/media/upload', [\App\Http\Controllers\Admin\MediaUploadController::class, 'upload'])->name('media.upload');
    Route::delete('/media/revert', [\App\Http\Controllers\Admin\MediaUploadController::class, 'revert'])->name('media.revert');
    Route::get('/media/load/{id}', [\App\Http\Controllers\Admin\MediaUploadController::class, 'load'])->name('media.load');
    
    // Team Member Avatar Upload Route
    Route::post('/upload/team-member-avatar', [\App\Http\Controllers\Admin\MediaUploadController::class, 'upload'])->name('team-member-avatar.upload');
    
    // Trusted Partner Logo Upload Route
    Route::post('/upload/partner-logo', [\App\Http\Controllers\Admin\MediaUploadController::class, 'upload'])->name('partner-logo.upload');
    
    // News Featured Image Upload Route
    Route::post('/upload/news-featured-image', [\App\Http\Controllers\Admin\MediaUploadController::class, 'upload'])->name('news-featured-image.upload');
});
