<?php

namespace App\Livewire\Admin\DistributionServices;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DistributionService;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';
    
    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'title' => '',
        'description' => '',
        'icon_type' => 'font-awesome',
        'icon_data' => '',
        'link' => '',
        'is_active' => true,
        'sort_order' => 0,
    ];

    public $iconSearch = '';
    public $showIconDropdown = false;
    public $selectedIconField = '';

    // Common FontAwesome icons for distribution services
    public $availableIcons = [
        'fas fa-play' => 'Play',
        'fas fa-pause' => 'Pause',
        'fas fa-stop' => 'Stop',
        'fas fa-forward' => 'Forward',
        'fas fa-backward' => 'Backward',
        'fas fa-step-forward' => 'Step Forward',
        'fas fa-step-backward' => 'Step Backward',
        'fas fa-fast-forward' => 'Fast Forward',
        'fas fa-fast-backward' => 'Fast Backward',
        'fas fa-video' => 'Video',
        'fas fa-film' => 'Film',
        'fas fa-camera' => 'Camera',
        'fas fa-microphone' => 'Microphone',
        'fas fa-volume-up' => 'Volume Up',
        'fas fa-volume-down' => 'Volume Down',
        'fas fa-volume-mute' => 'Volume Mute',
        'fas fa-headphones' => 'Headphones',
        'fas fa-music' => 'Music',
        'fas fa-sound' => 'Sound',
        'fas fa-broadcast-tower' => 'Broadcast Tower',
        'fas fa-satellite-dish' => 'Satellite Dish',
        'fas fa-tv' => 'TV',
        'fas fa-desktop' => 'Desktop',
        'fas fa-laptop' => 'Laptop',
        'fas fa-mobile-alt' => 'Mobile',
        'fas fa-tablet-alt' => 'Tablet',
        'fas fa-monitor' => 'Monitor',
        'fas fa-display' => 'Display',
        'fas fa-projector' => 'Projector',
        'fas fa-download' => 'Download',
        'fas fa-upload' => 'Upload',
        'fas fa-cloud' => 'Cloud',
        'fas fa-cloud-download-alt' => 'Cloud Download',
        'fas fa-cloud-upload-alt' => 'Cloud Upload',
        'fas fa-server' => 'Server',
        'fas fa-database' => 'Database',
        'fas fa-hdd' => 'Hard Drive',
        'fas fa-save' => 'Save',
        'fas fa-folder' => 'Folder',
        'fas fa-folder-open' => 'Folder Open',
        'fas fa-file' => 'File',
        'fas fa-file-alt' => 'File Alt',
        'fas fa-file-video' => 'File Video',
        'fas fa-file-audio' => 'File Audio',
        'fas fa-file-image' => 'File Image',
        'fas fa-file-pdf' => 'File PDF',
        'fas fa-file-word' => 'File Word',
        'fas fa-file-excel' => 'File Excel',
        'fas fa-file-powerpoint' => 'File PowerPoint',
        'fas fa-file-archive' => 'File Archive',
        'fas fa-file-code' => 'File Code',
        'fas fa-file-csv' => 'File CSV',
        'fas fa-file-export' => 'File Export',
        'fas fa-file-import' => 'File Import',
        'fas fa-file-invoice' => 'File Invoice',
        'fas fa-file-invoice-dollar' => 'File Invoice Dollar',
        'fas fa-file-medical' => 'File Medical',
        'fas fa-file-prescription' => 'File Prescription',
        'fas fa-file-signature' => 'File Signature',
        'fas fa-file-upload' => 'File Upload',
        'fas fa-file-download' => 'File Download',
        'fas fa-file-edit' => 'File Edit',
        'fas fa-file-excel' => 'File Excel',
        'fas fa-file-image' => 'File Image',
        'fas fa-file-medical-alt' => 'File Medical Alt',
        'fas fa-file-pdf' => 'File PDF',
        'fas fa-file-powerpoint' => 'File PowerPoint',
        'fas fa-file-video' => 'File Video',
        'fas fa-file-word' => 'File Word',
        'fas fa-share' => 'Share',
        'fas fa-share-alt' => 'Share Alt',
        'fas fa-share-square' => 'Share Square',
        'fas fa-link' => 'Link',
        'fas fa-external-link-alt' => 'External Link',
        'fas fa-external-link-square-alt' => 'External Link Square',
        'fas fa-chain' => 'Chain',
        'fas fa-unlink' => 'Unlink',
        'fas fa-globe' => 'Globe',
        'fas fa-globe-americas' => 'Globe Americas',
        'fas fa-globe-asia' => 'Globe Asia',
        'fas fa-globe-africa' => 'Globe Africa',
        'fas fa-globe-europe' => 'Globe Europe',
        'fas fa-wifi' => 'WiFi',
        'fas fa-bluetooth' => 'Bluetooth',
        'fas fa-bluetooth-b' => 'Bluetooth B',
        'fas fa-ethernet' => 'Ethernet',
        'fas fa-network-wired' => 'Network Wired',
        'fas fa-satellite' => 'Satellite',
        'fas fa-satellite-dish' => 'Satellite Dish',
        'fas fa-broadcast-tower' => 'Broadcast Tower',
        'fas fa-antenna' => 'Antenna',
        'fas fa-signal' => 'Signal',
        'fas fa-wifi' => 'WiFi',
        'fas fa-broadcast-tower' => 'Broadcast Tower',
        'fas fa-satellite-dish' => 'Satellite Dish',
        'fas fa-tv' => 'TV',
        'fas fa-radio' => 'Radio',
        'fas fa-podcast' => 'Podcast',
        'fas fa-stream' => 'Stream',
        'fas fa-broadcast-tower' => 'Broadcast Tower',
        'fas fa-satellite-dish' => 'Satellite Dish',
        'fas fa-tv' => 'TV',
        'fas fa-radio' => 'Radio',
        'fas fa-podcast' => 'Podcast',
        'fas fa-stream' => 'Stream',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->isCreating = true;
        $this->editingId = null;
        $this->reset('form');
        $this->form['sort_order'] = DistributionService::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $service = DistributionService::findOrFail($id);
        
        $this->form = [
            'title' => $service->title,
            'description' => $service->description,
            'icon_type' => $service->icon_type,
            'icon_data' => $service->icon_data,
            'link' => $service->link,
            'is_active' => $service->is_active,
            'sort_order' => $service->sort_order,
        ];
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->reset('form');
    }

    public function store()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.icon_type' => 'required|in:font-awesome,svg,image',
            'form.icon_data' => 'required|string|max:255',
            'form.link' => 'nullable|url|max:500',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        DistributionService::create($this->form);
        
        $this->isCreating = false;
        $this->reset('form');
        
        session()->flash('success', 'Distribution Service created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.icon_type' => 'required|in:font-awesome,svg,image',
            'form.icon_data' => 'required|string|max:255',
            'form.link' => 'nullable|url|max:500',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $service = DistributionService::findOrFail($this->editingId);
        $service->update($this->form);
        
        $this->editingId = null;
        $this->reset('form');
        
        session()->flash('success', 'Distribution Service updated successfully!');
    }

    public function delete($id)
    {
        $service = DistributionService::findOrFail($id);
        $service->delete();
        
        session()->flash('success', 'Distribution Service deleted successfully!');
    }

    public function toggleActive($id)
    {
        $service = DistributionService::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);
        
        session()->flash('success', 'Distribution Service status updated successfully!');
    }

    public function openIconDropdown()
    {
        $this->showIconDropdown = true;
        $this->iconSearch = '';
    }

    public function closeIconDropdown()
    {
        $this->showIconDropdown = false;
        $this->iconSearch = '';
    }

    public function selectIcon($iconClass)
    {
        $this->form['icon_data'] = $iconClass;
        $this->closeIconDropdown();
    }

    public function clearIcon()
    {
        $this->form['icon_data'] = '';
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
        $services = DistributionService::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.distribution-services.index', compact('services'))
            ->layout('admin.layout', ['title' => 'Distribution Services']);
    }
}