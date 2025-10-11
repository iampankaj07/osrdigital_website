<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class MediaController extends Controller
{
    /**
     * Display a listing of the media library
     */
    public function index(Request $request): View
    {
        $query = Media::with('uploader')->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            if ($request->type === 'images') {
                $query->images();
            } elseif ($request->type === 'documents') {
                $query->documents();
            }
        }

        // Filter by search term
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by user
        if ($request->filled('user')) {
            $query->byUser($request->user);
        }

        $media = $query->paginate(24);

        // Get categories for filter
        $categories = Media::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        // Get users for filter
        $users = Media::with('uploader')
            ->get()
            ->pluck('uploader.name', 'uploaded_by')
            ->filter()
            ->sort()
            ->unique();

        return view('admin.media.index', compact('media', 'categories', 'users'));
    }

    /**
     * Show the form for creating a new media item
     */
    public function create(): View
    {
        return view('admin.media.create');
    }

    /**
     * Store a newly uploaded media file
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240', // 10MB max
            'category' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $mimeType = $file->getMimeType();
            $size = $file->getSize();

            // Generate unique filename
            $filename = Str::uuid() . '.' . $extension;
            $path = 'media/' . $filename;

            // Store the file
            $storedPath = Storage::disk('public')->putFileAs('media', $file, $filename);
            
            if (!$storedPath) {
                throw new \Exception('Failed to store file');
            }

            // Get image dimensions if it's an image
            $width = null;
            $height = null;
            if (str_starts_with($mimeType, 'image/')) {
                $imageInfo = getimagesize($file->getPathname());
                if ($imageInfo) {
                    $width = $imageInfo[0];
                    $height = $imageInfo[1];
                }
            }

            // Create media record
            $media = Media::create([
                'name' => $originalName,
                'filename' => $filename,
                'path' => $storedPath,
                'url' => Storage::disk('public')->url($storedPath),
                'mime_type' => $mimeType,
                'extension' => $extension,
                'size' => $size,
                'width' => $width,
                'height' => $height,
                'alt_text' => $request->alt_text,
                'description' => $request->description,
                'category' => $request->category,
                'is_public' => $request->boolean('is_public', true),
                'uploaded_by' => auth()->id(),
                'metadata' => [
                    'original_name' => $originalName,
                    'uploaded_at' => now()->toISOString(),
                    'user_agent' => $request->userAgent(),
                ],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Media uploaded successfully',
                'media' => $media->load('uploader'),
                'url' => $media->public_url,
                'thumbnail_url' => $media->thumbnail_url,
            ]);

        } catch (\Exception $e) {
            \Log::error('Media upload failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'file_name' => $originalName ?? 'unknown',
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified media item
     */
    public function show(Media $media): View
    {
        $media->load('uploader');
        return view('admin.media.show', compact('media'));
    }

    /**
     * Show the form for editing the specified media item
     */
    public function edit(Media $media): View
    {
        return view('admin.media.edit', compact('media'));
    }

    /**
     * Update the specified media item
     */
    public function update(Request $request, Media $media): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:255',
            'is_public' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $media->update([
                'alt_text' => $request->alt_text,
                'description' => $request->description,
                'category' => $request->category,
                'is_public' => $request->boolean('is_public', $media->is_public),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Media updated successfully',
                'media' => $media->fresh()->load('uploader'),
            ]);

        } catch (\Exception $e) {
            \Log::error('Media update failed: ' . $e->getMessage(), [
                'media_id' => $media->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified media item
     */
    public function destroy(Media $media): JsonResponse
    {
        try {
            // Delete the file from storage
            if (Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }

            // Delete the database record
            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Media deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Media deletion failed: ' . $e->getMessage(), [
                'media_id' => $media->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete multiple media items
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:media,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $mediaItems = Media::whereIn('id', $request->ids)->get();
            $deletedCount = 0;

            foreach ($mediaItems as $media) {
                // Delete the file from storage
                if (Storage::disk('public')->exists($media->path)) {
                    Storage::disk('public')->delete($media->path);
                }
                $media->delete();
                $deletedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} media items"
            ]);

        } catch (\Exception $e) {
            \Log::error('Bulk media deletion failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'ids' => $request->ids,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Bulk deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get media for API/select components
     */
    public function api(Request $request): JsonResponse
    {
        $query = Media::public()->latest();

        // Filter by type
        if ($request->filled('type')) {
            if ($request->type === 'images') {
                $query->images();
            } elseif ($request->type === 'documents') {
                $query->documents();
            }
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%");
            });
        }

        $media = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $media->items(),
            'pagination' => [
                'current_page' => $media->currentPage(),
                'last_page' => $media->lastPage(),
                'per_page' => $media->perPage(),
                'total' => $media->total(),
            ]
        ]);
    }
}
