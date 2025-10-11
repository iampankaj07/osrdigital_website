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
        $associates = Associate::ordered()->get();
        return view('admin.associates.index', compact('associates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.associates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $associate = Associate::create($request->all());

        return redirect()->route('admin.associates.index')
            ->with('success', 'Associate created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Associate $associate)
    {
        return view('admin.associates.show', compact('associate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Associate $associate)
    {
        return view('admin.associates.edit', compact('associate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Associate $associate)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $associate->update($request->all());

        return redirect()->route('admin.associates.index')
            ->with('success', 'Associate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Associate $associate)
    {
        $associate->delete();

        return redirect()->route('admin.associates.index')
            ->with('success', 'Associate deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Associate $associate)
    {
        $associate->update(['is_active' => !$associate->is_active]);
        
        return redirect()->back()
            ->with('success', 'Associate status updated successfully.');
    }
}
