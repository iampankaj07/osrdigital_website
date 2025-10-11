<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\AssociateController;
use App\Http\Controllers\Admin\DistributionServiceController;
use App\Http\Controllers\Admin\GlobalImpactController;
use App\Http\Controllers\Admin\FilmCategoryController;
use App\Http\Controllers\Admin\FilmPortfolioController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\MissionVisionController;
use App\Http\Controllers\Admin\CoreValueController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TrustedPartnerController;
use App\Http\Controllers\Admin\PartnershipBenefitController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TeamValueController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Settings Management
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/general/update', [SettingsController::class, 'updateGeneral'])->name('settings.general.update');
    Route::put('/settings/footer/update', [SettingsController::class, 'updateFooter'])->name('settings.footer.update');
    Route::put('/settings/contact/update', [SettingsController::class, 'updateContact'])->name('settings.contact.update');
    
    // News Management
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::patch('/news/{news}/toggle-featured', [\App\Http\Controllers\Admin\NewsController::class, 'toggleFeatured'])->name('news.toggle-featured');
    
    // News Categories Management
    Route::resource('news-categories', \App\Http\Controllers\Admin\NewsCategoryController::class);
    
    
    
    // Roles & Permissions Management
    Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles');
    
    // Role Management
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::put('/roles/{id}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{id}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
    Route::get('/roles/{id}', [RolePermissionController::class, 'getRole'])->name('roles.show');
    
    // Permission Management
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::put('/permissions/{id}', [RolePermissionController::class, 'updatePermission'])->name('permissions.update');
    Route::delete('/permissions/{id}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');
    Route::get('/permissions/{id}', [RolePermissionController::class, 'getPermission'])->name('permissions.show');
    
    // Role-Permission Assignment
    Route::post('/roles/{roleId}/permissions', [RolePermissionController::class, 'assignPermissionsToRole'])->name('roles.permissions.assign');
    
    // User-Role Assignment
    Route::post('/users/{userId}/roles', [RolePermissionController::class, 'assignRolesToUser'])->name('users.roles.assign');
    Route::post('/users/{userId}/permissions', [RolePermissionController::class, 'assignPermissionsToUser'])->name('users.permissions.assign');
    Route::get('/users/{id}', [RolePermissionController::class, 'getUser'])->name('users.show');
    Route::delete('/users/{id}', [RolePermissionController::class, 'destroyUser'])->name('users.destroy');
    
    // Additional endpoints for role/permission management
    Route::get('/permissions-all', [RolePermissionController::class, 'getAllPermissions'])->name('permissions.all');
    Route::get('/roles-all', [RolePermissionController::class, 'getAllRoles'])->name('roles.all');
    
    // Dynamic Pages Management
    Route::resource('dynamic-pages', \App\Http\Controllers\Admin\DynamicPageController::class);
    Route::get('/dynamic-pages/{dynamicPage}/preview', [\App\Http\Controllers\Admin\DynamicPageController::class, 'preview'])->name('dynamic-pages.preview');
    Route::post('/dynamic-pages/{dynamicPage}/duplicate', [\App\Http\Controllers\Admin\DynamicPageController::class, 'duplicate'])->name('dynamic-pages.duplicate');
    
    // Content Blocks Management
    Route::resource('content-blocks', \App\Http\Controllers\Admin\ContentBlockController::class);
    Route::post('/content-blocks/{contentBlock}/duplicate', [\App\Http\Controllers\Admin\ContentBlockController::class, 'duplicate'])->name('content-blocks.duplicate');
    Route::patch('/content-blocks/{contentBlock}/toggle-active', [\App\Http\Controllers\Admin\ContentBlockController::class, 'toggleActive'])->name('content-blocks.toggle-active');
    
    // Hero Sections Management
    Route::resource('hero-sections', HeroSectionController::class);
    Route::patch('/hero-sections/{heroSection}/toggle-active', [HeroSectionController::class, 'toggleActive'])->name('hero-sections.toggle-active');
    
    // Associates Management
    Route::resource('associates', AssociateController::class);
    Route::patch('/associates/{associate}/toggle-active', [AssociateController::class, 'toggleActive'])->name('associates.toggle-active');
    
    // Distribution Services Management
    Route::resource('distribution-services', DistributionServiceController::class);
    Route::patch('/distribution-services/{distributionService}/toggle-active', [DistributionServiceController::class, 'toggleActive'])->name('distribution-services.toggle-active');
    
    // Global Impact Management (Settings-style)
    Route::get('/global-impact', [GlobalImpactController::class, 'index'])->name('global-impact.index');
    Route::put('/global-impact', [GlobalImpactController::class, 'update'])->name('global-impact.update');
    
    // Film Categories Management
    Route::resource('film-categories', FilmCategoryController::class);
    Route::patch('/film-categories/{filmCategory}/toggle-active', [FilmCategoryController::class, 'toggleActive'])->name('film-categories.toggle-active');
    
    // Film Portfolios Management
    Route::resource('film-portfolios', FilmPortfolioController::class);
    Route::patch('/film-portfolios/{filmPortfolio}/toggle-featured', [FilmPortfolioController::class, 'toggleFeatured'])->name('film-portfolios.toggle-featured');
    Route::patch('/film-portfolios/{filmPortfolio}/toggle-published', [FilmPortfolioController::class, 'togglePublished'])->name('film-portfolios.toggle-published');
    
    // Testimonials Management
    Route::resource('testimonials', TestimonialController::class);
    Route::patch('/testimonials/{testimonial}/toggle-featured', [TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
    Route::patch('/testimonials/{testimonial}/toggle-published', [TestimonialController::class, 'togglePublished'])->name('testimonials.toggle-published');
    
    // Mission & Vision Management
    Route::get('/mission-vision', [MissionVisionController::class, 'index'])->name('mission-vision.index');
    Route::put('/mission-vision', [MissionVisionController::class, 'update'])->name('mission-vision.update');
    
    // Core Values Management
    Route::resource('core-values', CoreValueController::class);
    Route::patch('/core-values/{coreValue}/toggle-active', [CoreValueController::class, 'toggleActive'])->name('core-values.toggle-active');
    
    // Services Management
    Route::resource('services', ServiceController::class);
    Route::patch('/services/{service}/toggle-featured', [ServiceController::class, 'toggleFeatured'])->name('services.toggle-featured');
    Route::patch('/services/{service}/toggle-active', [ServiceController::class, 'toggleActive'])->name('services.toggle-active');
    
    // Trusted Partners Management
    Route::resource('trusted-partners', TrustedPartnerController::class);
    Route::patch('/trusted-partners/{trustedPartner}/toggle-active', [TrustedPartnerController::class, 'toggleActive'])->name('trusted-partners.toggle-active');
    
    // Partnership Benefits Management
    Route::resource('partnership-benefits', PartnershipBenefitController::class);
    Route::patch('/partnership-benefits/{partnershipBenefit}/toggle-active', [PartnershipBenefitController::class, 'toggleActive'])->name('partnership-benefits.toggle-active');
    
    // Team Members Management
    Route::resource('team-members', TeamMemberController::class);
    Route::patch('/team-members/{teamMember}/toggle-active', [TeamMemberController::class, 'toggleActive'])->name('team-members.toggle-active');
    
    // Team Values Management
    Route::resource('team-values', TeamValueController::class);
    Route::patch('/team-values/{teamValue}/toggle-active', [TeamValueController::class, 'toggleActive'])->name('team-values.toggle-active');
});
