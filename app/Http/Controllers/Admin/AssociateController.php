<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Associate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssociateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //redirect to view index
        return view('admin.associates.index');
    }

}
