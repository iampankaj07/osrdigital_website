<?php

namespace App\Livewire\Admin\TrustedPartners;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TrustedPartner;

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
        'name' => '',
        'description' => '',
        'logo' => '',
        'website_url' => '',
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
        $this->form['sort_order'] = TrustedPartner::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $trustedPartner = TrustedPartner::findOrFail($id);
        
        $this->form = [
            'name' => $trustedPartner->name,
            'description' => $trustedPartner->description,
            'logo' => $trustedPartner->logo,
            'website_url' => $trustedPartner->website_url,
            'sort_order' => $trustedPartner->sort_order,
            'is_active' => $trustedPartner->is_active,
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
            'form.name' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.logo' => 'nullable|string|max:255',
            'form.website_url' => 'nullable|url|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        TrustedPartner::create($this->form);
        
        $this->isCreating = false;
        $this->reset('form');
        
        session()->flash('success', 'Trusted Partner created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.logo' => 'nullable|string|max:255',
            'form.website_url' => 'nullable|url|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        $trustedPartner = TrustedPartner::findOrFail($this->editingId);
        $trustedPartner->update($this->form);
        
        $this->editingId = null;
        $this->reset('form');
        
        session()->flash('success', 'Trusted Partner updated successfully!');
    }

    public function delete($id)
    {
        $trustedPartner = TrustedPartner::findOrFail($id);
        $trustedPartner->delete();
        
        session()->flash('success', 'Trusted Partner deleted successfully!');
    }

    public function toggleActive($id)
    {
        $trustedPartner = TrustedPartner::findOrFail($id);
        $trustedPartner->update(['is_active' => !$trustedPartner->is_active]);
        
        session()->flash('success', 'Trusted Partner status updated successfully!');
    }

    public function render()
    {
        $trustedPartners = TrustedPartner::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.trusted-partners.index', compact('trustedPartners'))
            ->layout('admin.layout', ['title' => 'Trusted Partners']);
    }
}
