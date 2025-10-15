<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use App\Models\FooterSettings as FooterSettingsModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\LivewireFilepond\WithFilePond;
use App\Traits\DispatchesAlertEvents;

class Settings extends Component
{
    use WithFileUploads, WithFilePond, DispatchesAlertEvents;

    protected $listeners = [
        'mediaSelected' => 'handleMediaSelection',
    ];

    // General Settings
    public $site_name = '';
    public $site_title = '';
    public $site_description = '';
    public $site_logo;
    public $site_favicon;
    public $old_site_logo = '';
    public $old_site_favicon = '';
    public $company_name = '';

    // FilePond uploads for logo and favicon
    public $filepondLogoUploads = [];
    public $filepondFaviconUploads = [];

    // Media library selection for logo and favicon
    public $selectedLogoMediaId = null;
    public $selectedLogoMediaUrl = null;
    public $selectedFaviconMediaId = null;
    public $selectedFaviconMediaUrl = null;

    // Track which media selector is active
    public $activeMediaSelector = null;

    // Contact Settings
    public $contact_email = '';
    public $contact_phone = '';
    public $contact_address = '';
    public $contact_city = '';
    public $contact_state = '';
    public $contact_zip = '';
    public $contact_country = '';

    // Social Media Settings
    public $facebook_url = '';
    public $twitter_url = '';
    public $instagram_url = '';
    public $linkedin_url = '';
    public $youtube_url = '';

    // Footer Settings (Enhanced from FooterSettings component)
    public $footer_text = '';
    public $footer_copyright = '';
    public $footer_company_name = '';
    public $footer_company_description = '';
    public $footer_email = '';
    public $footer_phone = '';
    public $footer_website = '';
    public $footer_address = '';
    public $footer_quick_links = [];
    public $footer_services = [];
    public $footer_copyright_text = '';
    public $footer_is_active = true;
    public $footerSettings;

    // Contact Page Settings
    public $contact_hero_title = '';
    public $contact_hero_subtitle = '';
    public $contact_hero_description = '';
    public $contact_hero_background_image = '';
    public $contact_form_title = '';
    public $contact_form_description = '';
    public $contact_form_success_message = '';
    public $contact_form_button_text = '';

    // Statistics Settings
    public $stats_movies_count = '';
    public $stats_movies_label = '';
    public $stats_songs_count = '';
    public $stats_songs_label = '';
    public $stats_films_count = '';
    public $stats_films_label = '';
    public $stats_views_count = '';
    public $stats_views_label = '';
    public $stats_section_title = '';
    public $stats_section_highlighted_title = '';
    public $stats_section_description = '';

    // Call to Action Settings
    public $cta_badge_text = '';
    public $cta_main_title = '';
    public $cta_highlighted_title = '';
    public $cta_description = '';
    public $cta_primary_button_text = '';
    public $cta_secondary_button_text = '';
    public $cta_feature_1_title = '';
    public $cta_feature_1_description = '';
    public $cta_feature_2_title = '';
    public $cta_feature_2_description = '';
    public $cta_feature_3_title = '';
    public $cta_feature_3_description = '';

    // Branding Settings

    // Tab Management
    public $activeTab = 'general';

