<?php

namespace App\Livewire\Admin;

use App\Models\FooterSettings as FooterSettingsModel;
use Livewire\Component;

class FooterSettings extends Component
{
    // Company Information
    public $company_name = '';
    public $company_description = '';
    public $email = '';
    public $phone = '';
    public $website = '';
    public $address = '';

    // Social Links
    public $social_links = [];

    // Quick Links
    public $quick_links = [];

    // Copyright
    public $copyright_text = '';

    // State
    public $is_active = true;
    public $footer;

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'company_description' => 'nullable|string|max:1000',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:255',
        'website' => 'nullable|url|max:255',
        'address' => 'nullable|string|max:500',
        'social_links.*.platform' => 'required|string|in:facebook,twitter,linkedin,instagram,youtube,tiktok',
        'social_links.*.url' => 'required|url|max:500',
        'quick_links.*.title' => 'required|string|max:255',
        'quick_links.*.url' => 'required|string|max:500',
        'copyright_text' => 'nullable|string|max:255',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'company_name.required' => 'Company name is required',
        'email.email' => 'Please enter a valid email address',
        'website.url' => 'Please enter a valid website URL',
        'social_links.*.platform.required' => 'Platform is required for social links',
        'social_links.*.url.required' => 'URL is required for social links',
        'social_links.*.url.url' => 'Please enter a valid URL for social links',
        'quick_links.*.title.required' => 'Title is required for quick links',
        'quick_links.*.url.required' => 'URL is required for quick links',
    ];

    public function mount()
    {
        $this->footer = FooterSettingsModel::getActive();

        if ($this->footer) {
            $this->loadFooterData();
        } else {
            $this->setDefaultValues();
        }
    }

    private function loadFooterData()
    {
        $this->company_name = $this->footer->company_name ?? '';
        $this->company_description = $this->footer->company_description ?? '';
        $this->email = $this->footer->email ?? '';
        $this->phone = $this->footer->phone ?? '';
        $this->website = $this->footer->website ?? '';
        $this->address = $this->footer->address ?? '';
        $this->copyright_text = $this->footer->copyright_text ?? '';
        $this->is_active = $this->footer->is_active ?? true;

        // Load social links
        $this->social_links = [];
        if ($this->footer->social_links && is_array($this->footer->social_links)) {
            foreach ($this->footer->social_links as $key => $value) {
                if (is_array($value)) {
                    $this->social_links[] = $value;
                } else {
                    $this->social_links[] = [
                        'platform' => $key,
                        'url' => $value
                    ];
                }
            }
        }

        // Ensure we have at least one empty social link
        if (empty($this->social_links)) {
            $this->social_links[] = ['platform' => 'facebook', 'url' => ''];
        }

        // Load quick links
        $this->quick_links = [];
        if ($this->footer->quick_links && is_array($this->footer->quick_links)) {
            $this->quick_links = $this->footer->quick_links;
        }

        // Ensure we have at least one empty quick link
        if (empty($this->quick_links)) {
            $this->quick_links[] = ['title' => '', 'url' => ''];
        }
    }

    private function setDefaultValues()
    {
        $this->company_name = 'OSR Digital';
        $this->company_description = 'Premium movie distribution company bringing exceptional films to global audiences through strategic digital and theatrical distribution.';
        $this->email = 'hello@osrdigital.com';
        $this->phone = '+1 (555) 123-4567';
        $this->website = 'https://osrdigital.com';
        $this->address = 'Los Angeles, CA';
        $this->copyright_text = '© 2025 OSR Digital. All rights reserved.';

        $this->social_links = [
            ['platform' => 'facebook', 'url' => ''],
            ['platform' => 'twitter', 'url' => ''],
            ['platform' => 'linkedin', 'url' => ''],
            ['platform' => 'instagram', 'url' => ''],
            ['platform' => 'youtube', 'url' => '']
        ];

        $this->quick_links = [
            ['title' => 'Home', 'url' => '/'],
            ['title' => 'About', 'url' => '/about'],
            ['title' => 'Portfolio', 'url' => '/portfolio'],
            ['title' => 'Contact', 'url' => '/contact']
        ];
    }

    public function addSocialLink()
    {
        $this->social_links[] = [
            'platform' => 'facebook',
            'url' => ''
        ];
    }

    public function removeSocialLink($index)
    {
        unset($this->social_links[$index]);
        $this->social_links = array_values($this->social_links);

        // Ensure we always have at least one social link
        if (empty($this->social_links)) {
            $this->social_links[] = ['platform' => 'facebook', 'url' => ''];
        }
    }

    public function addQuickLink()
    {
        $this->quick_links[] = [
            'title' => '',
            'url' => ''
        ];
    }

    public function removeQuickLink($index)
    {
        unset($this->quick_links[$index]);
        $this->quick_links = array_values($this->quick_links);

        // Ensure we always have at least one quick link
        if (empty($this->quick_links)) {
            $this->quick_links[] = ['title' => '', 'url' => ''];
        }
    }

    public function save()
    {
        // Filter out empty social links
        $filteredSocialLinks = array_filter($this->social_links, function($link) {
            return !empty($link['url']);
        });

        // Filter out empty quick links
        $filteredQuickLinks = array_filter($this->quick_links, function($link) {
            return !empty($link['title']) && !empty($link['url']);
        });

        // Update validation rules for filtered data
        $this->social_links = array_values($filteredSocialLinks);
        $this->quick_links = array_values($filteredQuickLinks);

        $this->validate();

        try {
            $data = [
                'company_name' => $this->company_name,
                'company_description' => $this->company_description,
                'email' => $this->email,
                'phone' => $this->phone,
                'website' => $this->website,
                'address' => $this->address,
                'copyright_text' => $this->copyright_text,
                'social_links' => $this->social_links,
                'quick_links' => $this->quick_links,
                'is_active' => $this->is_active,
            ];

            if ($this->footer) {
                $this->footer->update($data);
                session()->flash('success', 'Footer settings updated successfully!');
            } else {
                FooterSettingsModel::create($data);
                session()->flash('success', 'Footer settings created successfully!');
            }

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget('footer_settings');

        } catch (\Exception $e) {
            session()->flash('error', 'Error saving footer settings: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.footer-settings');
    }
}
