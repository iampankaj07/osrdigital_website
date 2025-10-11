<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    protected $middleware = ['auth', 'admin'];

    public function index()
    {
        // Get footer settings
        $footer = \App\Models\FooterSettings::first();
        
        // Get general settings and convert to simple array
        $generalSettings = AdminSettings::where('group', 'general')->get();
        $general = $generalSettings->pluck('value', 'key')->toArray();
        
        return view('admin.settings.index', compact('footer', 'general'));
    }


    public function updateFooter(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'company_description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string',
            'social_links.*.url' => 'required_with:social_links|url',
            'quick_links' => 'nullable|array',
            'quick_links.*.title' => 'required_with:quick_links|string',
            'quick_links.*.url' => 'required_with:quick_links|string',
            'copyright_text' => 'nullable|string',
        ]);

        $footer = \App\Models\FooterSettings::firstOrNew();
        $footer->fill($request->all());
        $footer->save();

        return redirect()->route('admin.settings')->with('success', 'Footer settings updated successfully!');
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'primary_email' => 'required|email|max:255',
            'support_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'toll_free' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'office_locations' => 'nullable|array',
            'office_locations.*.name' => 'required_with:office_locations|string',
            'office_locations.*.address' => 'required_with:office_locations|string',
            'office_locations.*.phone' => 'nullable|string',
            'general_contact_email' => 'nullable|email|max:255',
            'sales_email' => 'nullable|email|max:255',
            'press_email' => 'nullable|email|max:255',
            'careers_email' => 'nullable|email|max:255',
            'emergency_phone' => 'nullable|string|max:255',
            'emergency_email' => 'nullable|email|max:255',
            'emergency_instructions' => 'nullable|string',
        ]);

        // Store contact settings in AdminSettings
        $contactData = $request->except(['_token', '_method']);
        
        AdminSettings::updateOrCreate(
            ['key' => 'contact_settings'],
            [
                'value' => $contactData,
                'type' => 'json',
                'group' => 'contact',
                'description' => 'Contact information settings',
                'is_public' => true,
            ]
        );

        return redirect()->route('admin.settings')->with('success', 'Contact settings updated successfully!');
    }

    public function updateGeneral(Request $request)
    {
        \Log::info('General settings update request received', [
            'user_id' => auth()->id(),
            'has_logo' => $request->hasFile('logo'),
            'has_favicon' => $request->hasFile('favicon'),
            'all_files' => $request->allFiles(),
            'all_data' => $request->except(['_token', '_method'])
        ]);

        $request->validate([
            'site_title' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:png,svg,jpg,jpeg|max:5120',
            'favicon' => 'nullable|image|mimes:png,svg,ico|max:1024',
            'logo_path' => 'nullable|string',
            'favicon_path' => 'nullable|string',
            'remove_logo' => 'nullable|boolean',
            'remove_favicon' => 'nullable|boolean',
        ]);

        // Update site information
        AdminSettings::updateOrCreate(
            ['key' => 'site_title', 'group' => 'general'],
            [
                'value' => $request->site_title ?: '',
                'type' => 'string',
                'description' => 'Website title',
                'is_public' => true,
            ]
        );

        AdminSettings::updateOrCreate(
            ['key' => 'site_tagline', 'group' => 'general'],
            [
                'value' => $request->site_tagline ?: '',
                'type' => 'string',
                'description' => 'Website tagline',
                'is_public' => true,
            ]
        );

        AdminSettings::updateOrCreate(
            ['key' => 'site_description', 'group' => 'general'],
            [
                'value' => $request->site_description ?: '',
                'type' => 'string',
                'description' => 'Website description for SEO',
                'is_public' => true,
            ]
        );

        // Handle logo upload (from FilePond or direct upload)
        if ($request->has('logo_path') || $request->hasFile('logo')) {
            $logoPath = $request->input('logo_path');
            
            if ($request->hasFile('logo')) {
                \Log::info('Direct logo upload started', [
                    'user_id' => auth()->id(),
                    'file_info' => [
                        'name' => $request->file('logo')->getClientOriginalName(),
                        'size' => $request->file('logo')->getSize(),
                        'mime' => $request->file('logo')->getMimeType(),
                    ]
                ]);

                // Delete old logo if exists
                $oldLogo = AdminSettings::where('key', 'logo')->where('group', 'general')->first();
                if ($oldLogo && $oldLogo->value) {
                    Storage::disk('public')->delete($oldLogo->value);
                }

                $logoFile = $request->file('logo');
                $logoFilename = uniqid() . '.' . $logoFile->getClientOriginalExtension();
                $logoPath = $logoFile->storeAs('general', $logoFilename, 'public');

                \Log::info('Direct logo storage result', [
                    'filename' => $logoFilename,
                    'path' => $logoPath,
                    'file_exists' => file_exists(storage_path('app/public/' . $logoPath)),
                ]);
            } else {
                \Log::info('FilePond logo path received', ['path' => $logoPath]);
            }

            AdminSettings::updateOrCreate(
                ['key' => 'logo', 'group' => 'general'],
                [
                    'value' => $logoPath ?: '',
                    'type' => 'string',
                    'description' => 'Website logo',
                    'is_public' => true,
                ]
            );
        } elseif ($request->has('remove_logo')) {
            // Remove logo
            $oldLogo = AdminSettings::where('key', 'logo')->where('group', 'general')->first();
            if ($oldLogo && $oldLogo->value) {
                Storage::disk('public')->delete($oldLogo->value);
                $oldLogo->delete();
            }
        }

        // Handle favicon upload (from FilePond or direct upload)
        if ($request->has('favicon_path') || $request->hasFile('favicon')) {
            $faviconPath = $request->input('favicon_path');
            
            if ($request->hasFile('favicon')) {
                \Log::info('Direct favicon upload started', [
                    'user_id' => auth()->id(),
                    'file_info' => [
                        'name' => $request->file('favicon')->getClientOriginalName(),
                        'size' => $request->file('favicon')->getSize(),
                        'mime' => $request->file('favicon')->getMimeType(),
                    ]
                ]);

                // Delete old favicon if exists
                $oldFavicon = AdminSettings::where('key', 'favicon')->where('group', 'general')->first();
                if ($oldFavicon && $oldFavicon->value) {
                    Storage::disk('public')->delete($oldFavicon->value);
                }

                $faviconFile = $request->file('favicon');
                $faviconFilename = uniqid() . '.' . $faviconFile->getClientOriginalExtension();
                $faviconPath = $faviconFile->storeAs('general', $faviconFilename, 'public');

                \Log::info('Direct favicon storage result', [
                    'filename' => $faviconFilename,
                    'path' => $faviconPath,
                    'file_exists' => file_exists(storage_path('app/public/' . $faviconPath)),
                ]);
            } else {
                \Log::info('FilePond favicon path received', ['path' => $faviconPath]);
            }

            AdminSettings::updateOrCreate(
                ['key' => 'favicon', 'group' => 'general'],
                [
                    'value' => $faviconPath ?: '',
                    'type' => 'string',
                    'description' => 'Website favicon',
                    'is_public' => true,
                ]
            );
        } elseif ($request->has('remove_favicon')) {
            // Remove favicon
            $oldFavicon = AdminSettings::where('key', 'favicon')->where('group', 'general')->first();
            if ($oldFavicon && $oldFavicon->value) {
                Storage::disk('public')->delete($oldFavicon->value);
                $oldFavicon->delete();
            }
        }

        // Clear cache
        Cache::forget('general_settings');

        return redirect()->route('admin.settings')->with('success', 'General settings updated successfully!');
    }
}
