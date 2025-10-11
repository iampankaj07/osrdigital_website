<?php

namespace App\Providers;

use App\Helpers\ImageHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register Blade directives for image handling
        Blade::directive('image', function ($expression) {
            return "<?php echo App\Helpers\ImageHelper::getImageUrl($expression); ?>";
        });

        Blade::directive('optimizedImage', function ($expression) {
            return "<?php echo App\Helpers\ImageHelper::getOptimizedImageUrl($expression); ?>";
        });

        Blade::directive('contextualImage', function ($expression) {
            return "<?php echo App\Helpers\ImageHelper::getContextualImage($expression); ?>";
        });

        Blade::directive('placeholderImage', function ($expression) {
            return "<?php echo App\Helpers\ImageHelper::getPlaceholderImage($expression); ?>";
        });
    }
}
