<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoreValue;
use Illuminate\Http\Request;

class CoreValueController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        $coreValues = CoreValue::ordered()->get();
        return view('admin.core-values.index', compact('coreValues'));
    }

    public function create()
    {
        return view('admin.core-values.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Core Value create request:', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'icon' => 'required|string|max:50',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $coreValue = new CoreValue();
            $coreValue->fill($request->all());
            $coreValue->is_active = $request->has('is_active');
            $coreValue->sort_order = $request->input('sort_order', 0);
            $coreValue->save();

            \Log::info('Core Value created successfully', ['id' => $coreValue->id]);

            return redirect()->route('admin.core-values.index')->with('success', 'Core Value created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating Core Value:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create Core Value: ' . $e->getMessage())->withInput();
        }
    }

    public function show(CoreValue $coreValue)
    {
        return view('admin.core-values.show', compact('coreValue'));
    }

    public function edit(CoreValue $coreValue)
    {
        return view('admin.core-values.edit', compact('coreValue'));
    }

    public function update(Request $request, CoreValue $coreValue)
    {
        try {
            \Log::info('Core Value update request:', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'icon' => 'required|string|max:50',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $coreValue->fill($request->all());
            $coreValue->is_active = $request->has('is_active');
            $coreValue->sort_order = $request->input('sort_order', 0);
            $coreValue->save();

            \Log::info('Core Value updated successfully', ['id' => $coreValue->id]);

            return redirect()->route('admin.core-values.index')->with('success', 'Core Value updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating Core Value:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Core Value: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(CoreValue $coreValue)
    {
        try {
            $coreValue->delete();
            \Log::info('Core Value deleted successfully', ['id' => $coreValue->id]);
            return redirect()->route('admin.core-values.index')->with('success', 'Core Value deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Core Value:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to delete Core Value: ' . $e->getMessage());
        }
    }

    public function toggleActive(CoreValue $coreValue)
    {
        try {
            $coreValue->is_active = !$coreValue->is_active;
            $coreValue->save();
            
            $status = $coreValue->is_active ? 'activated' : 'deactivated';
            \Log::info("Core Value {$status} successfully", ['id' => $coreValue->id]);
            
            return redirect()->back()->with('success', "Core Value {$status} successfully!");
        } catch (\Exception $e) {
            \Log::error('Error toggling Core Value status:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Core Value status: ' . $e->getMessage());
        }
    }
}