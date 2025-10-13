<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FilmPortfolio;
use App\Models\FilmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilmPortfolioController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //redirect to view index
        return view('admin.film-portfolios.index');
    }

}
