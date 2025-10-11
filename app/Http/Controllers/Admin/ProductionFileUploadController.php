<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductionFileUploadController extends Controller
{
    /**
     * Upload associate image with production environment optimizations
     */
    public function uploadAssociateImage(Request $request)
    {
        try {
            Log::info('Production Associate image upload request received', [
                'user_id' => auth()->id(),
                'environment' => app()->environment(),
                'has_file' => $request->hasFile('logo'),
                'filesystem_disk' => config('filesystems.default'),
                'app_url' => config('app.url'),
                'file_info' => $request->hasFile('logo') ? [
                    'size' => $request->file('logo')->getSize(),
                    'mime' => $request->file('logo')->getMimeType(),
                    'extension' => $request->file('logo')->getClientOriginalExtension(),
                    'original_name' => $request->file('logo')->getClientOriginalName(),
                    'is_valid' => $request->file('logo')->isValid(),
                    'error' => $request->file('logo')->getError()
                ] : 'No file'
            ]);

            $validator = \Validator::make($request->all(), [
                'logo' => 'required|file|mimes:png,svg,jpg,jpeg|max:2048',
                'old_file' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::error('Production validation failed', [
                    'errors' => $validator->errors(),
                    'file_info' => $request->hasFile('logo') ? [
                        'size' => $request->file('logo')->getSize(),
                        'mime' => $request->file('logo')->getMimeType(),
                        'extension' => $request->file('logo')->getClientOriginalExtension(),
                    ] : 'No file'
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $validator->errors()->first('logo'),
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                
                // Check if file is valid
                if (!$file->isValid()) {
                    Log::error('Production file upload error', [
                        'error_code' => $file->getError(),
                        'error_message' => $file->getErrorMessage(),
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'File upload error: ' . $file->getErrorMessage(),
                        'errors' => ['logo' => ['File upload error: ' . $file->getErrorMessage()]]
                    ], 422);
                }
                
                // Additional validation for file content
                $allowedMimes = ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'];
                $fileMime = $file->getMimeType();
                
                if (!in_array($fileMime, $allowedMimes)) {
                    Log::error('Production invalid file MIME type', [
                        'expected' => $allowedMimes,
                        'actual' => $fileMime,
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file type. Please upload a PNG, SVG, JPG, or JPEG image.',
                        'errors' => ['logo' => ['Invalid file type. Please upload a PNG, SVG, JPG, or JPEG image.']]
                    ], 422);
                }
                
                // Delete old file if provided
                if ($request->filled('old_file')) {
                    $oldFile = $request->input('old_file');
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                        Log::info('Production old associate image deleted', ['old_file' => $oldFile]);
                    }
                }
                
                $filename = 'associates/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Production-specific directory creation
                $this->ensureProductionDirectoryExists('associates');
                
                Log::info('Production attempting to store file', [
                    'filename' => $filename,
                    'file_size' => $file->getSize(),
                    'storage_path' => storage_path('app/public'),
                    'target_path' => storage_path('app/public/' . $filename),
                    'production_environment' => app()->environment('production')
                ]);
                
                // Production-optimized storage with multiple fallbacks
                $path = null;
                $url = null;
                
                try {
                    // Method 1: Direct file system operations (most reliable in production)
                    $targetPath = storage_path('app/public/' . $filename);
                    $targetDir = dirname($targetPath);
                    
                    // Ensure directory exists
                    if (!File::exists($targetDir)) {
                        File::makeDirectory($targetDir, 0755, true);
                        Log::info('Production created directory', ['directory' => $targetDir]);
                    }
                    
                    // Copy file directly
                    if (File::copy($file->getPathname(), $targetPath)) {
                        $path = $filename;
                        $url = $this->generateProductionUrl($filename);
                        Log::info('Production file stored using direct copy', ['path' => $path, 'url' => $url]);
                    } else {
                        throw new \Exception('Direct copy method failed');
                    }
                    
                } catch (\Exception $e) {
                    Log::warning('Production direct copy failed, trying Storage facade', ['error' => $e->getMessage()]);
                    
                    try {
                        // Method 2: Storage facade with content
                        $fileContent = File::get($file->getPathname());
                        $path = Storage::disk('public')->put($filename, $fileContent);
                        
                        if ($path && Storage::disk('public')->exists($filename)) {
                            $url = $this->generateProductionUrl($filename);
                            Log::info('Production file stored using Storage facade', ['path' => $path, 'url' => $url]);
                        } else {
                            throw new \Exception('Storage facade method failed');
                        }
                        
                    } catch (\Exception $e2) {
                        Log::warning('Production Storage facade failed, trying putFileAs', ['error' => $e2->getMessage()]);
                        
                        try {
                            // Method 3: putFileAs method
                            $path = Storage::disk('public')->putFileAs('', $file, $filename);
                            
                            if ($path && Storage::disk('public')->exists($filename)) {
                                $url = $this->generateProductionUrl($filename);
                                Log::info('Production file stored using putFileAs', ['path' => $path, 'url' => $url]);
                            } else {
                                throw new \Exception('putFileAs method failed');
                            }
                            
                        } catch (\Exception $e3) {
                            Log::error('Production all storage methods failed', [
                                'direct_copy_error' => $e->getMessage(),
                                'storage_facade_error' => $e2->getMessage(),
                                'putfileas_error' => $e3->getMessage(),
                                'filename' => $filename,
                                'file_size' => $file->getSize(),
                                'storage_disk' => config('filesystems.default'),
                                'storage_path' => storage_path('app/public'),
                                'permissions' => [
                                    'storage_writable' => is_writable(storage_path('app/public')),
                                    'associates_writable' => is_writable(storage_path('app/public/associates'))
                                ],
                                'file_info' => [
                                    'pathname' => $file->getPathname(),
                                    'real_path' => $file->getRealPath(),
                                    'temp_name' => $file->getFilename()
                                ]
                            ]);
                            
                            throw new \Exception('All production storage methods failed: ' . $e3->getMessage());
                        }
                    }
                }
                
                // Production-specific verification
                if (!$path) {
                    Log::error('Production file storage failed - no path returned', [
                        'filename' => $filename,
                        'file_size' => $file->getSize(),
                        'storage_disk' => config('filesystems.default'),
                        'storage_path' => storage_path('app/public')
                    ]);
                    throw new \Exception('Production file storage failed - no path returned');
                }
                
                // Verify file exists using multiple methods
                $fileExists = false;
                $verificationMethods = [
                    'Storage::exists' => Storage::disk('public')->exists($filename),
                    'File::exists' => File::exists(storage_path('app/public/' . $filename)),
                    'is_file' => is_file(storage_path('app/public/' . $filename))
                ];
                
                foreach ($verificationMethods as $method => $exists) {
                    if ($exists) {
                        $fileExists = true;
                        Log::info("Production file verification passed using {$method}");
                        break;
                    }
                }
                
                if (!$fileExists) {
                    Log::error('Production file storage verification failed - file not found', [
                        'filename' => $filename,
                        'path' => $path,
                        'verification_methods' => $verificationMethods,
                        'storage_list' => Storage::disk('public')->files('associates'),
                        'directory_list' => Storage::disk('public')->directories('associates'),
                        'file_system_list' => File::files(storage_path('app/public/associates'))
                    ]);
                    throw new \Exception('Production file storage verification failed - file not found in storage');
                }
                
                // Additional verification - check file size
                $storedFileSize = File::size(storage_path('app/public/' . $filename));
                if ($storedFileSize !== $file->getSize()) {
                    Log::warning('Production file size mismatch after storage', [
                        'original_size' => $file->getSize(),
                        'stored_size' => $storedFileSize,
                        'filename' => $filename
                    ]);
                }
                
                Log::info('Production file storage result', [
                    'path' => $path,
                    'url' => $url,
                    'file_exists' => $fileExists,
                    'storage_exists' => is_dir(storage_path('app/public')),
                    'associates_dir_exists' => File::exists(storage_path('app/public/associates')),
                    'file_size_stored' => $storedFileSize
                ]);

                Log::info('Production associate image uploaded successfully', [
                    'filename' => $filename,
                    'url' => $url
                ]);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename,
                    'message' => 'Image uploaded successfully to production storage'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Production associate image upload error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Production upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ensure directory exists with production-specific handling
     */
    private function ensureProductionDirectoryExists(string $directory): void
    {
        try {
            $fullPath = storage_path('app/public/' . $directory);
            
            if (!File::exists($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
                Log::info('Production created directory', ['directory' => $directory, 'path' => $fullPath]);
            }
            
            // Verify directory was created and is writable
            if (!File::exists($fullPath)) {
                throw new \Exception("Failed to create production directory: {$directory}");
            }
            
            if (!is_writable($fullPath)) {
                Log::warning('Production directory not writable, attempting to fix permissions', [
                    'directory' => $directory,
                    'path' => $fullPath
                ]);
                chmod($fullPath, 0755);
            }
            
            Log::info('Production directory verified', [
                'directory' => $directory,
                'path' => $fullPath,
                'exists' => File::exists($fullPath),
                'writable' => is_writable($fullPath),
                'permissions' => substr(sprintf('%o', fileperms($fullPath)), -4)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Production directory creation failed', [
                'error' => $e->getMessage(),
                'directory' => $directory,
                'storage_path' => storage_path('app/public'),
                'target_path' => storage_path('app/public/' . $directory),
                'storage_exists' => File::exists(storage_path('app/public')),
                'storage_writable' => is_writable(storage_path('app/public'))
            ]);
            throw $e;
        }
    }

    /**
     * Generate production URL with proper domain handling
     */
    private function generateProductionUrl(string $filename): string
    {
        $baseUrl = config('app.url');
        $storageUrl = config('filesystems.disks.public.url', '/storage');
        
        // Ensure base URL doesn't have trailing slash
        $baseUrl = rtrim($baseUrl, '/');
        
        // Ensure storage URL starts with slash
        $storageUrl = '/' . ltrim($storageUrl, '/');
        
        return $baseUrl . $storageUrl . '/' . $filename;
    }
}
