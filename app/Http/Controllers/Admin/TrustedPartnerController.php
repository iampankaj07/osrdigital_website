<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrustedPartner;
use Illuminate\Http\Request;

class TrustedPartnerController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        //redirect to view index
        return view('admin.trusted-partners.index');
    }

}