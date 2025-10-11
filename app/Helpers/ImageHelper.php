<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
        // If no path provided, return fallback
        if (empty($path)) {
            return $fallback ?: self::getPlaceholderImage();
        }

        // If it's already a full URL, return as is
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // If it's a placeholder URL, return as is
        if (self::isPlaceholderUrl($path)) {
            return $path;
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

        // Return fallback if nothing found
        return $fallback ?: self::getPlaceholderImage();
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
        // For cloud environments, use the configured URL
        if (config('app.env') === 'production' || config('app.env') === 'staging') {
            $baseUrl = config("filesystems.disks.{$disk}.url");
            if ($baseUrl) {
                return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
            }
        }

        // Use custom image controller for better handling
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
     * Get placeholder image URL
     * 
     * @param string $text
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function getPlaceholderImage(string $text = 'Image', int $width = 400, int $height = 300): string
    {
        return "https://via.placeholder.com/{$width}x{$height}/6366f1/ffffff?text=" . urlencode($text);
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
        
        // If it's a placeholder, update the size
        if (self::isPlaceholderUrl($url)) {
            return "https://via.placeholder.com/{$width}x{$height}/6366f1/ffffff?text=" . urlencode('Image');
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

        $config = $contextConfigs[$context] ?? $contextConfigs['default'];
        $width = $options['width'] ?? $config['width'];
        $height = $options['height'] ?? $config['height'];
        $text = $options['text'] ?? $config['text'];

        return self::getOptimizedImageUrl($path, $width, $height, self::getPlaceholderImage($text, $width, $height));
    }
}
