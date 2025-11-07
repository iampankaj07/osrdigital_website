<?php

namespace App\Providers;

use App\View\Composers\SettingsComposer;
use App\Helpers\HostingHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Apply hosting environment optimizations
        HostingHelper::applyOptimizations();
        
        // Force HTTPS in production - check if request is secure or if APP_ENV is production
        $isProduction = app()->environment('production');
        $isSecure = request()->isSecure() || request()->header('X-Forwarded-Proto') === 'https';
        $isLocalhost = HostingHelper::isLocalhost() || app()->isLocal();
        
        if ($isProduction || ($isSecure && !$isLocalhost)) {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http');
        }
        
        // Register view composer for settings
        View::composer('*', SettingsComposer::class);
        
        // Configure pagination to use numeric links
        Paginator::defaultView('pagination::bootstrap-4');
        Paginator::defaultSimpleView('pagination::simple-bootstrap-4');
    }
}
