<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     * Redirects to Livewire component for better user experience.
     */
    public function index()
    {
        //redirect to view index
        return view('admin.hero-sections.index');
    }

}