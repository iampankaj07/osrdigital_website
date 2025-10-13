<?php

namespace App\Livewire\Admin\Associates;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Associate;

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
        'logo' => '',
        'website' => '',
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
        $this->form['sort_order'] = Associate::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $associate = Associate::findOrFail($id);
        
        $this->form = [
            'name' => $associate->name,
            'logo' => $associate->logo,
            'website' => $associate->website,
            'sort_order' => $associate->sort_order,
            'is_active' => $associate->is_active,
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
            'form.logo' => 'nullable|string|max:255',
            'form.website' => 'nullable|url|max:255',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        Associate::create($this->form);
        
        $this->isCreating = false;
        $this->reset('form');
        
        session()->flash('success', 'Associate created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.logo' => 'nullable|string|max:255',
            'form.website' => 'nullable|url|max:255',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $associate = Associate::findOrFail($this->editingId);
        $associate->update($this->form);
        
        $this->editingId = null;
        $this->reset('form');
        
        session()->flash('success', 'Associate updated successfully!');
    }

    public function delete($id)
    {
        $associate = Associate::findOrFail($id);
        $associate->delete();
        
        session()->flash('success', 'Associate deleted successfully!');
    }

    public function toggleActive($id)
    {
        $associate = Associate::findOrFail($id);
        $associate->update(['is_active' => !$associate->is_active]);
        
        session()->flash('success', 'Associate status updated successfully!');
    }

    public function render()
    {
        $associates = Associate::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('website', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.associates.index', compact('associates'))
            ->layout('admin.layout', ['title' => 'Associates']);
    }
}
