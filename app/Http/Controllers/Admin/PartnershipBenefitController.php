<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnershipBenefit;
use Illuminate\Http\Request;

class PartnershipBenefitController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        //redirect to view index
        return view('admin.partnership-benefits.index');
    }

    public function create()
    {
        return view('admin.partnership-benefits.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Partnership Benefit create request:', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'icon' => 'required|string|max:50',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $benefit = new PartnershipBenefit();
            $benefit->fill($request->all());
            $benefit->is_active = $request->has('is_active');
            $benefit->sort_order = $request->input('sort_order', 0);
            $benefit->save();

            \Log::info('Partnership Benefit created successfully', ['id' => $benefit->id]);

            return redirect()->route('admin.partnership-benefits.index')->with('success', 'Partnership Benefit created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating Partnership Benefit:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create Partnership Benefit: ' . $e->getMessage())->withInput();
        }
    }

    public function show(PartnershipBenefit $partnershipBenefit)
    {
        return view('admin.partnership-benefits.show', compact('partnershipBenefit'));
    }

    public function edit(PartnershipBenefit $partnershipBenefit)
    {
        return view('admin.partnership-benefits.edit', compact('partnershipBenefit'));
    }

    public function update(Request $request, PartnershipBenefit $partnershipBenefit)
    {
        try {
            \Log::info('Partnership Benefit update request:', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'icon' => 'required|string|max:50',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $partnershipBenefit->fill($request->all());
            $partnershipBenefit->is_active = $request->has('is_active');
            $partnershipBenefit->sort_order = $request->input('sort_order', 0);
            $partnershipBenefit->save();

            \Log::info('Partnership Benefit updated successfully', ['id' => $partnershipBenefit->id]);

            return redirect()->route('admin.partnership-benefits.index')->with('success', 'Partnership Benefit updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating Partnership Benefit:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Partnership Benefit: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(PartnershipBenefit $partnershipBenefit)
    {
        try {
            $partnershipBenefit->delete();
            \Log::info('Partnership Benefit deleted successfully', ['id' => $partnershipBenefit->id]);
            return redirect()->route('admin.partnership-benefits.index')->with('success', 'Partnership Benefit deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Partnership Benefit:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to delete Partnership Benefit: ' . $e->getMessage());
        }
    }

    public function toggleActive(PartnershipBenefit $partnershipBenefit)
    {
        try {
            $partnershipBenefit->is_active = !$partnershipBenefit->is_active;
            $partnershipBenefit->save();
            
            $status = $partnershipBenefit->is_active ? 'activated' : 'deactivated';
            \Log::info("Partnership Benefit {$status} successfully", ['id' => $partnershipBenefit->id]);
            
            return redirect()->back()->with('success', "Partnership Benefit {$status} successfully!");
        } catch (\Exception $e) {
            \Log::error('Error toggling Partnership Benefit status:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Partnership Benefit status: ' . $e->getMessage());
        }
    }
}