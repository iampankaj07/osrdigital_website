<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    protected $middleware = ['auth', 'admin'];



    public function index()
    {
        //redirect to view index
        return view('admin.testimonials.index');
    }

}
