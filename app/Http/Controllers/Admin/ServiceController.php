<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        return view('admin.services.index');
    }

}