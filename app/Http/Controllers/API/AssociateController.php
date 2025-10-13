<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Associate;
use Illuminate\Http\Request;

class AssociateController extends Controller
{
    /**
     * Get all active associates
     */
    public function index()
    {
        $associates = Associate::active()->ordered()->get();

        // Transform the data to include proper logo URLs
        $transformedAssociates = $associates->map(function ($associate) {
            return [
                'id' => $associate->id,
                'name' => $associate->name,
                'logo' => $associate->frontend_logo_url,
                'website' => $associate->website,
                'is_active' => $associate->is_active,
                'sort_order' => $associate->sort_order,
                'updated_at' => $associate->updated_at->timestamp, // Add timestamp for cache busting
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $transformedAssociates
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', '0');
    }

    /**
     * Get associates by type
     */
    public function getByType($type)
    {
        $associates = Associate::active()->ordered()->get();

        // Transform the data to include proper logo URLs
        $transformedAssociates = $associates->map(function ($associate) {
            return [
                'id' => $associate->id,
                'name' => $associate->name,
                'logo' => $associate->frontend_logo_url,
                'website' => $associate->website,
                'is_active' => $associate->is_active,
                'sort_order' => $associate->sort_order,
                'updated_at' => $associate->updated_at->timestamp, // Add timestamp for cache busting
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $transformedAssociates
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', '0');
    }

}
