<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        //redirect to view index
        return view('admin.team-members.index');
    }


}