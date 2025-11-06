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
        
        // Force HTTP on localhost, HTTPS in production
        if (HostingHelper::isLocalhost() || app()->isLocal()) {
            URL::forceScheme('http');
        } elseif (!HostingHelper::isLocalhost() && !app()->isLocal()) {
            URL::forceScheme('https');
        }
        
        // Register view composer for settings
        View::composer('*', SettingsComposer::class);
        
        // Configure pagination to use numeric links
        Paginator::defaultView('pagination::bootstrap-4');
        Paginator::defaultSimpleView('pagination::simple-bootstrap-4');
    }
}
