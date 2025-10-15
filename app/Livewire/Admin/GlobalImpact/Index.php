<?php

namespace App\Livewire\Admin\GlobalImpact;

use Livewire\Component;
use App\Models\AdminSettings;
use Illuminate\Support\Facades\Log;
use App\Traits\DispatchesAlertEvents;


class Index extends Component
{
    use DispatchesAlertEvents;

    public $form = [
        'title' => '',
        'subtitle' => '',
        'stats' => [
            ['number' => '', 'label' => '', 'icon' => ''],
            ['number' => '', 'label' => '', 'icon' => ''],
            ['number' => '', 'label' => '', 'icon' => ''],
            ['number' => '', 'label' => '', 'icon' => ''],
        ],
    ];

    public $iconSearch = '';
    public $showIconDropdown = false;
    public $selectedIconField = '';
    public $selectedStatIndex = 0;

    // Common FontAwesome icons for statistics
    public $availableIcons = [
        'fas fa-film' => 'Film',
        'fas fa-music' => 'Music',
        'fas fa-video' => 'Video',
        'fas fa-play' => 'Play',
        'fas fa-eye' => 'Eye',
        'fas fa-users' => 'Users',
        'fas fa-globe' => 'Globe',
        'fas fa-star' => 'Star',
        'fas fa-trophy' => 'Trophy',
        'fas fa-award' => 'Award',
        'fas fa-medal' => 'Medal',
        'fas fa-gem' => 'Gem',
        'fas fa-fire' => 'Fire',
        'fas fa-bolt' => 'Bolt',
        'fas fa-heart' => 'Heart',
        'fas fa-thumbs-up' => 'Thumbs Up',
        'fas fa-handshake' => 'Handshake',
        'fas fa-flag' => 'Flag',
        'fas fa-rocket' => 'Rocket',
        'fas fa-chart-line' => 'Chart Line',
        'fas fa-chart-bar' => 'Chart Bar',
        'fas fa-chart-pie' => 'Chart Pie',
        'fas fa-percentage' => 'Percentage',
        'fas fa-calculator' => 'Calculator',
        'fas fa-infinity' => 'Infinity',
        'fas fa-target' => 'Target',
        'fas fa-bullseye' => 'Bullseye',
        'fas fa-compass' => 'Compass',
        'fas fa-mountain' => 'Mountain',
        'fas fa-sun' => 'Sun',
        'fas fa-moon' => 'Moon',
        'fas fa-leaf' => 'Leaf',
        'fas fa-tree' => 'Tree',
        'fas fa-seedling' => 'Seedling',
        'fas fa-recycle' => 'Recycle',
        'fas fa-shield-alt' => 'Shield',
        'fas fa-lock' => 'Lock',
        'fas fa-key' => 'Key',
        'fas fa-unlock' => 'Unlock',
        'fas fa-crown' => 'Crown',
        'fas fa-diamond' => 'Diamond',
        'fas fa-coins' => 'Coins',
        'fas fa-dollar-sign' => 'Dollar Sign',
        'fas fa-euro-sign' => 'Euro Sign',
        'fas fa-pound-sign' => 'Pound Sign',
        'fas fa-yen-sign' => 'Yen Sign',
        'fas fa-rupee-sign' => 'Rupee Sign',
        'fas fa-bitcoin-sign' => 'Bitcoin Sign',
        'fas fa-credit-card' => 'Credit Card',
        'fas fa-wallet' => 'Wallet',
        'fas fa-piggy-bank' => 'Piggy Bank',
        'fas fa-chart-area' => 'Chart Area',
        'fas fa-chart-gantt' => 'Chart Gantt',
        'fas fa-chart-network' => 'Chart Network',
        'fas fa-chart-scatter' => 'Chart Scatter',
        'fas fa-chart-scatter-3d' => 'Chart Scatter 3D',
        'fas fa-chart-scatter-bubble' => 'Chart Scatter Bubble',
        'fas fa-chart-scatter-bubble-3d' => 'Chart Scatter Bubble 3D',
    ];

    public function mount()
    {
        $this->loadGlobalImpact();
    }

