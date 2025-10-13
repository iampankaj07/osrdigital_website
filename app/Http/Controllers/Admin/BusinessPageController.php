<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BusinessPageController extends Controller
{
    public function index()
    {
        return view('admin.business-pages.index');
    }
}
