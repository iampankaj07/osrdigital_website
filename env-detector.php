<?php

/**
 * Environment Detection Helper
 * 
 * This file helps detect the hosting environment and sets up
 * appropriate paths for Laravel to work on shared hosting.
 */

if (!function_exists('debugEnvironment')) {
    /**
     * Debug environment (remove in production)
     */
    function debugEnvironment(): void
    {
        // Remove or comment out in production
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
    }
}

if (!function_exists('getLaravelPaths')) {
    /**
     * Get environment-specific paths for Laravel
     */
    function getLaravelPaths(): array
    {
        $root = __DIR__;
        
        // Check if we're in a subdirectory (shared hosting)
        // or if public is the document root
        $publicPath = $root . '/public';
        $isPublicRoot = is_dir($publicPath);
        
        if ($isPublicRoot) {
            // Standard Laravel structure (public is subdirectory)
            return [
                'maintenance' => $root . '/storage/framework/maintenance.php',
                'autoload' => $root . '/vendor/autoload.php',
                'bootstrap' => $root . '/bootstrap/app.php',
            ];
        } else {
            // Shared hosting structure (public is document root)
            // In this case, the root index.php should be in public
            return [
                'maintenance' => dirname($root) . '/storage/framework/maintenance.php',
                'autoload' => dirname($root) . '/vendor/autoload.php',
                'bootstrap' => dirname($root) . '/bootstrap/app.php',
            ];
        }
    }
}

