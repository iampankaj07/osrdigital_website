<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    /**
     * Upload partner logo
     */
    public function uploadPartnerLogo(Request $request)
    {
        try {
            \Log::info('Partner logo upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('logo'),
                'files' => $request->allFiles(),
                'all_data' => $request->all(),
                'old_file' => $request->input('old_file')
            ]);

            $request->validate([
                'logo' => 'required|file|mimes:png,svg,jpg,jpeg|max:2048', // 2MB max
                'old_file' => 'nullable|string',
            ]);

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                
                // Check if file is valid
                if (!$file->isValid()) {
                    \Log::error('File upload error', [
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
                    \Log::error('Invalid file MIME type', [
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
                        \Log::info('Old partner logo deleted', ['old_file' => $oldFile]);
                    }
                }
                
                $filename = 'partner-logos/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                \Log::info('Attempting to store partner logo', [
                    'filename' => $filename,
                    'file_size' => $file->getSize(),
                    'storage_path' => storage_path('app/public'),
                    'target_path' => storage_path('app/public/' . $filename)
                ]);
                
                // Use Storage::disk('public')->put() instead of storeAs
                $path = Storage::disk('public')->putFileAs('', $file, $filename);
                $url = Storage::url($filename);
                
                \Log::info('Partner logo storage result', [
                    'path' => $path,
                    'url' => $url,
                    'file_exists' => file_exists(storage_path('app/public/' . $filename)),
                    'storage_exists' => is_dir(storage_path('app/public')),
                    'partner_logos_dir_exists' => is_dir(storage_path('app/public/partner-logos'))
                ]);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename,
                    'message' => 'Logo uploaded successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Partner logo upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload team member avatar
     */
    public function uploadTeamMemberAvatar(Request $request)
    {
        try {
            \Log::info('Team member avatar upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('avatar'),
                'files' => $request->allFiles(),
                'all_data' => $request->all(),
                'old_file' => $request->input('old_file')
            ]);

            $request->validate([
                'avatar' => 'required|file|mimes:png,svg,jpg,jpeg|max:2048', // 2MB max
                'old_file' => 'nullable|string',
            ]);

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                
                // Check if file is valid
                if (!$file->isValid()) {
                    \Log::error('Team member avatar upload error', [
                        'error_code' => $file->getError(),
                        'error_message' => $file->getErrorMessage(),
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'File upload error: ' . $file->getErrorMessage(),
                        'errors' => ['avatar' => ['File upload error: ' . $file->getErrorMessage()]]
                    ], 422);
                }
                
                // Additional validation for file content
                $allowedMimes = ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'];
                $fileMime = $file->getMimeType();
                
                if (!in_array($fileMime, $allowedMimes)) {
                    \Log::error('Invalid team member avatar MIME type', [
                        'expected' => $allowedMimes,
                        'actual' => $fileMime,
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file type. Please upload a PNG, SVG, JPG, or JPEG image.',
                        'errors' => ['avatar' => ['Invalid file type. Please upload a PNG, SVG, JPG, or JPEG image.']]
                    ], 422);
                }
                
                // Delete old file if provided
                if ($request->filled('old_file')) {
                    $oldFile = $request->input('old_file');
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                        \Log::info('Old team member avatar deleted', ['old_file' => $oldFile]);
                    }
                }
                
                $filename = 'team-avatars/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Ensure the directory exists
                if (!Storage::disk('public')->exists('team-avatars')) {
                    Storage::disk('public')->makeDirectory('team-avatars');
                }
                
                // Use Storage::disk('public')->put() instead of storeAs
                $path = Storage::disk('public')->putFileAs('', $file, $filename);
                $url = Storage::url($filename);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename,
                    'message' => 'Avatar uploaded successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Team member avatar upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload associate image
     */
    public function uploadAssociateImage(Request $request)
    {
        try {
            \Log::info('Associate image upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('logo'),
                'files' => $request->allFiles(),
                'all_data' => $request->all(),
                'old_file' => $request->input('old_file'),
                'headers' => $request->headers->all(),
                'content_type' => $request->header('Content-Type'),
                'method' => $request->method(),
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
                'logo' => 'required|file|max:2048', // 2MB max
                'old_file' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                \Log::error('Validation failed', [
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
                    \Log::error('File upload error', [
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
                    \Log::error('Invalid file MIME type', [
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
                        \Log::info('Old associate image deleted', ['old_file' => $oldFile]);
                    }
                }
                
                $filename = 'associates/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Ensure the associates directory exists
                try {
                    if (!Storage::disk('public')->exists('associates')) {
                        Storage::disk('public')->makeDirectory('associates');
                        \Log::info('Created associates directory');
                    }
                    
                    // Verify directory was created and is writable
                    if (!Storage::disk('public')->exists('associates')) {
                        throw new \Exception('Failed to create associates directory');
                    }
                    
                    \Log::info('Associates directory verified', [
                        'exists' => Storage::disk('public')->exists('associates'),
                        'writable' => is_writable(storage_path('app/public/associates')),
                        'permissions' => substr(sprintf('%o', fileperms(storage_path('app/public/associates'))), -4)
                    ]);
                    
                } catch (\Exception $dirError) {
                    \Log::error('Directory creation failed', [
                        'error' => $dirError->getMessage(),
                        'storage_path' => storage_path('app/public'),
                        'associates_path' => storage_path('app/public/associates'),
                        'storage_exists' => is_dir(storage_path('app/public')),
                        'storage_writable' => is_writable(storage_path('app/public'))
                    ]);
                    throw $dirError;
                }
                
                \Log::info('Attempting to store file', [
                    'filename' => $filename,
                    'file_size' => $file->getSize(),
                    'storage_path' => storage_path('app/public'),
                    'target_path' => storage_path('app/public/' . $filename),
                    'associates_dir_exists' => Storage::disk('public')->exists('associates')
                ]);
                
                // Store the file with multiple fallback methods
                $path = null;
                $url = null;
                
                try {
                    // Method 1: Standard Laravel Storage
                    $path = Storage::disk('public')->putFileAs('', $file, $filename);
                    
                    if ($path && Storage::disk('public')->exists($filename)) {
                        $url = Storage::url($filename);
                        \Log::info('File stored using standard method', ['path' => $path, 'url' => $url]);
                    } else {
                        throw new \Exception('Standard storage method failed');
                    }
                    
                } catch (\Exception $e) {
                    \Log::warning('Standard storage failed, trying alternative method', ['error' => $e->getMessage()]);
                    
                    try {
                        // Method 2: Direct file operations
                        $targetPath = storage_path('app/public/' . $filename);
                        $targetDir = dirname($targetPath);
                        
                        if (!is_dir($targetDir)) {
                            mkdir($targetDir, 0755, true);
                        }
                        
                        if (move_uploaded_file($file->getPathname(), $targetPath)) {
                            $path = $filename;
                            $url = Storage::url($filename);
                            \Log::info('File stored using direct method', ['path' => $path, 'url' => $url]);
                        } else {
                            throw new \Exception('Direct file method failed');
                        }
                        
                    } catch (\Exception $e2) {
                        \Log::warning('Direct file method failed, trying copy method', ['error' => $e2->getMessage()]);
                        
                        try {
                            // Method 3: Copy method for cloud environments
                            $targetPath = storage_path('app/public/' . $filename);
                            $targetDir = dirname($targetPath);
                            
                            if (!is_dir($targetDir)) {
                                mkdir($targetDir, 0755, true);
                            }
                            
                            if (copy($file->getPathname(), $targetPath)) {
                                $path = $filename;
                                $url = Storage::url($filename);
                                \Log::info('File stored using copy method', ['path' => $path, 'url' => $url]);
                            } else {
                                throw new \Exception('Copy method failed');
                            }
                            
                        } catch (\Exception $e3) {
                            \Log::error('All storage methods failed', [
                                'standard_error' => $e->getMessage(),
                                'direct_error' => $e2->getMessage(),
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
                            
                            throw new \Exception('All storage methods failed: ' . $e3->getMessage());
                        }
                    }
                }
                
                // Final verification with detailed logging
                if (!$path) {
                    \Log::error('File storage failed - no path returned', [
                        'filename' => $filename,
                        'file_size' => $file->getSize(),
                        'storage_disk' => config('filesystems.default'),
                        'storage_path' => storage_path('app/public')
                    ]);
                    throw new \Exception('File storage failed - no path returned');
                }
                
                if (!Storage::disk('public')->exists($filename)) {
                    \Log::error('File storage verification failed - file not found', [
                        'filename' => $filename,
                        'path' => $path,
                        'storage_exists' => Storage::disk('public')->exists($filename),
                        'file_exists' => file_exists(storage_path('app/public/' . $filename)),
                        'storage_list' => Storage::disk('public')->files('associates'),
                        'directory_list' => Storage::disk('public')->directories('associates')
                    ]);
                    throw new \Exception('File storage verification failed - file not found in storage');
                }
                
                // Additional verification - check file size
                $storedFileSize = Storage::disk('public')->size($filename);
                if ($storedFileSize !== $file->getSize()) {
                    \Log::warning('File size mismatch after storage', [
                        'original_size' => $file->getSize(),
                        'stored_size' => $storedFileSize,
                        'filename' => $filename
                    ]);
                }
                
                \Log::info('File storage result', [
                    'path' => $path,
                    'url' => $url,
                    'file_exists' => Storage::disk('public')->exists($filename),
                    'storage_exists' => is_dir(storage_path('app/public')),
                    'associates_dir_exists' => Storage::disk('public')->exists('associates'),
                    'file_size_stored' => Storage::disk('public')->size($filename)
                ]);

                \Log::info('Associate image uploaded successfully', [
                    'filename' => $filename,
                    'url' => $url
                ]);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename,
                    'message' => 'Image uploaded successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Associate image upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload film portfolio image
     */
    public function uploadFilmPortfolioImage(Request $request)
    {
        try {
            \Log::info('Film portfolio image upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('featured_image'),
                'files' => $request->allFiles(),
                'all_data' => $request->all(),
                'old_file' => $request->input('old_file')
            ]);

            $request->validate([
                'featured_image' => 'required|file|mimes:png,svg,jpg,jpeg|max:2048', // 2MB max
                'old_file' => 'nullable|string',
            ]);

            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                
                // Check if file is valid
                if (!$file->isValid()) {
                    \Log::error('Film portfolio image upload error', [
                        'error_code' => $file->getError(),
                        'error_message' => $file->getErrorMessage(),
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'File upload error: ' . $file->getErrorMessage(),
                        'errors' => ['featured_image' => ['File upload error: ' . $file->getErrorMessage()]]
                    ], 422);
                }
                
                // Additional validation for file content
                $allowedMimes = ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'];
                $fileMime = $file->getMimeType();
                
                if (!in_array($fileMime, $allowedMimes)) {
                    \Log::error('Invalid film portfolio image MIME type', [
                        'expected' => $allowedMimes,
                        'actual' => $fileMime,
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file type. Please upload a PNG, SVG, JPG, or JPEG image.',
                        'errors' => ['featured_image' => ['Invalid file type. Please upload a PNG, SVG, JPG, or JPEG image.']]
                    ], 422);
                }
                
                // Delete old file if provided
                if ($request->filled('old_file')) {
                    $oldFile = $request->input('old_file');
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                        \Log::info('Old film portfolio image deleted', ['old_file' => $oldFile]);
                    }
                }
                
                $filename = 'film-portfolios/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Ensure the directory exists
                if (!Storage::disk('public')->exists('film-portfolios')) {
                    Storage::disk('public')->makeDirectory('film-portfolios');
                }
                
                // Use Storage::disk('public')->put() instead of storeAs
                $path = Storage::disk('public')->putFileAs('', $file, $filename);
                $url = Storage::url($filename);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename,
                    'message' => 'Image uploaded successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Film portfolio image upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload testimonial image
     */
    public function uploadTestimonialImage(Request $request)
    {
        try {
            \Log::info('Testimonial image upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('avatar'),
                'files' => $request->allFiles(),
                'all_data' => $request->all(),
                'old_file' => $request->input('old_file')
            ]);

            $request->validate([
                'avatar' => 'required|file|mimes:png,svg,jpg,jpeg|max:2048', // 2MB max
                'old_file' => 'nullable|string',
            ]);

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                
                // Check if file is valid
                if (!$file->isValid()) {
                    \Log::error('Testimonial avatar upload error', [
                        'error_code' => $file->getError(),
                        'error_message' => $file->getErrorMessage(),
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'File upload error: ' . $file->getErrorMessage(),
                        'errors' => ['avatar' => ['File upload error: ' . $file->getErrorMessage()]]
                    ], 422);
                }
                
                // Additional validation for file content
                $allowedMimes = ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'];
                $fileMime = $file->getMimeType();
                
                if (!in_array($fileMime, $allowedMimes)) {
                    \Log::error('Invalid testimonial avatar MIME type', [
                        'expected' => $allowedMimes,
                        'actual' => $fileMime,
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file type. Please upload a PNG, SVG, JPG, or JPEG image.',
                        'errors' => ['avatar' => ['Invalid file type. Please upload a PNG, SVG, JPG, or JPEG image.']]
                    ], 422);
                }
                
                // Delete old file if provided
                if ($request->filled('old_file')) {
                    $oldFile = $request->input('old_file');
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                        \Log::info('Old testimonial image deleted', ['old_file' => $oldFile]);
                    }
                }
                
                $filename = 'testimonials/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Use Storage::disk('public')->put() instead of storeAs
                $path = Storage::disk('public')->putFileAs('', $file, $filename);
                $url = Storage::url($filename);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $filename,
                    'message' => 'Image uploaded successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Testimonial image upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload general logo
     */
    public function uploadGeneralLogo(Request $request)
    {
        try {
            \Log::info('General logo upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('logo'),
                'files' => $request->allFiles(),
                'all_data' => $request->all(),
                'old_file' => $request->input('old_file'),
                'headers' => $request->headers->all(),
            ]);

            $validator = \Validator::make($request->all(), [
                'logo' => 'required|file|mimes:png,svg,jpg,jpeg|max:2048',
            ]);

            if ($validator->fails()) {
                \Log::error('General logo validation failed', [
                    'errors' => $validator->errors(),
                    'request_data' => $request->all()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all()),
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                
                if (!$file->isValid()) {
                    \Log::error('General logo file is not valid');
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file'
                    ], 400);
                }

                // Validate MIME type
                $allowedMimes = ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'];
                $fileMime = $file->getMimeType();
                
                if (!in_array($fileMime, $allowedMimes)) {
                    \Log::error('General logo invalid MIME type', ['mime' => $fileMime]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file type. Only PNG, SVG, JPG, and JPEG files are allowed.'
                    ], 400);
                }

                // Delete old file if provided
                if ($request->has('old_file') && $request->old_file) {
                    $oldFilePath = str_replace('/storage/', '', $request->old_file);
                    if (Storage::disk('public')->exists($oldFilePath)) {
                        Storage::disk('public')->delete($oldFilePath);
                        \Log::info('Old general logo deleted', ['path' => $oldFilePath]);
                    }
                }

                $filename = 'general/' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Ensure the directory exists
                if (!Storage::disk('public')->exists('general')) {
                    Storage::disk('public')->makeDirectory('general');
                }
                
                $stored = Storage::disk('public')->putFileAs('', $file, $filename);
                
                \Log::info('General logo storage result', [
                    'filename' => $filename,
                    'stored' => $stored,
                    'file_exists' => file_exists(storage_path('app/public/' . $filename)),
                ]);

                if ($stored) {
                    $url = Storage::url($filename);
                    \Log::info('General logo uploaded successfully', [
                        'url' => $url,
                        'filename' => $filename
                    ]);

                    return response()->json([
                        'success' => true,
                        'url' => $url,
                        'filename' => $filename,
                        'message' => 'Logo uploaded successfully'
                    ]);
                } else {
                    \Log::error('Failed to store general logo');
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to store file'
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('General logo upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload general favicon
     */
    public function uploadGeneralFavicon(Request $request)
    {
        try {
            \Log::info('General favicon upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('favicon'),
                'files' => $request->allFiles(),
                'all_data' => $request->all(),
                'old_file' => $request->input('old_file'),
                'headers' => $request->headers->all(),
            ]);

            $validator = \Validator::make($request->all(), [
                'favicon' => 'required|file|mimes:png,svg,ico|max:2048',
            ]);

            if ($validator->fails()) {
                \Log::error('General favicon validation failed', [
                    'errors' => $validator->errors(),
                    'request_data' => $request->all()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all()),
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->hasFile('favicon')) {
                $file = $request->file('favicon');
                
                if (!$file->isValid()) {
                    \Log::error('General favicon file is not valid');
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file'
                    ], 400);
                }

                // Validate MIME type
                $allowedMimes = ['image/png', 'image/svg+xml', 'image/x-icon'];
                $fileMime = $file->getMimeType();
                
                if (!in_array($fileMime, $allowedMimes)) {
                    \Log::error('General favicon invalid MIME type', ['mime' => $fileMime]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file type. Only PNG, SVG, and ICO files are allowed.'
                    ], 400);
                }

                // Delete old file if provided
                if ($request->has('old_file') && $request->old_file) {
                    $oldFilePath = str_replace('/storage/', '', $request->old_file);
                    if (Storage::disk('public')->exists($oldFilePath)) {
                        Storage::disk('public')->delete($oldFilePath);
                        \Log::info('Old general favicon deleted', ['path' => $oldFilePath]);
                    }
                }

                $filename = 'general/' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Ensure the directory exists
                if (!Storage::disk('public')->exists('general')) {
                    Storage::disk('public')->makeDirectory('general');
                }
                
                $stored = Storage::disk('public')->putFileAs('', $file, $filename);
                
                \Log::info('General favicon storage result', [
                    'filename' => $filename,
                    'stored' => $stored,
                    'file_exists' => file_exists(storage_path('app/public/' . $filename)),
                ]);

                if ($stored) {
                    $url = Storage::url($filename);
                    \Log::info('General favicon uploaded successfully', [
                        'url' => $url,
                        'filename' => $filename
                    ]);

                    return response()->json([
                        'success' => true,
                        'url' => $url,
                        'filename' => $filename,
                        'message' => 'Favicon uploaded successfully'
                    ]);
                } else {
                    \Log::error('Failed to store general favicon');
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to store file'
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('General favicon upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload news featured image via FilePond
     */
    public function uploadNewsFeaturedImage(Request $request)
    {
        try {
            \Log::info('News featured image upload request received', [
                'user_id' => auth()->id(),
                'has_file' => $request->hasFile('featured_image'),
                'files' => $request->allFiles(),
                'all_data' => $request->all(),
                'old_file' => $request->input('old_file'),
                'headers' => $request->headers->all(),
            ]);

            $validator = \Validator::make($request->all(), [
                'featured_image' => 'required|file|mimes:png,svg,jpg,jpeg|max:2048',
            ]);

            if ($validator->fails()) {
                \Log::error('News featured image validation failed', [
                    'errors' => $validator->errors(),
                    'request_data' => $request->all()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all()),
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                
                if (!$file->isValid()) {
                    \Log::error('News featured image file is not valid');
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file'
                    ], 400);
                }

                // Validate MIME type
                $allowedMimes = ['image/png', 'image/svg+xml', 'image/jpeg', 'image/jpg'];
                $fileMime = $file->getMimeType();
                
                if (!in_array($fileMime, $allowedMimes)) {
                    \Log::error('News featured image invalid MIME type', ['mime' => $fileMime]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file type. Only PNG, SVG, JPG, and JPEG files are allowed.'
                    ], 400);
                }

                // Delete old file if provided
                if ($request->has('old_file') && $request->old_file) {
                    $oldFilePath = str_replace('/storage/', '', $request->old_file);
                    if (Storage::disk('public')->exists($oldFilePath)) {
                        Storage::disk('public')->delete($oldFilePath);
                        \Log::info('Old news featured image deleted', ['path' => $oldFilePath]);
                    }
                }

                $filename = 'news/' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Ensure the directory exists
                if (!Storage::disk('public')->exists('news')) {
                    Storage::disk('public')->makeDirectory('news');
                }
                
                $stored = Storage::disk('public')->putFileAs('', $file, $filename);
                
                \Log::info('News featured image storage result', [
                    'filename' => $filename,
                    'stored' => $stored,
                    'file_exists' => file_exists(storage_path('app/public/' . $filename)),
                ]);

                if ($stored) {
                    $url = Storage::url($filename);
                    \Log::info('News featured image uploaded successfully', [
                        'url' => $url,
                        'filename' => $filename
                    ]);

                    return response()->json([
                        'success' => true,
                        'url' => $url,
                        'filename' => $filename,
                        'message' => 'Featured image uploaded successfully'
                    ]);
                } else {
                    \Log::error('Failed to store news featured image');
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to store file'
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            \Log::error('News featured image upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}