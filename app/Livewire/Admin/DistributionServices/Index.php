<?php

namespace App\Livewire\Admin\DistributionServices;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DistributionService;
use App\Traits\DispatchesAlertEvents;
use App\Livewire\Admin\Traits\WithDeleteConfirmation;

class Index extends Component
{
    use WithPagination, DispatchesAlertEvents, WithDeleteConfirmation;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $showSlidePanel = false;
    public $isClosing = false;
    public $form = [
        'title' => '',
        'description' => '',
        'icon_type' => 'font-awesome',
        'icon_data' => '',
        'link' => '',
        'is_active' => true,
        'sort_order' => 0,
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
        $this->showSlidePanel = true;
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
        $this->showSlidePanel = true;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->reset('form');
        $this->showSlidePanel = false;
    }

    public function closeSlidePanel()
    {
        $this->isClosing = true;
        $this->dispatch('close-panel-animation');
    }

    public function finishClosing()
    {
        $this->showSlidePanel = false;
        $this->isClosing = false;
        $this->reset('form');
        $this->editingId = null;
        $this->isCreating = false;
    }

    public function store()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.icon_data' => 'required|string|max:255',
            'form.link' => 'nullable|url|max:500',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $this->form['icon_type'] = 'font-awesome';
        DistributionService::create($this->form);

        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->reset('form');

        $this->flashSuccess('Distribution Service created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.icon_data' => 'required|string|max:255',
            'form.link' => 'nullable|url|max:500',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $this->form['icon_type'] = 'font-awesome';
        $service = DistributionService::findOrFail($this->editingId);
        $service->update($this->form);

        $this->editingId = null;
        $this->showSlidePanel = false;
        $this->reset('form');

        $this->flashSuccess('Distribution Service updated successfully!');
    }

    public function delete($id)
    {
        // Legacy direct delete kept for backward compatibility; route through confirm system
        $this->performActualDelete($id);
    }

    // Renamed actual delete logic
    public function performActualDelete($id)
    {
        $service = DistributionService::findOrFail($id);
        $serviceName = $service->title;
        $service->delete();

        $this->flashDelete("Distribution Service '{$serviceName}' has been successfully deleted.");
    }

    public function toggleActive($id)
    {
        $service = DistributionService::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);

        session()->flash('success', 'Distribution Service status updated successfully!');
    }

    public function getAvailableIcons()
    {
        return [
            '' => '-- Select Icon --',
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
            'fas fa-broadcast-tower' => 'Broadcast Tower',
            'fas fa-satellite-dish' => 'Satellite Dish',
            'fas fa-tv' => 'TV',
            'fas fa-desktop' => 'Desktop',
            'fas fa-laptop' => 'Laptop',
            'fas fa-mobile-alt' => 'Mobile',
            'fas fa-tablet-alt' => 'Tablet',
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
            'fas fa-globe' => 'Globe',
            'fas fa-globe-americas' => 'Globe Americas',
            'fas fa-globe-europe' => 'Globe Europe',
            'fas fa-globe-asia' => 'Globe Asia',
            'fas fa-wifi' => 'WiFi',
            'fas fa-signal' => 'Signal',
            'fas fa-network-wired' => 'Network Wired',
            'fas fa-rss' => 'RSS',
            'fas fa-rss-square' => 'RSS Square',
            'fas fa-podcast' => 'Podcast',
            'fas fa-stream' => 'Stream',
            'fas fa-satellite' => 'Satellite',
            'fas fa-radio' => 'Radio',
        ];
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

        $availableIcons = $this->getAvailableIcons();

        return view('livewire.admin.distribution-services.index', compact('services', 'availableIcons'))
            ->layout('admin.layout', ['title' => 'Distribution Services']);
    }
}
