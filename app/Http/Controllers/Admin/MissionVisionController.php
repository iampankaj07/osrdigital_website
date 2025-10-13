<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MissionVision;
use Illuminate\Http\Request;

class MissionVisionController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        return view('admin.mission-vision.index');
    }

}