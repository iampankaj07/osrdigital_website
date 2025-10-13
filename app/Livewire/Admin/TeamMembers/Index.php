<?php

namespace App\Livewire\Admin\TeamMembers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TeamMember;

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
        'position' => '',
        'department' => '',
        'avatar' => '',
        'linkedin' => '',
        'twitter' => '',
        'email' => '',
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
        $this->form['sort_order'] = TeamMember::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $teamMember = TeamMember::findOrFail($id);
        
        $this->form = [
            'name' => $teamMember->name,
            'position' => $teamMember->position,
            'department' => $teamMember->department,
            'avatar' => $teamMember->avatar,
            'linkedin' => $teamMember->linkedin,
            'twitter' => $teamMember->twitter,
            'email' => $teamMember->email,
            'sort_order' => $teamMember->sort_order,
            'is_active' => $teamMember->is_active,
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
            'form.position' => 'required|string|max:255',
            'form.department' => 'nullable|string|max:255',
            'form.avatar' => 'nullable|string|max:255',
            'form.linkedin' => 'nullable|url|max:255',
            'form.twitter' => 'nullable|url|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        TeamMember::create($this->form);
        
        $this->isCreating = false;
        $this->reset('form');
        
        session()->flash('success', 'Team Member created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.position' => 'required|string|max:255',
            'form.department' => 'nullable|string|max:255',
            'form.avatar' => 'nullable|string|max:255',
            'form.linkedin' => 'nullable|url|max:255',
            'form.twitter' => 'nullable|url|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        $teamMember = TeamMember::findOrFail($this->editingId);
        $teamMember->update($this->form);
        
        $this->editingId = null;
        $this->reset('form');
        
        session()->flash('success', 'Team Member updated successfully!');
    }

    public function delete($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $teamMember->delete();
        
        session()->flash('success', 'Team Member deleted successfully!');
    }

    public function toggleActive($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $teamMember->update(['is_active' => !$teamMember->is_active]);
        
        session()->flash('success', 'Team Member status updated successfully!');
    }

    public function render()
    {
        $teamMembers = TeamMember::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('position', 'like', '%' . $this->search . '%')
                      ->orWhere('department', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.team-members.index', compact('teamMembers'))
            ->layout('admin.layout', ['title' => 'Team Members']);
    }
}
