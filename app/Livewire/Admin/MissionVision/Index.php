<?php

namespace App\Livewire\Admin\MissionVision;

use Livewire\Component;
use App\Models\MissionVision;

class Index extends Component
{
    public $form = [
        'mission_title' => '',
        'mission_description' => '',
        'mission_icon' => '',
        'vision_title' => '',
        'vision_description' => '',
        'vision_icon' => '',
        'is_active' => true,
    ];

    public $iconSearch = '';
    public $showIconDropdown = false;
    public $selectedIconField = '';

    // Common FontAwesome icons for mission/vision
    public $availableIcons = [
        'fas fa-bullseye' => 'Bullseye',
        'fas fa-eye' => 'Eye',
        'fas fa-target' => 'Target',
        'fas fa-rocket' => 'Rocket',
        'fas fa-star' => 'Star',
        'fas fa-heart' => 'Heart',
        'fas fa-lightbulb' => 'Lightbulb',
        'fas fa-trophy' => 'Trophy',
        'fas fa-flag' => 'Flag',
        'fas fa-compass' => 'Compass',
        'fas fa-mountain' => 'Mountain',
        'fas fa-globe' => 'Globe',
        'fas fa-users' => 'Users',
        'fas fa-handshake' => 'Handshake',
        'fas fa-chart-line' => 'Chart Line',
        'fas fa-gem' => 'Gem',
        'fas fa-fire' => 'Fire',
        'fas fa-leaf' => 'Leaf',
        'fas fa-sun' => 'Sun',
        'fas fa-moon' => 'Moon',
        'fas fa-shield-alt' => 'Shield',
        'fas fa-key' => 'Key',
        'fas fa-unlock' => 'Unlock',
        'fas fa-crown' => 'Crown',
        'fas fa-diamond' => 'Diamond',
        'fas fa-infinity' => 'Infinity',
        'fas fa-puzzle-piece' => 'Puzzle Piece',
        'fas fa-cogs' => 'Cogs',
        'fas fa-wrench' => 'Wrench',
        'fas fa-tools' => 'Tools',
    ];

    public function mount()
    {
        $this->loadMissionVision();
    }

    public function loadMissionVision()
    {
        $missionVision = MissionVision::first();
        
        if ($missionVision) {
            $this->form = [
                'mission_title' => $missionVision->mission_title,
                'mission_description' => $missionVision->mission_description,
                'mission_icon' => $missionVision->mission_icon,
                'vision_title' => $missionVision->vision_title,
                'vision_description' => $missionVision->vision_description,
                'vision_icon' => $missionVision->vision_icon,
                'is_active' => $missionVision->is_active,
            ];
        }
    }

    public function save()
    {
        $this->validate([
            'form.mission_title' => 'required|string|max:255',
            'form.mission_description' => 'required|string',
            'form.mission_icon' => 'nullable|string|max:255',
            'form.vision_title' => 'required|string|max:255',
            'form.vision_description' => 'required|string',
            'form.vision_icon' => 'nullable|string|max:255',
            'form.is_active' => 'boolean',
        ]);

        $missionVision = MissionVision::first();
        
        if ($missionVision) {
            $missionVision->update($this->form);
        } else {
            MissionVision::create($this->form);
        }
        
        session()->flash('success', 'Mission & Vision saved successfully!');
    }

    public function openIconDropdown($field)
    {
        $this->selectedIconField = $field;
        $this->showIconDropdown = true;
        $this->iconSearch = '';
    }

    public function closeIconDropdown()
    {
        $this->showIconDropdown = false;
        $this->selectedIconField = '';
        $this->iconSearch = '';
    }

    public function selectIcon($iconClass)
    {
        if ($this->selectedIconField === 'mission') {
            $this->form['mission_icon'] = $iconClass;
        } elseif ($this->selectedIconField === 'vision') {
            $this->form['vision_icon'] = $iconClass;
        }
        
        $this->closeIconDropdown();
    }

    public function clearIcon($field)
    {
        if ($field === 'mission') {
            $this->form['mission_icon'] = '';
        } elseif ($field === 'vision') {
            $this->form['vision_icon'] = '';
        }
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
        return view('livewire.admin.mission-vision.index')
            ->layout('admin.layout', ['title' => 'Mission & Vision']);
    }
}
