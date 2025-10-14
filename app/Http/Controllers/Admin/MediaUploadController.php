<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Authentication required'
            ], 401);
        }

        $request->validate([
            'filepond' => 'required|file|max:10240', // 10MB max
        ]);

        try {
            $user = Auth::user();
            $file = $request->file('filepond');

            // Add media to user using spatie/laravel-medialibrary
            $media = $user->addMediaFromRequest('filepond')
                ->usingName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection('media-library');

            // Return the server ID for FilePond to track
            return response()->json([
                'success' => true,
                'serverId' => $media->id,
                'url' => $media->getFullUrl()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function revert(Request $request)
    {
        try {
            $mediaId = $request->getContent();

            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId);
            if ($media) {
                $media->delete();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function load(Request $request, $id)
    {
        try {
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($id);

            if (!$media) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $path = $media->getPath();
            if (!Storage::disk($media->disk)->exists($path)) {
                return response()->json(['error' => 'File not found on disk'], 404);
            }

            return response()->file(Storage::disk($media->disk)->path($path), [
                'Content-Type' => $media->mime_type,
                'Content-Disposition' => 'inline; filename="' . $media->file_name . '"'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function api(Request $request)
    {
        try {
            // Fetch all media files, ordered by most recent first
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('collection_name', 'media-library')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'file_name' => $item->file_name,
                        'mime_type' => $item->mime_type,
                        'size' => $item->size,
                        'original_url' => $item->getFullUrl(),
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                    ];
                });

            return response()->json([
                'success' => true,
                'media' => $media
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
