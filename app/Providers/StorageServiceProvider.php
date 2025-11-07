<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use App\Helpers\HostingHelper;

class StorageServiceProvider extends ServiceProvider
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
        // For shared hosting without symlinks, we need to sync files
        // Only sync if STORAGE_TYPE is set to 'copy'
        if (env('STORAGE_TYPE', 'symlink') === 'copy') {
            $this->app->terminating(function () {
                $this->syncStorageFiles();
            });
        }
    }

    /**
     * Sync files from storage/app/public to public/storage
     * This runs after each request to keep files in sync
     */
    protected function syncStorageFiles()
    {
        $storagePath = storage_path('app/public');
        $publicDir = $this->detectPublicDirectory();
        $publicStoragePath = $publicDir . '/storage';

        // Only sync if both directories exist and public/storage is not a symlink
        if (is_dir($storagePath) && is_dir($publicStoragePath) && !is_link($publicStoragePath)) {
            // This is a lightweight sync - only copy new/modified files
            // For better performance, you might want to use a queue job
            try {
                $this->syncDirectory($storagePath, $publicStoragePath);
            } catch (\Exception $e) {
                // Silently fail to avoid breaking the application
                \Log::warning('Storage sync failed: ' . $e->getMessage());
            }
        }
    }

    /**
     * Sync directory contents
     */
    protected function syncDirectory($source, $destination)
    {
        if (!is_dir($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $sourceFiles = File::allFiles($source);
        
        foreach ($sourceFiles as $file) {
            $relativePath = str_replace($source . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $destPath = $destination . DIRECTORY_SEPARATOR . $relativePath;
            $destDir = dirname($destPath);

            // Create destination directory if it doesn't exist
            if (!is_dir($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }

            // Only copy if file doesn't exist or is newer
            if (!File::exists($destPath) || File::lastModified($file->getPathname()) > File::lastModified($destPath)) {
                File::copy($file->getPathname(), $destPath);
            }
        }
    }

    /**
     * Detect the public directory (public_html for shared hosting, public for standard)
     * Handles both structures:
     * - public_html inside project: /home/username/project/public_html
     * - public_html as sibling: /home/username/public_html (project is /home/username/osr)
     */
    protected function detectPublicDirectory(): string
    {
        // Check environment variable first (highest priority)
        $envPublicPath = env('PUBLIC_PATH');
        if ($envPublicPath && is_dir($envPublicPath)) {
            return $envPublicPath;
        }

        // Check for public_html as sibling directory (common shared hosting structure)
        // If project is in /home/username/osr, check /home/username/public_html
        $basePath = base_path();
        $parentDir = dirname($basePath);
        $siblingPublicHtml = $parentDir . '/public_html';
        if (is_dir($siblingPublicHtml)) {
            return $siblingPublicHtml;
        }

        // Check for public_html inside project directory
        $publicHtmlPath = base_path('public_html');
        if (is_dir($publicHtmlPath)) {
            return $publicHtmlPath;
        }

        // Check if public_path() points to public_html
        $standardPublicPath = public_path();
        if (str_contains($standardPublicPath, 'public_html')) {
            return $standardPublicPath;
        }

        // Default to standard public path
        return public_path();
    }
}

