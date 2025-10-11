<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributionService;
use Illuminate\Http\Request;

class DistributionServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = DistributionService::ordered()->get();
        return view('admin.distribution-services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.distribution-services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'icon_type' => 'required|in:svg,font-awesome,image',
            'icon_data' => 'required|string',
            'link' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        DistributionService::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon_type' => $request->icon_type,
            'icon_data' => $request->icon_data,
            'link' => $request->link ?? '/business',
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.distribution-services.index')
            ->with('success', 'Distribution service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DistributionService $distributionService)
    {
        return view('admin.distribution-services.show', compact('distributionService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DistributionService $distributionService)
    {
        return view('admin.distribution-services.edit', compact('distributionService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DistributionService $distributionService)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'icon_type' => 'required|in:svg,font-awesome,image',
            'icon_data' => 'required|string',
            'link' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $distributionService->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon_type' => $request->icon_type,
            'icon_data' => $request->icon_data,
            'link' => $request->link ?? '/business',
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.distribution-services.index')
            ->with('success', 'Distribution service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DistributionService $distributionService)
    {
        $distributionService->delete();

        return redirect()->route('admin.distribution-services.index')
            ->with('success', 'Distribution service deleted successfully!');
    }

    /**
     * Toggle the active status of the specified resource.
     */
    public function toggleActive(DistributionService $distributionService)
    {
        $distributionService->update([
            'is_active' => !$distributionService->is_active
        ]);

        $status = $distributionService->is_active ? 'activated' : 'deactivated';
        
        return response()->json([
            'success' => true,
            'message' => "Distribution service {$status} successfully!",
            'is_active' => $distributionService->is_active
        ]);
    }
}
