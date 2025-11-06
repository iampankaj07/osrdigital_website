<?php

namespace App\Livewire\Admin\PartnershipBenefits;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PartnershipBenefit;
use App\Traits\DispatchesAlertEvents;

class Index extends Component
{
    use WithPagination, DispatchesAlertEvents;

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
        'icon' => '',
        'sort_order' => 0,
        'is_active' => true,
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
        $this->form['sort_order'] = PartnershipBenefit::max('sort_order') + 1;
        $this->showSlidePanel = true;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $partnershipBenefit = PartnershipBenefit::findOrFail($id);

        $this->form = [
            'title' => $partnershipBenefit->title,
            'description' => $partnershipBenefit->description,
            'icon' => $partnershipBenefit->icon,
            'sort_order' => $partnershipBenefit->sort_order,
            'is_active' => $partnershipBenefit->is_active,
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
            'form.icon' => 'nullable|string|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        PartnershipBenefit::create($this->form);

        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->reset('form');

        $this->flashSuccess('Partnership Benefit created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.icon' => 'nullable|string|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        $partnershipBenefit = PartnershipBenefit::findOrFail($this->editingId);
        $partnershipBenefit->update($this->form);

        $this->editingId = null;
        $this->showSlidePanel = false;
        $this->reset('form');

        $this->flashSuccess('Partnership Benefit updated successfully!');
    }

    public function delete($id)
    {
        $partnershipBenefit = PartnershipBenefit::findOrFail($id);
        $benefitTitle = $partnershipBenefit->title;
        $partnershipBenefit->delete();

        $this->flashDelete("Partnership Benefit '{$benefitTitle}' has been successfully deleted.");
    }

    public function toggleActive($id)
    {
        $partnershipBenefit = PartnershipBenefit::findOrFail($id);
        $partnershipBenefit->update(['is_active' => !$partnershipBenefit->is_active]);

        session()->flash('success', 'Partnership Benefit status updated successfully!');
    }

    public function getAvailableIcons()
    {
        return [
            '' => '-- Select Icon --',
            'fas fa-gift' => 'Gift',
            'fas fa-star' => 'Star',
            'fas fa-heart' => 'Heart',
            'fas fa-trophy' => 'Trophy',
            'fas fa-medal' => 'Medal',
            'fas fa-award' => 'Award',
            'fas fa-certificate' => 'Certificate',
            'fas fa-handshake' => 'Handshake',
            'fas fa-users' => 'Users',
            'fas fa-user-friends' => 'User Friends',
            'fas fa-building' => 'Building',
            'fas fa-briefcase' => 'Briefcase',
            'fas fa-chart-line' => 'Chart Line',
            'fas fa-chart-bar' => 'Chart Bar',
            'fas fa-chart-pie' => 'Chart Pie',
            'fas fa-dollar-sign' => 'Dollar Sign',
            'fas fa-money-bill-wave' => 'Money Bill Wave',
            'fas fa-coins' => 'Coins',
            'fas fa-piggy-bank' => 'Piggy Bank',
            'fas fa-credit-card' => 'Credit Card',
            'fas fa-wallet' => 'Wallet',
            'fas fa-shopping-cart' => 'Shopping Cart',
            'fas fa-store' => 'Store',
            'fas fa-tag' => 'Tag',
            'fas fa-tags' => 'Tags',
            'fas fa-percent' => 'Percent',
            'fas fa-fire' => 'Fire',
            'fas fa-bolt' => 'Bolt',
            'fas fa-rocket' => 'Rocket',
            'fas fa-plane' => 'Plane',
            'fas fa-shipping-fast' => 'Shipping Fast',
            'fas fa-truck' => 'Truck',
            'fas fa-box' => 'Box',
            'fas fa-boxes' => 'Boxes',
            'fas fa-warehouse' => 'Warehouse',
            'fas fa-globe' => 'Globe',
            'fas fa-globe-americas' => 'Globe Americas',
            'fas fa-globe-europe' => 'Globe Europe',
            'fas fa-globe-asia' => 'Globe Asia',
            'fas fa-map-marker-alt' => 'Map Marker',
            'fas fa-map' => 'Map',
            'fas fa-route' => 'Route',
            'fas fa-compass' => 'Compass',
            'fas fa-flag' => 'Flag',
            'fas fa-flag-checkered' => 'Flag Checkered',
            'fas fa-thumbs-up' => 'Thumbs Up',
            'fas fa-thumbs-down' => 'Thumbs Down',
            'fas fa-check-circle' => 'Check Circle',
            'fas fa-check' => 'Check',
            'fas fa-check-double' => 'Check Double',
            'fas fa-times-circle' => 'Times Circle',
            'fas fa-exclamation-circle' => 'Exclamation Circle',
            'fas fa-info-circle' => 'Info Circle',
            'fas fa-question-circle' => 'Question Circle',
            'fas fa-shield-alt' => 'Shield',
            'fas fa-lock' => 'Lock',
            'fas fa-unlock' => 'Unlock',
            'fas fa-key' => 'Key',
            'fas fa-cog' => 'Cog',
            'fas fa-cogs' => 'Cogs',
            'fas fa-tools' => 'Tools',
            'fas fa-wrench' => 'Wrench',
            'fas fa-screwdriver' => 'Screwdriver',
            'fas fa-hammer' => 'Hammer',
            'fas fa-paint-brush' => 'Paint Brush',
            'fas fa-palette' => 'Palette',
            'fas fa-image' => 'Image',
            'fas fa-images' => 'Images',
            'fas fa-photo-video' => 'Photo Video',
            'fas fa-camera' => 'Camera',
            'fas fa-video' => 'Video',
            'fas fa-film' => 'Film',
            'fas fa-music' => 'Music',
            'fas fa-headphones' => 'Headphones',
            'fas fa-microphone' => 'Microphone',
            'fas fa-volume-up' => 'Volume Up',
            'fas fa-bell' => 'Bell',
            'fas fa-bell-slash' => 'Bell Slash',
            'fas fa-envelope' => 'Envelope',
            'fas fa-envelope-open' => 'Envelope Open',
            'fas fa-paper-plane' => 'Paper Plane',
            'fas fa-inbox' => 'Inbox',
            'fas fa-comment' => 'Comment',
            'fas fa-comments' => 'Comments',
            'fas fa-comment-dots' => 'Comment Dots',
            'fas fa-phone' => 'Phone',
            'fas fa-phone-alt' => 'Phone Alt',
            'fas fa-mobile-alt' => 'Mobile',
            'fas fa-tablet-alt' => 'Tablet',
            'fas fa-laptop' => 'Laptop',
            'fas fa-desktop' => 'Desktop',
            'fas fa-tv' => 'TV',
            'fas fa-wifi' => 'WiFi',
            'fas fa-signal' => 'Signal',
            'fas fa-broadcast-tower' => 'Broadcast Tower',
            'fas fa-satellite-dish' => 'Satellite Dish',
            'fas fa-cloud' => 'Cloud',
            'fas fa-cloud-download-alt' => 'Cloud Download',
            'fas fa-cloud-upload-alt' => 'Cloud Upload',
            'fas fa-database' => 'Database',
            'fas fa-server' => 'Server',
            'fas fa-hdd' => 'Hard Drive',
            'fas fa-save' => 'Save',
            'fas fa-download' => 'Download',
            'fas fa-upload' => 'Upload',
            'fas fa-folder' => 'Folder',
            'fas fa-folder-open' => 'Folder Open',
            'fas fa-file' => 'File',
            'fas fa-file-alt' => 'File Alt',
            'fas fa-file-pdf' => 'File PDF',
            'fas fa-file-word' => 'File Word',
            'fas fa-file-excel' => 'File Excel',
            'fas fa-file-powerpoint' => 'File PowerPoint',
            'fas fa-file-image' => 'File Image',
            'fas fa-file-video' => 'File Video',
            'fas fa-file-audio' => 'File Audio',
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
        ];
    }

    public function render()
    {
        $partnershipBenefits = PartnershipBenefit::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $availableIcons = $this->getAvailableIcons();

        return view('livewire.admin.partnership-benefits.index', compact('partnershipBenefits', 'availableIcons'));
    }
}
