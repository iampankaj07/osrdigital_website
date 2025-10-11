<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DistributionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DistributionServiceController extends Controller
{
    /**
     * Get all active distribution services
     */
    public function index()
    {
        $services = Cache::remember('distribution_services', 3600, function () {
            return DistributionService::active()->ordered()->get();
        });

        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    /**
     * Get a specific distribution service
     */
    public function show(DistributionService $distributionService)
    {
        return response()->json([
            'success' => true,
            'data' => $distributionService
        ]);
    }
}
