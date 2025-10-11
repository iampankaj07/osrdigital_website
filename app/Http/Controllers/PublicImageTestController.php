<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PublicImageTestController extends Controller
{
    /**
     * Public test endpoint for image serving
     */
    public function testImageServing()
    {
        try {
            $testResults = [
                'timestamp' => now()->toISOString(),
                'environment' => app()->environment(),
                'app_url' => config('app.url'),
                'filesystem_disk' => config('filesystems.default'),
                'storage_config' => [
                    'public_root' => config('filesystems.disks.public.root'),
                    'public_url' => config('filesystems.disks.public.url'),
                ],
                'storage_paths' => [
                    'storage_path' => storage_path('app/public'),
                    'storage_exists' => is_dir(storage_path('app/public')),
                    'storage_writable' => is_writable(storage_path('app/public')),
                ],
                'associates_directory' => [
                    'path' => storage_path('app/public/associates'),
                    'exists' => is_dir(storage_path('app/public/associates')),
                    'writable' => is_writable(storage_path('app/public/associates')),
                ],
                'test_files' => [],
                'url_tests' => []
            ];

            // Test file listing
            if (is_dir(storage_path('app/public/associates'))) {
                $files = File::files(storage_path('app/public/associates'));
                foreach ($files as $file) {
                    $filename = $file->getFilename();
                    $relativePath = 'associates/' . $filename;
                    
                    $testResults['test_files'][] = [
                        'filename' => $filename,
                        'relative_path' => $relativePath,
                        'full_path' => $file->getPathname(),
                        'size' => $file->getSize(),
                        'modified' => $file->getMTime(),
                        'exists' => file_exists($file->getPathname()),
                        'readable' => is_readable($file->getPathname()),
                    ];
                }
            }

            // Test URL generation
            if (!empty($testResults['test_files'])) {
                $firstFile = $testResults['test_files'][0];
                $relativePath = $firstFile['relative_path'];
                
                $testResults['url_tests'] = [
                    'storage_url' => Storage::disk('public')->url($relativePath),
                    'custom_image_url' => url('/images/' . $relativePath),
                    'direct_file_url' => config('app.url') . '/storage/' . $relativePath,
                ];
            }

            return response()->json([
                'success' => true,
                'test_results' => $testResults
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Serve a test image for debugging
     */
    public function serveTestImage($filename)
    {
        try {
            $path = 'associates/' . $filename;
            $fullPath = storage_path('app/public/' . $path);
            
            if (!file_exists($fullPath)) {
                return response()->json([
                    'error' => 'File not found',
                    'path' => $path,
                    'full_path' => $fullPath,
                    'exists' => file_exists($fullPath)
                ], 404);
            }
            
            $mimeType = mime_content_type($fullPath);
            $fileSize = filesize($fullPath);
            
            return response()->file($fullPath, [
                'Content-Type' => $mimeType,
                'Content-Length' => $fileSize,
                'Cache-Control' => 'public, max-age=3600',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
