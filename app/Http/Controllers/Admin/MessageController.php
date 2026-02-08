<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        return view('admin.messages.index');
    }

    public function create()
    {
        // Return same view; the Livewire component will open create form
        return view('admin.messages.index', ['create' => true]);
    }

    public function edit($id)
    {
        // Return same view; the Livewire component will open edit form for $id
        return view('admin.messages.index', ['editId' => $id]);
    }
}
