<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use App\Models\FooterSettings as FooterSettingsModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LivewireFilepond\WithFilePond;

class Settings extends Component
{
    use WithFileUploads, WithFilePond;

    // General Settings
    public $site_name = '';
    public $site_title = '';
    public $site_description = '';
    public $site_logo;
    public $site_favicon;
    public $old_site_logo = '';
    public $old_site_favicon = '';
    public $company_name = '';

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
    public $contact_form_title = '';
    public $contact_form_description = '';

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
        $this->validateOnly($propertyName);
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function saveGeneral()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'site_title' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:512',
            'company_name' => 'nullable|string|max:255',
        ]);

        try {
            // Get or create the settings instance for media library
            $settingsModel = Setting::firstOrCreate(['key' => 'app_settings']);

            // Handle logo upload via media library
            if ($this->site_logo) {
                // Remove old logo if exists
                $settingsModel->clearMediaCollection('logo');

                // Add new logo from Livewire upload
                $media = $settingsModel->addMedia($this->site_logo->getRealPath())
                    ->usingName('Site Logo')
                    ->usingFileName($this->site_logo->getClientOriginalName())
                    ->toMediaCollection('logo');

                $this->updateSetting('site_logo', $media->getUrl());
                \App\Helpers\ThemeHelper::clearCache();
            }

            // Handle favicon upload via media library
            if ($this->site_favicon) {
                // Remove old favicon if exists
                $settingsModel->clearMediaCollection('favicon');

                // Add new favicon from Livewire upload
                $media = $settingsModel->addMedia($this->site_favicon->getRealPath())
                    ->usingName('Site Favicon')
                    ->usingFileName($this->site_favicon->getClientOriginalName())
                    ->toMediaCollection('favicon');

                $this->updateSetting('site_favicon', $media->getUrl());
                \App\Helpers\ThemeHelper::clearCache();
            }

            $this->updateSetting('site_name', $this->site_name);
            $this->updateSetting('site_title', $this->site_title);
            $this->updateSetting('site_description', $this->site_description);
            $this->updateSetting('company_name', $this->company_name);

            session()->flash('success', 'General settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update general settings: ' . $e->getMessage());
        }
    }

    public function saveContact()
    {
        $this->validate([
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:255',
            'contact_city' => 'nullable|string|max:100',
            'contact_state' => 'nullable|string|max:100',
            'contact_zip' => 'nullable|string|max:20',
            'contact_country' => 'nullable|string|max:100',
        ]);

        try {
            $this->updateSetting('contact_email', $this->contact_email);
            $this->updateSetting('contact_phone', $this->contact_phone);
            $this->updateSetting('contact_address', $this->contact_address);
            $this->updateSetting('contact_city', $this->contact_city);
            $this->updateSetting('contact_state', $this->contact_state);
            $this->updateSetting('contact_zip', $this->contact_zip);
            $this->updateSetting('contact_country', $this->contact_country);

            session()->flash('success', 'Contact settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update contact settings: ' . $e->getMessage());
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

            session()->flash('success', 'Social media settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update social media settings: ' . $e->getMessage());
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

            session()->flash('success', 'Footer settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update footer settings: ' . $e->getMessage());
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
    }

    public function removeQuickLink($index)
    {
        if (isset($this->footer_quick_links[$index])) {
            unset($this->footer_quick_links[$index]);
            $this->footer_quick_links = array_values($this->footer_quick_links);
        }
    }

    public function addService()
    {
        $this->footer_services[] = [
            'text' => '',
            'icon' => ''
        ];
    }

    public function removeService($index)
    {
        if (isset($this->footer_services[$index])) {
            unset($this->footer_services[$index]);
            $this->footer_services = array_values($this->footer_services);
        }
    }

    public function saveStats()
    {
        $this->validate([
            'stats_movies_count' => 'nullable|string|max:50',
            'stats_movies_label' => 'nullable|string|max:255',
            'stats_songs_count' => 'nullable|string|max:50',
            'stats_songs_label' => 'nullable|string|max:255',
            'stats_films_count' => 'nullable|string|max:50',
            'stats_films_label' => 'nullable|string|max:255',
            'stats_views_count' => 'nullable|string|max:50',
            'stats_views_label' => 'nullable|string|max:255',
            'stats_section_title' => 'nullable|string|max:255',
            'stats_section_highlighted_title' => 'nullable|string|max:255',
            'stats_section_description' => 'nullable|string|max:1000',
        ]);

        try {
            $this->updateSetting('stats_movies_count', $this->stats_movies_count);
            $this->updateSetting('stats_movies_label', $this->stats_movies_label);
            $this->updateSetting('stats_songs_count', $this->stats_songs_count);
            $this->updateSetting('stats_songs_label', $this->stats_songs_label);
            $this->updateSetting('stats_films_count', $this->stats_films_count);
            $this->updateSetting('stats_films_label', $this->stats_films_label);
            $this->updateSetting('stats_views_count', $this->stats_views_count);
            $this->updateSetting('stats_views_label', $this->stats_views_label);
            $this->updateSetting('stats_section_title', $this->stats_section_title);
            $this->updateSetting('stats_section_highlighted_title', $this->stats_section_highlighted_title);
            $this->updateSetting('stats_section_description', $this->stats_section_description);

            session()->flash('success', 'Statistics settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update statistics settings: ' . $e->getMessage());
        }
    }

    public function saveCta()
    {
        $this->validate([
            'cta_badge_text' => 'nullable|string|max:255',
            'cta_main_title' => 'nullable|string|max:255',
            'cta_highlighted_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string|max:1000',
            'cta_primary_button_text' => 'nullable|string|max:255',
            'cta_secondary_button_text' => 'nullable|string|max:255',
            'cta_feature_1_title' => 'nullable|string|max:255',
            'cta_feature_1_description' => 'nullable|string|max:500',
            'cta_feature_2_title' => 'nullable|string|max:255',
            'cta_feature_2_description' => 'nullable|string|max:500',
            'cta_feature_3_title' => 'nullable|string|max:255',
            'cta_feature_3_description' => 'nullable|string|max:500',
        ]);

        try {
            $this->updateSetting('cta_badge_text', $this->cta_badge_text);
            $this->updateSetting('cta_main_title', $this->cta_main_title);
            $this->updateSetting('cta_highlighted_title', $this->cta_highlighted_title);
            $this->updateSetting('cta_description', $this->cta_description);
            $this->updateSetting('cta_primary_button_text', $this->cta_primary_button_text);
            $this->updateSetting('cta_secondary_button_text', $this->cta_secondary_button_text);
            $this->updateSetting('cta_feature_1_title', $this->cta_feature_1_title);
            $this->updateSetting('cta_feature_1_description', $this->cta_feature_1_description);
            $this->updateSetting('cta_feature_2_title', $this->cta_feature_2_title);
            $this->updateSetting('cta_feature_2_description', $this->cta_feature_2_description);
            $this->updateSetting('cta_feature_3_title', $this->cta_feature_3_title);
            $this->updateSetting('cta_feature_3_description', $this->cta_feature_3_description);

            session()->flash('success', 'Call to Action settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update call to action settings: ' . $e->getMessage());
        }
    }

    public function saveContactPage()
    {
        $this->validate([
            'contact_hero_title' => 'nullable|string|max:255',
            'contact_hero_subtitle' => 'nullable|string|max:255',
            'contact_hero_description' => 'nullable|string|max:1000',
            'contact_form_title' => 'nullable|string|max:255',
            'contact_form_description' => 'nullable|string|max:1000',
        ]);

        try {
            $this->updateSetting('contact_hero_title', $this->contact_hero_title);
            $this->updateSetting('contact_hero_subtitle', $this->contact_hero_subtitle);
            $this->updateSetting('contact_hero_description', $this->contact_hero_description);
            $this->updateSetting('contact_form_title', $this->contact_form_title);
            $this->updateSetting('contact_form_description', $this->contact_form_description);

            session()->flash('success', 'Contact page settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update contact settings: ' . $e->getMessage());
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