    protected $rules = [
        'site_name' => 'required|string|max:255',
        'site_title' => 'nullable|string|max:255',
        'site_description' => 'nullable|string|max:500',
        'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:512',
        'company_name' => 'nullable|string|max:255',
        'contact_email' => 'nullable|email|max:255',
        'contact_phone' => 'nullable|string|max:50',
        'contact_address' => 'nullable|string|max:255',
        'contact_city' => 'nullable|string|max:100',
        'contact_state' => 'nullable|string|max:100',
        'contact_zip' => 'nullable|string|max:20',
        'contact_country' => 'nullable|string|max:100',
        'facebook_url' => 'nullable|url|max:255',
        'twitter_url' => 'nullable|url|max:255',
        'instagram_url' => 'nullable|url|max:255',
        'linkedin_url' => 'nullable|url|max:255',
        'youtube_url' => 'nullable|url|max:255',
        'footer_text' => 'nullable|string|max:1000',
        'footer_copyright' => 'nullable|string|max:255',
        'footer_company_name' => 'nullable|string|max:255',
        'footer_company_description' => 'nullable|string|max:1000',
        'footer_email' => 'nullable|email|max:255',
        'footer_phone' => 'nullable|string|max:255',
        'footer_website' => 'nullable|url|max:255',
        'footer_address' => 'nullable|string|max:500',
        'footer_copyright_text' => 'nullable|string|max:255',
        'footer_quick_links' => 'array',
        'footer_services' => 'array',
        'contact_hero_title' => 'nullable|string|max:255',
        'contact_hero_subtitle' => 'nullable|string|max:255',
        'contact_hero_description' => 'nullable|string|max:1000',
        'contact_form_title' => 'nullable|string|max:255',
        'contact_form_description' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        // Initialize arrays first
        $this->footer_quick_links = [];
        $this->footer_services = [];

        $this->loadSettings();
    }    public function loadSettings()
    {
        $settings = Setting::all()->pluck('value', 'key');

        // General Settings
        $this->site_name = $settings->get('site_name', '');
        $this->site_title = $settings->get('site_title', '');
        $this->site_description = $settings->get('site_description', '');
        $this->old_site_logo = $settings->get('site_logo', '');
        $this->old_site_favicon = $settings->get('site_favicon', '');
        $this->company_name = $settings->get('company_name', '');

        // Contact Settings
        $this->contact_email = $settings->get('contact_email', '');
        $this->contact_phone = $settings->get('contact_phone', '');
        $this->contact_address = $settings->get('contact_address', '');
        $this->contact_city = $settings->get('contact_city', '');
        $this->contact_state = $settings->get('contact_state', '');
        $this->contact_zip = $settings->get('contact_zip', '');
        $this->contact_country = $settings->get('contact_country', '');

        // Social Media Settings
        $this->facebook_url = $settings->get('facebook_url', '');
        $this->twitter_url = $settings->get('twitter_url', '');
        $this->instagram_url = $settings->get('instagram_url', '');
        $this->linkedin_url = $settings->get('linkedin_url', '');
        $this->youtube_url = $settings->get('youtube_url', '');

        // Footer Settings (Basic)
        $this->footer_text = $settings->get('footer_text', '');
        $this->footer_copyright = $settings->get('footer_copyright', '');

        // Enhanced Footer Settings (from FooterSettings model)
        $this->loadFooterSettings();

        // Statistics Settings
        $this->stats_movies_count = $settings->get('stats_movies_count', '');
        $this->stats_movies_label = $settings->get('stats_movies_label', '');
        $this->stats_songs_count = $settings->get('stats_songs_count', '');
        $this->stats_songs_label = $settings->get('stats_songs_label', '');
        $this->stats_films_count = $settings->get('stats_films_count', '');
        $this->stats_films_label = $settings->get('stats_films_label', '');
        $this->stats_views_count = $settings->get('stats_views_count', '');
        $this->stats_views_label = $settings->get('stats_views_label', '');
        $this->stats_section_title = $settings->get('stats_section_title', '');
        $this->stats_section_highlighted_title = $settings->get('stats_section_highlighted_title', '');
        $this->stats_section_description = $settings->get('stats_section_description', '');

        // Call to Action Settings
        $this->cta_badge_text = $settings->get('cta_badge_text', '');
        $this->cta_main_title = $settings->get('cta_main_title', '');
        $this->cta_highlighted_title = $settings->get('cta_highlighted_title', '');
        $this->cta_description = $settings->get('cta_description', '');
        $this->cta_primary_button_text = $settings->get('cta_primary_button_text', '');
        $this->cta_secondary_button_text = $settings->get('cta_secondary_button_text', '');
        $this->cta_feature_1_title = $settings->get('cta_feature_1_title', '');
        $this->cta_feature_1_description = $settings->get('cta_feature_1_description', '');
        $this->cta_feature_2_title = $settings->get('cta_feature_2_title', '');
        $this->cta_feature_2_description = $settings->get('cta_feature_2_description', '');
        $this->cta_feature_3_title = $settings->get('cta_feature_3_title', '');
        $this->cta_feature_3_description = $settings->get('cta_feature_3_description', '');

        // Contact Page Settings
        $this->contact_hero_title = $settings->get('contact_hero_title', 'Let\'s Connect');
        $this->contact_hero_subtitle = $settings->get('contact_hero_subtitle', 'Get In Touch');
        $this->contact_hero_description = $settings->get('contact_hero_description', 'Ready to bring your content to global audiences? Get in touch with our team and let\'s discuss how we can help you achieve your distribution goals.');
        $this->contact_form_title = $settings->get('contact_form_title', 'Send us a Message');
        $this->contact_form_description = $settings->get('contact_form_description', 'Fill out the form below and we\'ll get back to you within 24 hours');

        // Branding Settings
    }

