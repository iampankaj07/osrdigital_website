<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSettings;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        $footer = FooterSettings::getActive();
        return view('admin.footer.index', compact('footer'));
    }

    public function create()
    {
        return view('admin.footer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
            'copyright_text' => 'nullable|string',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|in:facebook,twitter,linkedin,instagram,youtube',
            'social_links.*.url' => 'required_with:social_links|url|max:500',
            'quick_links' => 'nullable|array',
            'quick_links.*.title' => 'required_with:quick_links|string|max:255',
            'quick_links.*.url' => 'required_with:quick_links|string|max:500|regex:/^(\/|https?:\/\/)/',
            'contact_info' => 'nullable|array',
            'newsletter_title' => 'nullable|string|max:255',
            'newsletter_description' => 'nullable|string',
            'newsletter_button_text' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        FooterSettings::create([
            'company_name' => $request->company_name,
            'company_description' => $request->company_description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $request->logo,
            'copyright_text' => $request->copyright_text,
            'social_links' => $request->social_links ?? [],
            'quick_links' => $request->quick_links ?? [],
            'contact_info' => $request->contact_info ?? [],
            'newsletter_title' => $request->newsletter_title,
            'newsletter_description' => $request->newsletter_description,
            'newsletter_button_text' => $request->newsletter_button_text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.footer')->with('success', 'Footer settings created successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
            'copyright_text' => 'nullable|string',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|in:facebook,twitter,linkedin,instagram,youtube',
            'social_links.*.url' => 'required_with:social_links|url|max:500',
            'quick_links' => 'nullable|array',
            'quick_links.*.title' => 'required_with:quick_links|string|max:255',
            'quick_links.*.url' => 'required_with:quick_links|string|max:500|regex:/^(\/|https?:\/\/)/',
            'contact_info' => 'nullable|array',
            'newsletter_title' => 'nullable|string|max:255',
            'newsletter_description' => 'nullable|string',
            'newsletter_button_text' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $footer = FooterSettings::getActive();
        
        $footer->update([
            'company_name' => $request->company_name,
            'company_description' => $request->company_description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $request->logo,
            'copyright_text' => $request->copyright_text,
            'social_links' => $request->social_links ?? [],
            'quick_links' => $request->quick_links ?? [],
            'contact_info' => $request->contact_info ?? [],
            'newsletter_title' => $request->newsletter_title,
            'newsletter_description' => $request->newsletter_description,
            'newsletter_button_text' => $request->newsletter_button_text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.footer')->with('success', 'Footer settings updated successfully!');
    }

    public function updateById(Request $request, $id)
    {
        $footer = FooterSettings::findOrFail($id);
        
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
            'copyright_text' => 'nullable|string',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|in:facebook,twitter,linkedin,instagram,youtube',
            'social_links.*.url' => 'required_with:social_links|url|max:500',
            'quick_links' => 'nullable|array',
            'quick_links.*.title' => 'required_with:quick_links|string|max:255',
            'quick_links.*.url' => 'required_with:quick_links|string|max:500|regex:/^(\/|https?:\/\/)/',
            'contact_info' => 'nullable|array',
            'newsletter_title' => 'nullable|string|max:255',
            'newsletter_description' => 'nullable|string',
            'newsletter_button_text' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);
        
        $footer->update([
            'company_name' => $request->company_name,
            'company_description' => $request->company_description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $request->logo,
            'copyright_text' => $request->copyright_text,
            'social_links' => $request->social_links ?? [],
            'quick_links' => $request->quick_links ?? [],
            'contact_info' => $request->contact_info ?? [],
            'newsletter_title' => $request->newsletter_title,
            'newsletter_description' => $request->newsletter_description,
            'newsletter_button_text' => $request->newsletter_button_text,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.footer')->with('success', 'Footer settings updated successfully!');
    }

    public function destroy($id)
    {
        $footer = FooterSettings::findOrFail($id);
        $footer->delete();

        return redirect()->route('admin.footer')->with('success', 'Footer settings deleted successfully!');
    }
}
