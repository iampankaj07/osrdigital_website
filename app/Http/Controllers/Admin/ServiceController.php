<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        $services = Service::ordered()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Service create request:', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'short_description' => 'nullable|string|max:500',
                'icon' => 'required|string|max:50',
                'sort_order' => 'nullable|integer|min:0',
                'is_featured' => 'nullable',
                'is_active' => 'nullable',
            ]);

            $service = new Service();
            $service->fill($request->all());
            $service->slug = Str::slug($request->title);
            $service->is_featured = $request->has('is_featured');
            $service->is_active = $request->has('is_active');
            $service->sort_order = $request->input('sort_order', 0);
            $service->save();

            \Log::info('Service created successfully', ['id' => $service->id]);

            return redirect()->route('admin.services.index')->with('success', 'Service created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating Service:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create Service: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        try {
            \Log::info('Service update request:', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'short_description' => 'nullable|string|max:500',
                'icon' => 'required|string|max:50',
                'sort_order' => 'nullable|integer|min:0',
                'is_featured' => 'nullable',
                'is_active' => 'nullable',
            ]);

            $service->fill($request->all());
            $service->slug = Str::slug($request->title);
            $service->is_featured = $request->has('is_featured');
            $service->is_active = $request->has('is_active');
            $service->sort_order = $request->input('sort_order', 0);
            $service->save();

            \Log::info('Service updated successfully', ['id' => $service->id]);

            return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating Service:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Service: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Service $service)
    {
        try {
            $service->delete();
            \Log::info('Service deleted successfully', ['id' => $service->id]);
            return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Service:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to delete Service: ' . $e->getMessage());
        }
    }

    public function toggleFeatured(Service $service)
    {
        try {
            $service->is_featured = !$service->is_featured;
            $service->save();
            
            $status = $service->is_featured ? 'featured' : 'unfeatured';
            \Log::info("Service {$status} successfully", ['id' => $service->id]);
            
            return redirect()->back()->with('success', "Service {$status} successfully!");
        } catch (\Exception $e) {
            \Log::error('Error toggling Service featured status:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Service featured status: ' . $e->getMessage());
        }
    }

    public function toggleActive(Service $service)
    {
        try {
            $service->is_active = !$service->is_active;
            $service->save();
            
            $status = $service->is_active ? 'activated' : 'deactivated';
            \Log::info("Service {$status} successfully", ['id' => $service->id]);
            
            return redirect()->back()->with('success', "Service {$status} successfully!");
        } catch (\Exception $e) {
            \Log::error('Error toggling Service status:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Service status: ' . $e->getMessage());
        }
    }
}