    public function loadGlobalImpact()
    {
        $settings = AdminSettings::getGroup('global_impact');

        $this->form = [
            'title' => $settings['global_impact_title'] ?? 'Our Global Impact',
            'subtitle' => $settings['global_impact_subtitle'] ?? 'Numbers that speak to our commitment to bringing quality content to global audiences',
            'stats' => $settings['global_impact_stats'] ?? [
                ['number' => '500+', 'label' => 'Movies Published', 'icon' => 'fas fa-film'],
                ['number' => '2,000+', 'label' => 'Songs Released', 'icon' => 'fas fa-music'],
                ['number' => '800+', 'label' => 'Short Films', 'icon' => 'fas fa-video'],
                ['number' => '50M+', 'label' => 'Total Views', 'icon' => 'fas fa-eye'],
            ],
        ];
    }

    public function save()
    {
        try {
            $this->validate([
                'form.title' => 'required|string|max:255',
                'form.subtitle' => 'required|string|max:500',
                'form.stats' => 'required|array|min:1|max:6',
                'form.stats.*.number' => 'required|string|max:50',
                'form.stats.*.label' => 'required|string|max:100',
                'form.stats.*.icon' => 'nullable|string|max:255',
            ]);

            // Log the data being saved for debugging
            Log::info('Global Impact save attempt', [
                'title' => $this->form['title'],
                'subtitle' => $this->form['subtitle'],
                'stats' => $this->form['stats']
            ]);

            // Update title and subtitle
            AdminSettings::set('global_impact_title', $this->form['title'], 'string', 'global_impact', 'Global Impact section title', true);
            AdminSettings::set('global_impact_subtitle', $this->form['subtitle'], 'string', 'global_impact', 'Global Impact section subtitle', true);

            // Update stats
            AdminSettings::set('global_impact_stats', $this->form['stats'], 'json', 'global_impact', 'Global Impact statistics', true);

            // Clear all related cache keys
            \Illuminate\Support\Facades\Cache::forget('global_impact_settings');
            \Illuminate\Support\Facades\Cache::forget('public_settings');
            \Illuminate\Support\Facades\Cache::forget('admin_settings_group_global_impact');

            $this->flashSuccess('Global Impact settings saved successfully!');

            // Reload the data to reflect changes
            $this->loadGlobalImpact();

        } catch (\Exception $e) {
            Log::error('Global Impact save error: ' . $e->getMessage());
            $this->flashError('Error saving Global Impact settings: ' . $e->getMessage());
            
        }
    }

    public function addStat()
    {
        if (count($this->form['stats']) < 6) {
            $this->form['stats'][] = ['number' => '', 'label' => '', 'icon' => ''];
        }
    }

    public function updatedForm()
    {
        // This method will be called whenever form data changes
        Log::info('Form data updated', $this->form);
    }

    public function removeStat($index)
    {
        if (count($this->form['stats']) > 1) {
            unset($this->form['stats'][$index]);
            $this->form['stats'] = array_values($this->form['stats']);
        }
    }

    public function openIconDropdown($statIndex)
    {
        $this->selectedIconField = 'stat';
        $this->selectedStatIndex = $statIndex;
        $this->showIconDropdown = true;
        $this->iconSearch = '';
    }

    public function closeIconDropdown()
    {
        $this->showIconDropdown = false;
        $this->selectedIconField = '';
        $this->selectedStatIndex = 0;
        $this->iconSearch = '';
    }

    public function selectIcon($iconClass)
    {
        if ($this->selectedIconField === 'stat') {
            $this->form['stats'][$this->selectedStatIndex]['icon'] = $iconClass;
        }

        $this->closeIconDropdown();
    }

    public function clearIcon($statIndex)
    {
        $this->form['stats'][$statIndex]['icon'] = '';
    }

    public function getFilteredIcons()
    {
        if (empty($this->iconSearch)) {
            return $this->availableIcons;
        }

        return collect($this->availableIcons)
            ->filter(function ($name, $iconClass) {
                return stripos($name, $this->iconSearch) !== false ||
                       stripos($iconClass, $this->iconSearch) !== false;
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.global-impact.index', [
            'title' => 'Global Impact Settings'
        ]);
    }
}
