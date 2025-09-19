<?php

namespace App\Listeners;

use App\Helpers\ThemeHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class ClearThemeSettingsCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Clear theme settings cache when general settings are updated
        ThemeHelper::clearCache();

        // Also clear view cache to ensure immediate frontend updates
        try {
            Artisan::call('view:clear');
        } catch (\Exception $e) {
            // Ignore if view:clear fails
        }
    }
}
