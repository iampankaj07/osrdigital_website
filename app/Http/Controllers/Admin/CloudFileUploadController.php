<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CloudFileUploadController extends Controller
{
    /**
     * Upload associate image with Laravel Cloud optimizations
     */
    public function uploadAssociateImage(Request $request)
    {
        try {
            Log::info('Cloud Associate image upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('logo'),
                'cloud_environment' => app()->environment('production'),
                'filesystem_disk' => config('filesystems.default'),
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
                Log::error('Cloud validation failed', [
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
                    Log::error('Cloud file upload error', [
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
                    Log::error('Cloud invalid file MIME type', [
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
                        Log::info('Cloud old associate image deleted', ['old_file' => $oldFile]);
                    }
                }
                
                $filename = 'associates/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Cloud-specific directory creation
                $this->ensureCloudDirectoryExists('associates');
                
                Log::info('Cloud attempting to store file', [
                    'filename' => $filename,
                    'file_size' => $file->getSize(),
                    'storage_path' => storage_path('app/public'),
                    'target_path' => storage_path('app/public/' . $filename),
                    'cloud_environment' => app()->environment('production')
                ]);
                
                // Cloud-optimized storage methods
                $path = null;
                $url = null;
                
                try {
                    // Method 1: Direct file content storage (most reliable for cloud)
                    $fileContent = file_get_contents($file->getPathname());
                    $path = Storage::disk('public')->put($filename, $fileContent);
                    
                    if ($path && Storage::disk('public')->exists($filename)) {
                        $url = Storage::url($filename);
                        Log::info('Cloud file stored using content method', ['path' => $path, 'url' => $url]);
                    } else {
                        throw new \Exception('Content storage method failed');
                    }
                    
                } catch (\Exception $e) {
                    Log::warning('Cloud content method failed, trying stream method', ['error' => $e->getMessage()]);
                    
                    try {
                        // Method 2: Stream-based storage
                        $stream = fopen($file->getPathname(), 'r+');
                        $path = Storage::disk('public')->putFileAs('', $file, $filename);
                        fclose($stream);
                        
                        if ($path && Storage::disk('public')->exists($filename)) {
                            $url = Storage::url($filename);
                            Log::info('Cloud file stored using stream method', ['path' => $path, 'url' => $url]);
                        } else {
                            throw new \Exception('Stream storage method failed');
                        }
                        
                    } catch (\Exception $e2) {
                        Log::warning('Cloud stream method failed, trying copy method', ['error' => $e2->getMessage()]);
                        
                        try {
                            // Method 3: Copy method with cloud-specific handling
                            $targetPath = storage_path('app/public/' . $filename);
                            $targetDir = dirname($targetPath);
                            
                            if (!is_dir($targetDir)) {
                                mkdir($targetDir, 0755, true);
                            }
                            
                            if (copy($file->getPathname(), $targetPath)) {
                                $path = $filename;
                                $url = Storage::url($filename);
                                Log::info('Cloud file stored using copy method', ['path' => $path, 'url' => $url]);
                            } else {
                                throw new \Exception('Copy method failed');
                            }
                            
                        } catch (\Exception $e3) {
                            Log::error('Cloud all storage methods failed', [
                                'content_error' => $e->getMessage(),
                                'stream_error' => $e2->getMessage(),
                                'copy_error' => $e3->getMessage(),
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
                            
                            throw new \Exception('All cloud storage methods failed: ' . $e3->getMessage());
                        }
                    }
                }
                
                // Cloud-specific verification
                if (!$path) {
                    Log::error('Cloud file storage failed - no path returned', [
                        'filename' => $filename,
                        'file_size' => $file->getSize(),
                        'storage_disk' => config('filesystems.default'),
                        'storage_path' => storage_path('app/public')
                    ]);
                    throw new \Exception('Cloud file storage failed - no path returned');
                }
                
                if (!Storage::disk('public')->exists($filename)) {
                    Log::error('Cloud file storage verification failed - file not found', [
                        'filename' => $filename,
                        'path' => $path,
                        'storage_exists' => Storage::disk('public')->exists($filename),
                        'file_exists' => file_exists(storage_path('app/public/' . $filename)),
                        'storage_list' => Storage::disk('public')->files('associates'),
                        'directory_list' => Storage::disk('public')->directories('associates')
                    ]);
                    throw new \Exception('Cloud file storage verification failed - file not found in storage');
                }
                
                // Additional verification - check file size
                $storedFileSize = Storage::disk('public')->size($filename);
                if ($storedFileSize !== $file->getSize()) {
                    Log::warning('Cloud file size mismatch after storage', [
                        'original_size' => $file->getSize(),
                        'stored_size' => $storedFileSize,
                        'filename' => $filename
                    ]);
                }
                
                Log::info('Cloud file storage result', [
                    'path' => $path,
                    'url' => $url,
                    'file_exists' => Storage::disk('public')->exists($filename),
                    'storage_exists' => is_dir(storage_path('app/public')),
                    'associates_dir_exists' => Storage::disk('public')->exists('associates'),
                    'file_size_stored' => Storage::disk('public')->size($filename)
                ]);

                Log::info('Cloud associate image uploaded successfully', [
                    'filename' => $filename,
                    'url' => $url
                ]);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename,
                    'message' => 'Image uploaded successfully to cloud storage'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Cloud associate image upload error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Cloud upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ensure directory exists with cloud-specific handling
     */
    private function ensureCloudDirectoryExists(string $directory): void
    {
        try {
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
                Log::info('Cloud created directory', ['directory' => $directory]);
            }
            
            // Verify directory was created and is writable
            if (!Storage::disk('public')->exists($directory)) {
                throw new \Exception("Failed to create cloud directory: {$directory}");
            }
            
            Log::info('Cloud directory verified', [
                'directory' => $directory,
                'exists' => Storage::disk('public')->exists($directory),
                'writable' => is_writable(storage_path('app/public/' . $directory)),
                'permissions' => substr(sprintf('%o', fileperms(storage_path('app/public/' . $directory))), -4)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Cloud directory creation failed', [
                'error' => $e->getMessage(),
                'directory' => $directory,
                'storage_path' => storage_path('app/public'),
                'target_path' => storage_path('app/public/' . $directory),
                'storage_exists' => is_dir(storage_path('app/public')),
                'storage_writable' => is_writable(storage_path('app/public'))
            ]);
            throw $e;
        }
    }
}
