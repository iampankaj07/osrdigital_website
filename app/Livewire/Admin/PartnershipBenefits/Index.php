<?php

namespace App\Livewire\Admin\PartnershipBenefits;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PartnershipBenefit;

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
            'form.icon' => 'nullable|string|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        PartnershipBenefit::create($this->form);
        
        $this->isCreating = false;
        $this->reset('form');
        
        session()->flash('success', 'Partnership Benefit created successfully!');
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
        $this->reset('form');
        
        session()->flash('success', 'Partnership Benefit updated successfully!');
    }

    public function delete($id)
    {
        $partnershipBenefit = PartnershipBenefit::findOrFail($id);
        $partnershipBenefit->delete();
        
        session()->flash('success', 'Partnership Benefit deleted successfully!');
    }

    public function toggleActive($id)
    {
        $partnershipBenefit = PartnershipBenefit::findOrFail($id);
        $partnershipBenefit->update(['is_active' => !$partnershipBenefit->is_active]);
        
        session()->flash('success', 'Partnership Benefit status updated successfully!');
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

        return view('livewire.admin.partnership-benefits.index', compact('partnershipBenefits'))
            ->layout('admin.layout', ['title' => 'Partnership Benefits']);
    }
}
