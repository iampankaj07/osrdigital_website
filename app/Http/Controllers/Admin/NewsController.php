<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.news.index');
    }

}
