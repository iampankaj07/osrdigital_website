<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Settings extends Component
{
    use WithFileUploads;

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

    // Footer Settings
    public $footer_text = '';
    public $footer_copyright = '';

    // Hero Section Settings
    public $hero_badge_text = '';
    public $hero_main_title = '';
    public $hero_highlighted_title = '';
    public $hero_description = '';
    public $hero_primary_button_text = '';
    public $hero_secondary_button_text = '';

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
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
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

        // Footer Settings
        $this->footer_text = $settings->get('footer_text', '');
        $this->footer_copyright = $settings->get('footer_copyright', '');

        // Hero Section Settings
        $this->hero_badge_text = $settings->get('hero_badge_text', '');
        $this->hero_main_title = $settings->get('hero_main_title', '');
        $this->hero_highlighted_title = $settings->get('hero_highlighted_title', '');
        $this->hero_description = $settings->get('hero_description', '');
        $this->hero_primary_button_text = $settings->get('hero_primary_button_text', '');
        $this->hero_secondary_button_text = $settings->get('hero_secondary_button_text', '');

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
            // Handle logo upload
            if ($this->site_logo) {
                if ($this->old_site_logo && Storage::disk('public')->exists($this->old_site_logo)) {
                    Storage::disk('public')->delete($this->old_site_logo);
                }
                $filename = 'settings/' . Str::uuid() . '.' . $this->site_logo->getClientOriginalExtension();
                $this->site_logo->storeAs('public', $filename);
                $this->updateSetting('site_logo', $filename);
            }

            // Handle favicon upload
            if ($this->site_favicon) {
                if ($this->old_site_favicon && Storage::disk('public')->exists($this->old_site_favicon)) {
                    Storage::disk('public')->delete($this->old_site_favicon);
                }
                $filename = 'settings/' . Str::uuid() . '.' . $this->site_favicon->getClientOriginalExtension();
                $this->site_favicon->storeAs('public', $filename);
                $this->updateSetting('site_favicon', $filename);
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

    public function saveFooter()
    {
        $this->validate([
            'footer_text' => 'nullable|string|max:1000',
            'footer_copyright' => 'nullable|string|max:255',
        ]);

        try {
            $this->updateSetting('footer_text', $this->footer_text);
            $this->updateSetting('footer_copyright', $this->footer_copyright);

            session()->flash('success', 'Footer settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update footer settings: ' . $e->getMessage());
        }
    }

    public function saveHero()
    {
        $this->validate([
            'hero_badge_text' => 'nullable|string|max:255',
            'hero_main_title' => 'nullable|string|max:255',
            'hero_highlighted_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string|max:1000',
            'hero_primary_button_text' => 'nullable|string|max:255',
            'hero_secondary_button_text' => 'nullable|string|max:255',
        ]);

        try {
            $this->updateSetting('hero_badge_text', $this->hero_badge_text);
            $this->updateSetting('hero_main_title', $this->hero_main_title);
            $this->updateSetting('hero_highlighted_title', $this->hero_highlighted_title);
            $this->updateSetting('hero_description', $this->hero_description);
            $this->updateSetting('hero_primary_button_text', $this->hero_primary_button_text);
            $this->updateSetting('hero_secondary_button_text', $this->hero_secondary_button_text);

            session()->flash('success', 'Hero section settings updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update hero section settings: ' . $e->getMessage());
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


    private function updateSetting($key, $value)
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('admin.layout', ['title' => 'Settings']);
    }
}
