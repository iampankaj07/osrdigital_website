<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributionService;
use Illuminate\Http\Request;

class DistributionServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //redirect to view index
        return view('admin.distribution-services.index');
    }

}
