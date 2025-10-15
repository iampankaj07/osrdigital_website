<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;

class ImageHelper
{
    /**
     * Get a safe image URL that works in all environments
     * 
     * @param string|null $path The image path
     * @param string $fallback The fallback image URL
     * @param string $disk The storage disk to use
     * @return string
     */
    public static function getImageUrl(?string $path, string $fallback = '', string $disk = 'public'): string
    {
        // If no path provided, return fallback or empty string
        if (empty($path)) {
            return $fallback;
        }

        // If it's already a full URL, return as is (unless it's a placeholder)
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            // If it's a placeholder URL, return empty string
            if (self::isPlaceholderUrl($path)) {
                return '';
            }
            return $path;
        }

        // If it's a placeholder URL, return empty string
        if (self::isPlaceholderUrl($path)) {
            return '';
        }

        // Check if file exists in storage
        if (Storage::disk($disk)->exists($path)) {
            return self::getStorageUrl($path, $disk);
        }

        // Try with different path formats
        $possiblePaths = [
            $path,
            ltrim($path, '/'),
            'public/' . ltrim($path, '/'),
            str_replace('storage/', '', $path),
        ];

        foreach ($possiblePaths as $possiblePath) {
            if (Storage::disk($disk)->exists($possiblePath)) {
                return self::getStorageUrl($possiblePath, $disk);
            }
        }

        // Return fallback or empty string if nothing found
        return $fallback;
    }

    /**
     * Get storage URL with proper environment handling
     * 
     * @param string $path
     * @param string $disk
     * @return string
     */
    public static function getStorageUrl(string $path, string $disk = 'public'): string
    {
        // For production environments, use storage URL directly
        // For local development, use custom image controller
        if (app()->environment('production') || app()->environment('staging')) {
            return Storage::disk($disk)->url($path);
        }
        
        // Use custom image controller for local development
        return url('/images/' . ltrim($path, '/'));
    }

    /**
     * Check if URL is a placeholder
     * 
     * @param string $url
     * @return bool
     */
    public static function isPlaceholderUrl(string $url): bool
    {
        $placeholderDomains = [
            'via.placeholder.com',
            'ui-avatars.com',
            'picsum.photos',
            'placeholder.com',
            'placehold.co',
            'via.placeholder.com',
        ];

        foreach ($placeholderDomains as $domain) {
            if (strpos($url, $domain) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get placeholder image URL - returns empty string (placeholders disabled)
     * 
     * @param string $text
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function getPlaceholderImage(string $text = 'Image', int $width = 400, int $height = 300): string
    {
        return '';
    }

    /**
     * Get optimized image URL with size parameters
     * 
     * @param string|null $path
     * @param int $width
     * @param int $height
     * @param string $fallback
     * @return string
     */
    public static function getOptimizedImageUrl(?string $path, int $width = 400, int $height = 300, string $fallback = ''): string
    {
        $url = self::getImageUrl($path, $fallback);
        
        // If it's a placeholder or empty, return empty string
        if (self::isPlaceholderUrl($url) || empty($url)) {
            return '';
        }

        return $url;
    }

    /**
     * Get responsive image URLs for different screen sizes
     * 
     * @param string|null $path
     * @param array $sizes
     * @param string $fallback
     * @return array
     */
    public static function getResponsiveImageUrls(?string $path, array $sizes = ['sm' => 400, 'md' => 600, 'lg' => 800, 'xl' => 1200], string $fallback = ''): array
    {
        $urls = [];
        
        foreach ($sizes as $breakpoint => $size) {
            $urls[$breakpoint] = self::getOptimizedImageUrl($path, $size, $size, $fallback);
        }

        return $urls;
    }

    /**
     * Check if image exists in storage
     * 
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public static function imageExists(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($path);
    }

    /**
     * Get image info (size, mime type, etc.)
     * 
     * @param string $path
     * @param string $disk
     * @return array|null
     */
    public static function getImageInfo(string $path, string $disk = 'public'): ?array
    {
        if (!self::imageExists($path, $disk)) {
            return null;
        }

        $fullPath = Storage::disk($disk)->path($path);
        
        if (!file_exists($fullPath)) {
            return null;
        }

        $info = getimagesize($fullPath);
        
        if (!$info) {
            return null;
        }

        return [
            'width' => $info[0],
            'height' => $info[1],
            'mime_type' => $info['mime'],
            'size' => filesize($fullPath),
            'url' => self::getStorageUrl($path, $disk)
        ];
    }

    /**
     * Generate image with fallback for different contexts
     * 
     * @param string|null $path
     * @param string $context
     * @param array $options
     * @return string
     */
    public static function getContextualImage(?string $path, string $context = 'default', array $options = []): string
    {
        $contextConfigs = [
            'avatar' => ['width' => 100, 'height' => 100, 'text' => 'Avatar'],
            'thumbnail' => ['width' => 300, 'height' => 200, 'text' => 'Thumbnail'],
            'hero' => ['width' => 1200, 'height' => 600, 'text' => 'Hero Image'],
            'card' => ['width' => 400, 'height' => 300, 'text' => 'Card Image'],
            'logo' => ['width' => 200, 'height' => 100, 'text' => 'Logo'],
            'banner' => ['width' => 800, 'height' => 400, 'text' => 'Banner'],
        ];

        $config = $contextConfigs[$context] ?? ['width' => 400, 'height' => 300, 'text' => 'Image'];
        $width = $options['width'] ?? $config['width'];
        $height = $options['height'] ?? $config['height'];

        return self::getOptimizedImageUrl($path, $width, $height, '');
    }


    /**
     * Generate responsive image srcset
     * 
     * @param string|null $path
     * @param array $sizes
     * @return string
     */
    public static function getResponsiveSrcset(?string $path, array $sizes = [320, 640, 768, 1024, 1280]): string
    {
        if (empty($path)) {
            return '';
        }

        $srcset = [];
        foreach ($sizes as $size) {
            $optimizedUrl = self::getOptimizedImageUrl($path, $size, $size * 0.75, '');
            if ($optimizedUrl) {
                $srcset[] = "{$optimizedUrl} {$size}w";
            }
        }

        return implode(', ', $srcset);
    }

    /**
     * Preload critical images
     * 
     * @param array $imagePaths
     * @return string
     */
    public static function generatePreloadTags(array $imagePaths): string
    {
        $tags = [];
        foreach ($imagePaths as $path) {
            if (!empty($path)) {
                $url = self::getImageUrl($path);
                $tags[] = "<link rel=\"preload\" as=\"image\" href=\"{$url}\">";
            }
        }
        return implode("\n", $tags);
    }
}
