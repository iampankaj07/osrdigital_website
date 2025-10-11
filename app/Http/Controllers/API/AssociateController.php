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

        return response()->json([
            'success' => true,
            'data' => $associates
        ]);
    }

}
