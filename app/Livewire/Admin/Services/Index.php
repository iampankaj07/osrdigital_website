<?php

namespace App\Livewire\Admin\Services;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;
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
        'short_description' => '',
        'icon' => '',
        'image' => '',
        'is_featured' => false,
        'is_active' => true,
        'sort_order' => 0,
        'slug' => '',
    ];

    public $iconSearch = '';
    public $showIconDropdown = false;
    public $selectedIconField = '';

    // Common FontAwesome icons for services
    public $availableIcons = [
        'fas fa-video' => 'Video',
        'fas fa-camera' => 'Camera',
        'fas fa-microphone' => 'Microphone',
        'fas fa-edit' => 'Edit',
        'fas fa-paint-brush' => 'Paint Brush',
        'fas fa-palette' => 'Palette',
        'fas fa-magic' => 'Magic',
        'fas fa-wand-magic-sparkles' => 'Magic Wand',
        'fas fa-film' => 'Film',
        'fas fa-play' => 'Play',
        'fas fa-stop' => 'Stop',
        'fas fa-pause' => 'Pause',
        'fas fa-volume-up' => 'Volume Up',
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
        'fas fa-lightbulb' => 'Lightbulb',
        'fas fa-bolt' => 'Bolt',
        'fas fa-fire' => 'Fire',
        'fas fa-star' => 'Star',
        'fas fa-gem' => 'Gem',
        'fas fa-crown' => 'Crown',
        'fas fa-trophy' => 'Trophy',
        'fas fa-medal' => 'Medal',
        'fas fa-award' => 'Award',
        'fas fa-certificate' => 'Certificate',
        'fas fa-badge' => 'Badge',
        'fas fa-ribbon' => 'Ribbon',
        'fas fa-flag' => 'Flag',
        'fas fa-bullhorn' => 'Bullhorn',
        'fas fa-megaphone' => 'Megaphone',
        'fas fa-loudspeaker' => 'Loudspeaker',
        'fas fa-announcement' => 'Announcement',
        'fas fa-presentation' => 'Presentation',
        'fas fa-chalkboard' => 'Chalkboard',
        'fas fa-chalkboard-teacher' => 'Chalkboard Teacher',
        'fas fa-graduation-cap' => 'Graduation Cap',
        'fas fa-book' => 'Book',
        'fas fa-book-open' => 'Book Open',
        'fas fa-scroll' => 'Scroll',
        'fas fa-file-alt' => 'File Alt',
        'fas fa-document' => 'Document',
        'fas fa-clipboard' => 'Clipboard',
        'fas fa-paper-plane' => 'Paper Plane',
        'fas fa-envelope' => 'Envelope',
        'fas fa-mail-bulk' => 'Mail Bulk',
        'fas fa-bullseye' => 'Bullseye',
        'fas fa-target' => 'Target',
        'fas fa-crosshairs' => 'Crosshairs',
        'fas fa-scope' => 'Scope',
        'fas fa-telescope' => 'Telescope',
        'fas fa-microscope' => 'Microscope',
        'fas fa-binoculars' => 'Binoculars',
        'fas fa-eye' => 'Eye',
        'fas fa-eye-slash' => 'Eye Slash',
        'fas fa-search' => 'Search',
        'fas fa-search-plus' => 'Search Plus',
        'fas fa-search-minus' => 'Search Minus',
        'fas fa-magnifying-glass' => 'Magnifying Glass',
        'fas fa-fingerprint' => 'Fingerprint',
        'fas fa-id-card' => 'ID Card',
        'fas fa-address-card' => 'Address Card',
        'fas fa-credit-card' => 'Credit Card',
        'fas fa-wallet' => 'Wallet',
        'fas fa-money-bill' => 'Money Bill',
        'fas fa-coins' => 'Coins',
        'fas fa-dollar-sign' => 'Dollar Sign',
        'fas fa-euro-sign' => 'Euro Sign',
        'fas fa-pound-sign' => 'Pound Sign',
        'fas fa-yen-sign' => 'Yen Sign',
        'fas fa-rupee-sign' => 'Rupee Sign',
        'fas fa-ruble-sign' => 'Ruble Sign',
        'fas fa-shekel-sign' => 'Shekel Sign',
        'fas fa-won-sign' => 'Won Sign',
        'fas fa-bitcoin-sign' => 'Bitcoin Sign',
        'fas fa-ethereum' => 'Ethereum',
        'fas fa-litecoin' => 'Litecoin',
        'fas fa-monero' => 'Monero',
        'fas fa-bitcoin' => 'Bitcoin',
        'fas fa-cc-visa' => 'Visa',
        'fas fa-cc-mastercard' => 'Mastercard',
        'fas fa-cc-amex' => 'American Express',
        'fas fa-cc-paypal' => 'PayPal',
        'fas fa-cc-stripe' => 'Stripe',
        'fas fa-cc-apple-pay' => 'Apple Pay',
        'fas fa-cc-google-pay' => 'Google Pay',
        'fas fa-cc-amazon-pay' => 'Amazon Pay',
        'fas fa-cc-discover' => 'Discover',
        'fas fa-cc-diners-club' => 'Diners Club',
        'fas fa-cc-jcb' => 'JCB',
        'fas fa-cc-unionpay' => 'UnionPay',
        'fas fa-cc-mir' => 'Mir',
        'fas fa-cc-elo' => 'Elo',
        'fas fa-cc-hipercard' => 'Hipercard',
        'fas fa-cc-aura' => 'Aura',
        'fas fa-cc-dankort' => 'Dankort',
        'fas fa-cc-maestro' => 'Maestro',
        'fas fa-cc-mir' => 'Mir',
        'fas fa-cc-unionpay' => 'UnionPay',
        'fas fa-cc-elo' => 'Elo',
        'fas fa-cc-hipercard' => 'Hipercard',
        'fas fa-cc-aura' => 'Aura',
        'fas fa-cc-dankort' => 'Dankort',
        'fas fa-cc-maestro' => 'Maestro',
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
        $this->form['sort_order'] = Service::max('sort_order') + 1;
        $this->showSlidePanel = true;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $service = Service::findOrFail($id);

        $this->form = [
            'title' => $service->title,
            'description' => $service->description,
            'short_description' => $service->short_description,
            'icon' => $service->icon,
            'image' => $service->image,
            'is_featured' => $service->is_featured,
            'is_active' => $service->is_active,
            'sort_order' => $service->sort_order,
            'slug' => $service->slug,
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
            'form.short_description' => 'nullable|string|max:500',
            'form.icon' => 'nullable|string|max:255',
            'form.image' => 'nullable|string|max:255',
            'form.is_featured' => 'boolean',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
            'form.slug' => 'nullable|string|max:255',
        ]);

        Service::create($this->form);

        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->reset('form');

        $this->dispatchSuccessEvent('Service created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.short_description' => 'nullable|string|max:500',
            'form.icon' => 'nullable|string|max:255',
            'form.image' => 'nullable|string|max:255',
            'form.is_featured' => 'boolean',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
            'form.slug' => 'nullable|string|max:255',
        ]);

        $service = Service::findOrFail($this->editingId);
        $service->update($this->form);

        $this->editingId = null;
        $this->showSlidePanel = false;
        $this->reset('form');

        $this->dispatchSuccessEvent('Service updated successfully!');
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);
        $serviceName = $service->title;
        $service->delete();

        $this->dispatchDeleteEvent("Service '{$serviceName}' has been successfully deleted.");
    }

    public function toggleActive($id)
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);

    }

    public function toggleFeatured($id)
    {
        $service = Service::findOrFail($id);
        $service->update(['is_featured' => !$service->is_featured]);

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
        $this->form['icon'] = $iconClass;
        $this->closeIconDropdown();
    }

    public function clearIcon()
    {
        $this->form['icon'] = '';
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
        $services = Service::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('short_description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.services.index', compact('services'));
    }
}
