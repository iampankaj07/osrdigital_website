<?php

namespace App\Observers;

use App\Helpers\ThemeHelper;

class GeneralSettingsObserver
{
    /**
     * Handle the "updated" event.
     */
    public function updated($model): void
    {
        // Clear theme settings cache when general settings are updated
        ThemeHelper::clearCache();
    }

    /**
     * Handle the "created" event.
     */
    public function created($model): void
    {
        // Clear theme settings cache when general settings are created
        ThemeHelper::clearCache();
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted($model): void
    {
        // Clear theme settings cache when general settings are deleted
        ThemeHelper::clearCache();
    }
}
