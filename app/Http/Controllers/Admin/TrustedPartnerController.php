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
        $partners = TrustedPartner::ordered()->get();
        return view('admin.trusted-partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.trusted-partners.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Trusted Partner create request:', $request->all());
            
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'logo' => 'nullable|string|max:255',
                'website_url' => 'nullable|url|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $partner = new TrustedPartner();
            $partner->fill($request->all());
            $partner->is_active = $request->has('is_active');
            $partner->sort_order = $request->input('sort_order', 0);
            $partner->save();

            \Log::info('Trusted Partner created successfully', ['id' => $partner->id]);

            return redirect()->route('admin.trusted-partners.index')->with('success', 'Trusted Partner created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating Trusted Partner:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create Trusted Partner: ' . $e->getMessage())->withInput();
        }
    }

    public function show(TrustedPartner $trustedPartner)
    {
        return view('admin.trusted-partners.show', compact('trustedPartner'));
    }

    public function edit(TrustedPartner $trustedPartner)
    {
        return view('admin.trusted-partners.edit', compact('trustedPartner'));
    }

    public function update(Request $request, TrustedPartner $trustedPartner)
    {
        try {
            \Log::info('Trusted Partner update request:', $request->all());
            
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'logo' => 'nullable|string|max:255',
                'website_url' => 'nullable|url|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'nullable',
            ]);

            $trustedPartner->fill($request->all());
            $trustedPartner->is_active = $request->has('is_active');
            $trustedPartner->sort_order = $request->input('sort_order', 0);
            $trustedPartner->save();

            \Log::info('Trusted Partner updated successfully', ['id' => $trustedPartner->id]);

            return redirect()->route('admin.trusted-partners.index')->with('success', 'Trusted Partner updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating Trusted Partner:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Trusted Partner: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(TrustedPartner $trustedPartner)
    {
        try {
            $trustedPartner->delete();
            \Log::info('Trusted Partner deleted successfully', ['id' => $trustedPartner->id]);
            return redirect()->route('admin.trusted-partners.index')->with('success', 'Trusted Partner deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Trusted Partner:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to delete Trusted Partner: ' . $e->getMessage());
        }
    }

    public function toggleActive(TrustedPartner $trustedPartner)
    {
        try {
            $trustedPartner->is_active = !$trustedPartner->is_active;
            $trustedPartner->save();
            
            $status = $trustedPartner->is_active ? 'activated' : 'deactivated';
            \Log::info("Trusted Partner {$status} successfully", ['id' => $trustedPartner->id]);
            
            return redirect()->back()->with('success', "Trusted Partner {$status} successfully!");
        } catch (\Exception $e) {
            \Log::error('Error toggling Trusted Partner status:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update Trusted Partner status: ' . $e->getMessage());
        }
    }
}