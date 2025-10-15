<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class ImageController extends Controller
{
    /**
     * Serve images from storage with proper headers and caching
     */
    public function serve(Request $request, $path)
    {
        $fullPath = storage_path('app/public/' . $path);

        // Check if file exists
        if (!file_exists($fullPath)) {
            abort(404);
        }

        // Get file info
        $mimeType = mime_content_type($fullPath);
        $fileSize = filesize($fullPath);
        $lastModified = filemtime($fullPath);

        // Set proper headers
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Length' => $fileSize,
            'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified) . ' GMT',
            'Cache-Control' => 'public, max-age=31536000', // 1 year cache
            'ETag' => md5($fullPath . $lastModified),
        ];

        // Check if client has cached version
        $ifModifiedSince = $request->header('If-Modified-Since');
        $ifNoneMatch = $request->header('If-None-Match');

        if ($ifModifiedSince && strtotime($ifModifiedSince) >= $lastModified) {
            return response('', 304, $headers);
        }

        if ($ifNoneMatch && $ifNoneMatch === $headers['ETag']) {
            return response('', 304, $headers);
        }

        return response()->file($fullPath, $headers);
    }

    /**
     * Serve optimized images with size parameters
     */
    public function optimized(Request $request, $width, $height, $path)
    {
        $fullPath = storage_path('app/public/' . $path);

        // Check if file exists
        if (!file_exists($fullPath)) {
            abort(404);
        }

        // For now, just serve the original image
        // In production, you might want to implement actual image resizing
        $mimeType = mime_content_type($fullPath);
        $fileSize = filesize($fullPath);
        $lastModified = filemtime($fullPath);

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Length' => $fileSize,
            'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified) . ' GMT',
            'Cache-Control' => 'public, max-age=31536000',
            'ETag' => md5($fullPath . $lastModified . $width . $height),
        ];

        return response()->file($fullPath, $headers);
    }

    /**
     * Placeholder method disabled - no longer serving placeholder images
     */
    public function placeholder(Request $request, $width, $height)
    {
        // Return 404 instead of generating placeholder
        abort(404, 'Placeholder images are no longer supported');
    }

    /**
     * Get image info (for API)
     */
    public function info(Request $request, $path)
    {
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $info = ImageHelper::getImageInfo($path);

        if (!$info) {
            return response()->json(['error' => 'Invalid image'], 400);
        }

        return response()->json($info);
    }
}