    public function updated($propertyName)
    {
        // Add specific validation for footer fields
        if (str_starts_with($propertyName, 'footer_')) {
            $this->validateFooterField($propertyName);
        } else {
            $this->validateOnly($propertyName);
        }
    }

    protected function validateFooterField($field)
    {
        $rules = [
            'footer_company_name' => 'required|string|max:255|min:2',
            'footer_company_description' => 'nullable|string|max:1000|min:10',
            'footer_email' => 'nullable|email|max:255',
            'footer_phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\(\)\-\s]+$/',
            'footer_website' => 'nullable|url|max:255',
            'footer_address' => 'nullable|string|max:500|min:5',
            'footer_copyright_text' => 'nullable|string|max:255',
        ];

        $messages = [
            'footer_company_name.required' => 'Company name is required.',
            'footer_company_name.min' => 'Company name must be at least 2 characters.',
            'footer_company_description.min' => 'Company description must be at least 10 characters when provided.',
            'footer_email.email' => 'Please enter a valid email address.',
            'footer_phone.regex' => 'Please enter a valid phone number format.',
            'footer_website.url' => 'Please enter a valid website URL.',
            'footer_address.min' => 'Address must be at least 5 characters when provided.',
        ];

        if (isset($rules[$field])) {
            $this->validateOnly($field, [$field => $rules[$field]], $messages);
        }
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openMediaSelector()
    {
        $this->dispatch('openMediaSelector');
    }

    public function handleMediaSelection($data)
    {
        try {
            // Handle case where data is an indexed array containing the media data
            if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                $data = $data[0];
            }

            // Assign media based on which selector was opened
            if (isset($data['mediaId']) && isset($data['mediaUrl'])) {
                if ($this->activeMediaSelector === 'logo') {
                    $this->selectedLogoMediaId = $data['mediaId'];
                    $this->selectedLogoMediaUrl = $data['mediaUrl'];
                } elseif ($this->activeMediaSelector === 'favicon') {
                    $this->selectedFaviconMediaId = $data['mediaId'];
                    $this->selectedFaviconMediaUrl = $data['mediaUrl'];
                }
                $this->activeMediaSelector = null; // Reset after selection
            }
        } catch (\Exception $e) {
            Log::error('Settings - Media selection error: ' . $e->getMessage());
        }
    }

    public function clearSelectedLogoMedia()
    {
        $this->selectedLogoMediaId = null;
        $this->selectedLogoMediaUrl = null;
    }

    public function clearSelectedFaviconMedia()
    {
        $this->selectedFaviconMediaId = null;
        $this->selectedFaviconMediaUrl = null;
    }

    public function openLogoMediaSelector()
    {
        $this->activeMediaSelector = 'logo';
        $this->dispatch('openMediaSelector');
    }

