<?php

namespace App\Livewire\Admin\TeamValues;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TeamValue;


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
        $this->form['sort_order'] = TeamValue::max('sort_order') + 1;
        $this->showSlidePanel = true;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $teamValue = TeamValue::findOrFail($id);
        
        $this->form = [
            'title' => $teamValue->title,
            'description' => $teamValue->description,
            'icon' => $teamValue->icon,
            'sort_order' => $teamValue->sort_order,
            'is_active' => $teamValue->is_active,
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

        TeamValue::create($this->form);
        
        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->reset('form');
        
        session()->flash('success', 'Team Value created successfully!');
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

        $teamValue = TeamValue::findOrFail($this->editingId);
        $teamValue->update($this->form);
        
        $this->editingId = null;
        $this->showSlidePanel = false;
        $this->reset('form');
        
        session()->flash('success', 'Team Value updated successfully!');
    }

    public function delete($id)
    {
        $teamValue = TeamValue::findOrFail($id);
        $teamValue->delete();
        
        session()->flash('success', 'Team Value deleted successfully!');
    }

    public function toggleActive($id)
    {
        $teamValue = TeamValue::findOrFail($id);
        $teamValue->update(['is_active' => !$teamValue->is_active]);
        
        session()->flash('success', 'Team Value status updated successfully!');
    }

    public function render()
    {
        $teamValues = TeamValue::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.team-values.index', compact('teamValues'))
            ->layout('admin.layout', ['title' => 'Team Values']);
    }
}
