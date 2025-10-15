<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class HostingHelper
{
    /**
     * Detect the current hosting environment
     */
    public static function detectEnvironment(): string
    {
        $config = Config::get('hosting.environment', 'auto');
        
        if ($config !== 'auto') {
            return $config;
        }

        $host = request()->getHost();
        $serverName = $_SERVER['SERVER_NAME'] ?? '';
        $httpHost = $_SERVER['HTTP_HOST'] ?? '';

        // Check for localhost indicators
        $localhostIndicators = Config::get('hosting.auto_detection.localhost_indicators', []);
        foreach ($localhostIndicators as $indicator) {
            if (str_contains($host, $indicator) || 
                str_contains($serverName, $indicator) || 
                str_contains($httpHost, $indicator)) {
                return 'localhost';
            }
        }

        // Check for shared hosting indicators
        $sharedIndicators = Config::get('hosting.auto_detection.shared_hosting_indicators', []);
        foreach ($sharedIndicators as $indicator) {
            if (str_contains($host, $indicator) || 
                str_contains($serverName, $indicator) || 
                str_contains($httpHost, $indicator)) {
                return 'shared';
            }
        }

        // Default to shared hosting if not localhost
        return 'shared';
    }

    /**
     * Check if running on localhost
     */
    public static function isLocalhost(): bool
    {
        return self::detectEnvironment() === 'localhost';
    }

    /**
     * Check if running on shared hosting
     */
    public static function isSharedHosting(): bool
    {
        return self::detectEnvironment() === 'shared';
    }

    /**
     * Get environment-specific configuration
     */
    public static function getConfig(string $key, $default = null)
    {
        $environment = self::detectEnvironment();
        return Config::get("hosting.{$environment}.{$key}", $default);
    }

    /**
     * Get the appropriate asset URL
     */
    public static function getAssetUrl(): ?string
    {
        $assetUrl = self::getConfig('asset_url');
        
        if ($assetUrl) {
            return $assetUrl;
        }

        // Auto-generate asset URL for shared hosting
        if (self::isSharedHosting()) {
            $protocol = request()->secure() ? 'https' : 'http';
            $host = request()->getHost();
            
            // For subdomain setup, assets are served from the same domain
            // The document root should point to the public directory
            return "{$protocol}://{$host}";
        }

        return null;
    }

    /**
     * Get optimized settings for current environment
     */
    public static function getOptimizedSettings(): array
    {
        $environment = self::detectEnvironment();
        $settings = Config::get("hosting.{$environment}", []);

        return [
            'debug' => $settings['debug'] ?? false,
            'cache' => $settings['cache'] ?? true,
            'optimize' => $settings['optimize'] ?? true,
            'asset_url' => self::getAssetUrl(),
            'session_driver' => $settings['session_driver'] ?? 'database',
            'cache_driver' => $settings['cache_driver'] ?? 'database',
        ];
    }

    /**
     * Apply environment-specific optimizations
     */
    public static function applyOptimizations(): void
    {
        $settings = self::getOptimizedSettings();

        // Set debug mode
        Config::set('app.debug', $settings['debug']);

        // Set asset URL
        if ($settings['asset_url']) {
            Config::set('app.asset_url', $settings['asset_url']);
        }

        // Set session driver
        Config::set('session.driver', $settings['session_driver']);

        // Set cache driver
        Config::set('cache.default', $settings['cache_driver']);

        // Apply performance settings
        if (self::isSharedHosting()) {
            self::applySharedHostingOptimizations();
        }
    }

    /**
     * Apply shared hosting specific optimizations
     */
    private static function applySharedHostingOptimizations(): void
    {
        // Enable caching
        if (Config::get('hosting.performance.enable_caching', true)) {
            Config::set('view.cache', true);
            Config::set('route.cache', true);
            Config::set('config.cache', true);
        }

        // Optimize autoloader
        if (Config::get('hosting.performance.optimize_autoloader', true)) {
            // This would typically be done via composer
        }
    }

    /**
     * Get hosting information for debugging
     */
    public static function getHostingInfo(): array
    {
        return [
            'environment' => self::detectEnvironment(),
            'host' => request()->getHost(),
            'server_name' => $_SERVER['SERVER_NAME'] ?? 'unknown',
            'http_host' => $_SERVER['HTTP_HOST'] ?? 'unknown',
            'is_secure' => request()->secure(),
            'asset_url' => self::getAssetUrl(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
        ];
    }
}
