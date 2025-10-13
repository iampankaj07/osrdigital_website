<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GlobalImpactController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display the Global Impact settings form
     */
    public function index()
    {
        return view('admin.global-impact.index');
    }

}