    public function openFaviconMediaSelector()
    {
        $this->activeMediaSelector = 'favicon';
        $this->dispatch('openMediaSelector');
    }

    public function saveGeneral()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'site_title' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:255',
        ]);

        try {
            // Get or create the settings instance for media library
            $settingsModel = Setting::firstOrCreate(['key' => 'app_settings']);

            // Handle logo - prioritize media library selection, then FilePond uploads
            if ($this->selectedLogoMediaId) {
                // Use selected media from media library
                $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($this->selectedLogoMediaId);
                if ($media) {
                    // Store the relative path instead of full URL to avoid double URL issues
                    $this->updateSetting('site_logo', $media->id . '/' . $media->file_name);
                    \App\Helpers\ThemeHelper::clearCache();
                    \Illuminate\Support\Facades\Cache::flush();
                    \Illuminate\Support\Facades\Cache::flush();
                }
            } elseif (!empty($this->filepondLogoUploads)) {
                // Process FilePond uploads for logo
                $settingsModel->clearMediaCollection('logo');
                foreach ($this->filepondLogoUploads as $upload) {
                    $media = $settingsModel->addMedia($upload->getRealPath())
                        ->usingName('Site Logo')
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('logo');

                    $this->updateSetting('site_logo', $media->id . '/' . $media->file_name);
                    \App\Helpers\ThemeHelper::clearCache();
                    \Illuminate\Support\Facades\Cache::flush();
                    break; // Only take the first file
                }
            } elseif ($this->site_logo) {
                // Fallback to traditional Livewire upload
                $settingsModel->clearMediaCollection('logo');
                $media = $settingsModel->addMedia($this->site_logo->getRealPath())
                    ->usingName('Site Logo')
                    ->usingFileName($this->site_logo->getClientOriginalName())
                    ->toMediaCollection('logo');

                $this->updateSetting('site_logo', $media->id . '/' . $media->file_name);
                \App\Helpers\ThemeHelper::clearCache();
            }

            // Handle favicon - prioritize media library selection, then FilePond uploads
            if ($this->selectedFaviconMediaId) {
                // Use selected media from media library
                $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($this->selectedFaviconMediaId);
                if ($media) {
                    // Store the relative path instead of full URL to avoid double URL issues
                    $this->updateSetting('site_favicon', $media->id . '/' . $media->file_name);
                    \App\Helpers\ThemeHelper::clearCache();
                    \Illuminate\Support\Facades\Cache::flush();
                    \Illuminate\Support\Facades\Cache::flush();
                }
            } elseif (!empty($this->filepondFaviconUploads)) {
                // Process FilePond uploads for favicon
                $settingsModel->clearMediaCollection('favicon');
                foreach ($this->filepondFaviconUploads as $upload) {
                    $media = $settingsModel->addMedia($upload->getRealPath())
                        ->usingName('Site Favicon')
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('favicon');

                    $this->updateSetting('site_favicon', $media->id . '/' . $media->file_name);
                    \App\Helpers\ThemeHelper::clearCache();
                    \Illuminate\Support\Facades\Cache::flush();
                    break; // Only take the first file
                }
            } elseif ($this->site_favicon) {
                // Fallback to traditional Livewire upload
                $settingsModel->clearMediaCollection('favicon');
                $media = $settingsModel->addMedia($this->site_favicon->getRealPath())
                    ->usingName('Site Favicon')
                    ->usingFileName($this->site_favicon->getClientOriginalName())
                    ->toMediaCollection('favicon');

                $this->updateSetting('site_favicon', $media->id . '/' . $media->file_name);
                \App\Helpers\ThemeHelper::clearCache();
            }

            $this->updateSetting('site_name', $this->site_name);
            $this->updateSetting('site_title', $this->site_title);
            $this->updateSetting('site_description', $this->site_description);
            $this->updateSetting('company_name', $this->company_name);

            // Reset upload states after successful save
            $this->filepondLogoUploads = [];
            $this->filepondFaviconUploads = [];
            $this->selectedLogoMediaId = null;
            $this->selectedLogoMediaUrl = null;
            $this->selectedFaviconMediaId = null;
            $this->selectedFaviconMediaUrl = null;

            $this->flashSuccess('General settings updated successfully!');
        } catch (\Exception $e) {
            $this->flashError('Failed to update general settings: ' . $e->getMessage());
        }
    }

    public function saveContact()
    {
        $this->validate([
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
            'secondary_phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
        ]);

        try {
            $this->updateSetting('company_email', $this->company_email);
            $this->updateSetting('company_phone', $this->company_phone);
            $this->updateSetting('company_address', $this->company_address);
            $this->updateSetting('secondary_phone', $this->secondary_phone);
            $this->updateSetting('whatsapp_number', $this->whatsapp_number);

            $this->flashSuccess('Contact information updated successfully!');
        } catch (\Exception $e) {
            $this->flashError('Failed to update contact information: ' . $e->getMessage());
        }
    }

    public function saveSocial()
    {
        $this->validate([
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        try {
            $this->updateSetting('facebook_url', $this->facebook_url);
            $this->updateSetting('twitter_url', $this->twitter_url);
            $this->updateSetting('instagram_url', $this->instagram_url);
            $this->updateSetting('linkedin_url', $this->linkedin_url);
            $this->updateSetting('youtube_url', $this->youtube_url);

            $this->flashSuccess('Social media settings saved successfully!');

        } catch (\Exception $e) {
            Log::error('Social Media Settings Save Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to save social media settings. Please try again.');
        }
    }

    public function loadFooterSettings()
    {
        $this->footerSettings = FooterSettingsModel::getActive();

        if ($this->footerSettings) {
            $this->footer_company_name = $this->footerSettings->company_name ?? '';
            $this->footer_company_description = $this->footerSettings->company_description ?? '';
            $this->footer_email = $this->footerSettings->email ?? '';
            $this->footer_phone = $this->footerSettings->phone ?? '';
            $this->footer_website = $this->footerSettings->website ?? '';
            $this->footer_address = $this->footerSettings->address ?? '';
            $this->footer_copyright_text = $this->footerSettings->copyright_text ?? '';
            $this->footer_is_active = $this->footerSettings->is_active ?? true;

            // Load quick links
            $this->footer_quick_links = [];
            if ($this->footerSettings->quick_links && is_array($this->footerSettings->quick_links)) {
                foreach ($this->footerSettings->quick_links as $link) {
                    $this->footer_quick_links[] = [
                        'title' => $link['title'] ?? '',
                        'url' => $link['url'] ?? '',
                        'icon' => $link['icon'] ?? ''
                    ];
                }
            }

            // Load services
            $this->footer_services = [];
            if ($this->footerSettings->services && is_array($this->footerSettings->services)) {
                foreach ($this->footerSettings->services as $service) {
                    $this->footer_services[] = [
                        'text' => $service['text'] ?? '',
                        'icon' => $service['icon'] ?? ''
                    ];
                }
            }
        } else {
            // Set default values
            $this->footer_company_name = 'OSR Digital';
            $this->footer_company_description = 'Bringing Stories to Screens Worldwide';
            $this->footer_email = 'info@osrdigital.com';
            $this->footer_phone = '+1 (555) 123-4567';
            $this->footer_website = 'https://osrdigital.com';
            $this->footer_address = 'Your Company Address';
            $this->footer_copyright_text = '© 2024 OSR Digital. All rights reserved.';
            $this->footer_quick_links = [];
            $this->footer_services = [];
        }
    }

    public function saveFooter()
    {
        $this->validate([
            'footer_text' => 'nullable|string|max:1000',
            'footer_copyright' => 'nullable|string|max:255',
            'footer_company_name' => 'nullable|string|max:255',
            'footer_company_description' => 'nullable|string|max:1000',
            'footer_email' => 'nullable|email|max:255',
            'footer_phone' => 'nullable|string|max:255',
            'footer_website' => 'nullable|url|max:255',
            'footer_address' => 'nullable|string|max:500',
            'footer_copyright_text' => 'nullable|string|max:255',
        ]);

        try {
            // Save basic footer settings to Settings table
            $this->updateSetting('footer_text', $this->footer_text);
            $this->updateSetting('footer_copyright', $this->footer_copyright);

            // Save enhanced footer settings to FooterSettings table
            $data = [
                'company_name' => $this->footer_company_name,
                'company_description' => $this->footer_company_description,
                'email' => $this->footer_email,
                'phone' => $this->footer_phone,
                'website' => $this->footer_website,
                'address' => $this->footer_address,
                'copyright_text' => $this->footer_copyright_text,
                'quick_links' => $this->formatQuickLinks(),
                'services' => $this->formatServices(),
                'is_active' => $this->footer_is_active,
            ];

            if ($this->footerSettings) {
                $this->footerSettings->update($data);
            } else {
                FooterSettingsModel::create($data);
            }

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget('footer_settings');

            $this->flashSuccess('Footer settings updated successfully!');
        } catch (\Exception $e) {
            $this->flashError('Failed to update footer settings: ' . $e->getMessage());
        }
    }

    public function saveCompanyInfo()
    {
        $this->validate([
            'footer_company_name' => 'required|string|max:255|min:2',
            'footer_company_description' => 'nullable|string|max:1000|min:10',
            'footer_email' => 'nullable|email|max:255',
            'footer_phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\(\)\-\s]+$/',
            'footer_website' => 'nullable|url|max:255|active_url',
            'footer_address' => 'nullable|string|max:500|min:5',
        ], [
            'footer_company_name.required' => 'Company name is required.',
            'footer_company_name.min' => 'Company name must be at least 2 characters.',
            'footer_company_description.min' => 'Company description must be at least 10 characters when provided.',
            'footer_email.email' => 'Please enter a valid email address.',
            'footer_phone.regex' => 'Please enter a valid phone number format.',
            'footer_website.active_url' => 'Please enter a valid and reachable website URL.',
            'footer_address.min' => 'Address must be at least 5 characters when provided.',
        ]);

        try {
            // Update or create footer settings
            $data = [
                'company_name' => $this->footer_company_name,
                'company_description' => $this->footer_company_description,
                'email' => $this->footer_email,
                'phone' => $this->footer_phone,
                'website' => $this->footer_website,
                'address' => $this->footer_address,
                'is_active' => $this->footer_is_active,
            ];

            // Preserve existing data if updating
            if ($this->footerSettings) {
                $data['copyright_text'] = $this->footerSettings->copyright_text;
                $data['quick_links'] = $this->footerSettings->quick_links;
                $data['services'] = $this->footerSettings->services;
                $this->footerSettings->update($data);
            } else {
                $data['copyright_text'] = $this->footer_copyright_text;
                $data['quick_links'] = [];
                $data['services'] = [];
                FooterSettingsModel::create($data);
                $this->footerSettings = FooterSettingsModel::getActive();
            }

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget('footer_settings');

            $this->dispatchSuccessEvent('Company information updated successfully!');
        } catch (\Exception $e) {
            $this->dispatchErrorEvent('Failed to update company information: ' . $e->getMessage());
        }
    }

    public function saveServices()
    {
        // Check if there are any services to save
        if (empty($this->footer_services)) {
            $this->dispatchErrorEvent('Please add at least one service before saving.');
            return;
        }

        // Validate services array
        $this->validate([
            'footer_services' => 'array|min:1',
            'footer_services.*.text' => 'required|string|max:255|min:2',
            'footer_services.*.icon' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9\-\s]+$/',
        ], [
            'footer_services.min' => 'At least one service is required.',
            'footer_services.*.text.required' => 'Service name is required.',
            'footer_services.*.text.min' => 'Service name must be at least 2 characters.',
            'footer_services.*.icon.regex' => 'Icon name can only contain letters, numbers, hyphens, and spaces.',
        ]);

        try {
            $formattedServices = $this->formatServices();

            // Update only the services field
            if ($this->footerSettings) {
                $this->footerSettings->update(['services' => $formattedServices]);
            } else {
                // Create new record if doesn't exist
                FooterSettingsModel::create([
                    'company_name' => $this->footer_company_name ?: 'Default Company',
                    'services' => $formattedServices,
                    'is_active' => true,
                ]);
                $this->footerSettings = FooterSettingsModel::getActive();
            }

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget('footer_settings');

            $this->flashSuccess('Services saved successfully!');

        } catch (\Exception $e) {
            Log::error('Services Save Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to save services. Please try again.');
        }
    }

    public function saveQuickLinks()
    {
        // Check if there are any links to save
        if (empty($this->footer_quick_links)) {
            $this->dispatchErrorEvent('Please add at least one quick link before saving.');
            return;
        }

        // Validate quick links array (remove active_url for now as it might be too strict)
        $this->validate([
            'footer_quick_links' => 'array|min:1',
            'footer_quick_links.*.title' => 'required|string|max:255|min:2',
            'footer_quick_links.*.url' => 'required|url|max:255',
        ], [
            'footer_quick_links.min' => 'At least one quick link is required.',
            'footer_quick_links.*.title.required' => 'Link title is required.',
            'footer_quick_links.*.title.min' => 'Link title must be at least 2 characters.',
            'footer_quick_links.*.url.required' => 'Link URL is required.',
            'footer_quick_links.*.url.url' => 'Please enter a valid URL format.',
        ]);

        try {
            $formattedLinks = $this->formatQuickLinks();

            // Update only the quick_links field
            if ($this->footerSettings) {
                $this->footerSettings->update(['quick_links' => $formattedLinks]);
            } else {
                // Create new record if doesn't exist
                FooterSettingsModel::create([
                    'company_name' => $this->footer_company_name ?: 'Default Company',
                    'quick_links' => $formattedLinks,
                    'is_active' => true,
                ]);
                $this->footerSettings = FooterSettingsModel::getActive();
            }

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget('footer_settings');

            $this->flashSuccess('Quick links saved successfully!');

        } catch (\Exception $e) {
            Log::error('Quick Links Save Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to save quick links. Please try again.');
        }
    }

    public function saveAdditionalSettings()
    {
        $this->validate([
            'footer_copyright_text' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string|max:1000',
            'footer_copyright' => 'nullable|string|max:255',
        ]);

        try {
            // Save basic footer settings to Settings table
            $this->updateSetting('footer_text', $this->footer_text);
            $this->updateSetting('footer_copyright', $this->footer_copyright);

            // Update copyright text in FooterSettings
            if ($this->footerSettings) {
                $this->footerSettings->update(['copyright_text' => $this->footer_copyright_text]);
            } else {
                FooterSettingsModel::create([
                    'company_name' => $this->footer_company_name ?: 'Default Company',
                    'copyright_text' => $this->footer_copyright_text,
                    'is_active' => true,
                ]);
                $this->footerSettings = FooterSettingsModel::getActive();
            }

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget('footer_settings');

            $this->flashSuccess('Additional settings saved successfully!');

        } catch (\Exception $e) {
            Log::error('Additional Settings Save Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to save additional settings. Please try again.');
        }
    }

    private function formatQuickLinks()
    {
        return array_filter($this->footer_quick_links, function($link) {
            return !empty($link['title']) && !empty($link['url']);
        });
    }

    private function formatServices()
    {
        return array_filter($this->footer_services, function($service) {
            return !empty($service['text']);
        });
    }

    public function addQuickLink()
    {
        $this->footer_quick_links[] = [
            'title' => '',
            'url' => '',
            'icon' => ''
        ];
        // Clear validation errors when adding new items
        $this->resetValidation(['footer_quick_links']);
    }

    public function removeQuickLink($index)
    {
        if (isset($this->footer_quick_links[$index])) {
            unset($this->footer_quick_links[$index]);
            $this->footer_quick_links = array_values($this->footer_quick_links);
            // Clear validation errors when removing items
            $this->resetValidation(['footer_quick_links']);
        }
    }

    public function addService()
    {
        $this->footer_services[] = [
            'text' => '',
            'icon' => ''
        ];
        // Clear validation errors when adding new items
        $this->resetValidation(['footer_services']);
    }

    public function removeService($index)
    {
        if (isset($this->footer_services[$index])) {
            unset($this->footer_services[$index]);
            $this->footer_services = array_values($this->footer_services);
            // Clear validation errors when removing items
            $this->resetValidation(['footer_services']);
        }
    }

    public function saveStats()
    {
        $this->validate([
            'google_analytics_id' => 'nullable|string|max:50',
            'google_tag_manager_id' => 'nullable|string|max:50',
            'facebook_pixel_id' => 'nullable|string|max:50',
        ]);

        try {
            $this->updateSetting('google_analytics_id', $this->google_analytics_id);
            $this->updateSetting('google_tag_manager_id', $this->google_tag_manager_id);
            $this->updateSetting('facebook_pixel_id', $this->facebook_pixel_id);

            $this->flashSuccess('Analytics settings saved successfully!');

        } catch (\Exception $e) {
            Log::error('Analytics Settings Save Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to save analytics settings. Please try again.');
        }
    }

    public function saveCta()
    {
        $this->validate([
            'cta_text' => 'nullable|string|max:255',
            'cta_button_text' => 'nullable|string|max:100',
            'cta_button_url' => 'nullable|url|max:255',
            'cta_background_color' => 'nullable|string|max:7',
            'cta_text_color' => 'nullable|string|max:7',
        ]);

        try {
            $this->updateSetting('cta_text', $this->cta_text);
            $this->updateSetting('cta_button_text', $this->cta_button_text);
            $this->updateSetting('cta_button_url', $this->cta_button_url);
            $this->updateSetting('cta_background_color', $this->cta_background_color);
            $this->updateSetting('cta_text_color', $this->cta_text_color);

            $this->flashSuccess('Call to Action settings saved successfully!');

        } catch (\Exception $e) {
            Log::error('CTA Settings Save Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to save call to action settings. Please try again.');
        }
    }

    public function saveContactHeroSection()
    {
        $this->validate([
            'contact_hero_title' => 'required|string|max:255',
            'contact_hero_subtitle' => 'nullable|string|max:500',
            'contact_hero_description' => 'nullable|string|max:1000',
        ]);

        try {
            $this->updateSetting('contact_hero_title', $this->contact_hero_title);
            $this->updateSetting('contact_hero_subtitle', $this->contact_hero_subtitle);
            $this->updateSetting('contact_hero_description', $this->contact_hero_description);

            $this->flashSuccess('Contact Hero Section updated successfully!');
        } catch (\Exception $e) {
            $this->flashError('Failed to update Contact Hero Section: ' . $e->getMessage());
        }
    }

    public function saveContactFormSection()
    {
        $this->validate([
            'contact_form_title' => 'required|string|max:255',
            'contact_form_description' => 'nullable|string|max:1000',
        ]);

        try {
            $this->updateSetting('contact_form_title', $this->contact_form_title);
            $this->updateSetting('contact_form_description', $this->contact_form_description);

            $this->flashSuccess('Contact Form Section updated successfully!');
        } catch (\Exception $e) {
            $this->flashError('Failed to update Contact Form Section: ' . $e->getMessage());
        }
    }

    private function updateSetting($key, $value)
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
