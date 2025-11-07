<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class StorageController extends Controller
{
    /**
     * Serve files from storage/app/public
     * This is used when symlinks are not available on shared hosting
     */
    public function serve($path)
    {
        $storagePath = storage_path('app/public/' . $path);
        
        // Security: Prevent directory traversal
        $storagePath = realpath($storagePath);
        $basePath = realpath(storage_path('app/public'));
        
        if (!$storagePath || strpos($storagePath, $basePath) !== 0) {
            abort(404);
        }

        if (!File::exists($storagePath)) {
            abort(404);
        }

        // Get file mime type
        $mimeType = File::mimeType($storagePath);
        
        // Set appropriate headers
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Length' => File::size($storagePath),
            'Cache-Control' => 'public, max-age=31536000', // 1 year cache
        ];

        return response()->file($storagePath, $headers);
    }
}

