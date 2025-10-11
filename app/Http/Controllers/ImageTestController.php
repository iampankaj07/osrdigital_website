<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageTestController extends Controller
{
    /**
     * Test image serving functionality
     */
    public function testImageServing(Request $request)
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
                    'files' => is_dir(storage_path('app/public/associates')) ? 
                        File::files(storage_path('app/public/associates')) : []
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

            // Test image serving endpoint
            if (!empty($testResults['test_files'])) {
                $firstFile = $testResults['test_files'][0];
                $relativePath = $firstFile['relative_path'];
                
                try {
                    $response = $this->testImageEndpoint('/images/' . $relativePath);
                    $testResults['url_tests']['image_endpoint_test'] = [
                        'url' => '/images/' . $relativePath,
                        'status' => $response['status'],
                        'content_type' => $response['content_type'],
                        'content_length' => $response['content_length'],
                        'success' => $response['status'] === 200
                    ];
                } catch (\Exception $e) {
                    $testResults['url_tests']['image_endpoint_test'] = [
                        'url' => '/images/' . $relativePath,
                        'error' => $e->getMessage(),
                        'success' => false
                    ];
                }
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
     * Test a specific image endpoint
     */
    private function testImageEndpoint(string $url)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get(config('app.url') . $url);
        
        return [
            'status' => $response->getStatusCode(),
            'content_type' => $response->getHeader('Content-Type')[0] ?? null,
            'content_length' => $response->getHeader('Content-Length')[0] ?? null,
        ];
    }

    /**
     * Serve a test image for debugging
     */
    public function serveTestImage(Request $request, $filename)
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
