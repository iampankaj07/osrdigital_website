<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * Upload image for associates
     */
    public function uploadAssociateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'associates/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            $path = $file->storeAs('public', $filename);
            $url = Storage::url($filename);

            return response()->json([
                'success' => true,
                'url' => $url,
                'filename' => $filename
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image uploaded'
        ], 400);
    }

    /**
     * Delete uploaded image
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'filename' => 'required|string'
        ]);

        $filename = $request->filename;
        
        if (Storage::exists('public/' . $filename)) {
            Storage::delete('public/' . $filename);
            
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image not found'
        ], 404);
    }
}
