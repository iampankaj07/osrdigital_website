<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Helpers\SettingsHelper;
use App\Helpers\ThemeHelper;

class TestStorage extends Command
{
    protected $signature = 'storage:test';
    protected $description = 'Test storage configuration and logo URLs';

    public function handle()
    {
        $this->info('Testing Storage Configuration...');

        // Test storage link
        $storagePath = public_path('storage');
        $this->info('Storage link exists: ' . (is_link($storagePath) ? 'Yes' : 'No'));

        // Test logo paths
        $logoPath = ThemeHelper::get('site_logo');
        $this->info('Logo path from settings: ' . ($logoPath ?? 'None'));

        if ($logoPath) {
            $fullPath = storage_path('app/public/' . $logoPath);
            $this->info('Logo file exists: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
            $this->info('Logo URL: ' . ThemeHelper::logo());
            $this->info('Admin Logo URL: ' . SettingsHelper::getAdminLogo());
        }

        // Test storage disk
        $this->info('Default disk: ' . config('filesystems.default'));
        $this->info('App URL: ' . config('app.url'));

        // Test asset generation
        $testAsset = asset('storage/logos/test.png');
        $this->info('Sample asset URL: ' . $testAsset);

        return 0;
    }
}
