<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    /**
     * Get the URL for a storage file
     * Handles both symlink and copy modes
     */
    public static function url($path): string
    {
        $storageType = env('STORAGE_TYPE', 'symlink');
        
        if ($storageType === 'copy') {
            // For copy mode, files are in public/storage or public_html/storage
            $publicDir = self::detectPublicDirectory();
            $publicPath = $publicDir . '/storage/' . $path;
            if (File::exists($publicPath)) {
                return asset('storage/' . $path);
            }
            // Fallback to route-based serving
            return route('storage.serve', ['path' => $path]);
        }
        
        // Default symlink mode
        return Storage::disk('public')->url($path);
    }

    /**
     * Detect the public directory (public_html for shared hosting, public for standard)
     * Handles both structures:
     * - public_html inside project: /home/username/project/public_html
     * - public_html as sibling: /home/username/public_html (project is /home/username/osr)
     */
    public static function detectPublicDirectory(): string
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

    /**
     * Copy file to public/storage after upload
     * Use this after storing files when STORAGE_TYPE=copy
     */
    public static function copyToPublic($path): bool
    {
        $storagePath = storage_path('app/public/' . $path);
        $publicDir = self::detectPublicDirectory();
        $publicPath = $publicDir . '/storage/' . $path;
        
        if (!File::exists($storagePath)) {
            return false;
        }
        
        $publicDir = dirname($publicPath);
        if (!is_dir($publicDir)) {
            File::makeDirectory($publicDir, 0755, true);
        }
        
        return File::copy($storagePath, $publicPath);
    }

    /**
     * Check if storage is set up correctly
     */
    public static function checkStorage(): array
    {
        $issues = [];
        $storageType = env('STORAGE_TYPE', 'symlink');
        
        $publicDir = self::detectPublicDirectory();
        $publicStoragePath = $publicDir . '/storage';
        $storagePath = storage_path('app/public');
        
        // Check storage directory
        if (!is_dir($storagePath)) {
            $issues[] = "Storage directory does not exist: {$storagePath}";
        }
        
        // Check public/storage
        if ($storageType === 'copy') {
            if (!is_dir($publicStoragePath)) {
                $issues[] = "Public storage directory does not exist: {$publicStoragePath}";
                $issues[] = "Run: php artisan storage:setup-no-symlink";
            } elseif (is_link($publicStoragePath)) {
                $issues[] = "Public storage is a symlink but STORAGE_TYPE=copy is set";
                $issues[] = "Remove symlink and run: php artisan storage:setup-no-symlink";
            }
        } else {
            if (!is_link($publicStoragePath) && !is_dir($publicStoragePath)) {
                $issues[] = "Storage link does not exist: {$publicStoragePath}";
                $issues[] = "Run: php artisan storage:link";
            } elseif (is_dir($publicStoragePath) && !is_link($publicStoragePath)) {
                $issues[] = "Public storage is a directory but should be a symlink";
                $issues[] = "Run: php artisan storage:link";
            }
        }
        
        return $issues;
    }
}

