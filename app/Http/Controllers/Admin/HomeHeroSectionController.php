<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\Admin\HomeHeroSection\Index;
use Illuminate\Http\Request;

class HomeHeroSectionController extends Controller
{
    public function index()
    {
        return view('admin.hero-section.index');
    }
}
