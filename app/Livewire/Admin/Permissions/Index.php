<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use App\Traits\DispatchesAlertEvents;


class Index extends Component
{
    use WithPagination, DispatchesAlertEvents;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // Bulk operations
    public $selectedItems = [];
    public $selectAll = false;
    public $showBulkDeleteModal = false;
    
    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'name' => '',
        'guard_name' => 'web',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'name'],
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
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $permission = Permission::findOrFail($id);
        
        $this->form = [
            'name' => $permission->name,
            'guard_name' => $permission->guard_name,
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
            'form.name' => 'required|string|max:255|unique:permissions,name',
            'form.guard_name' => 'required|string|max:255',
        ]);

        Permission::create($this->form);
        
        $this->isCreating = false;
        $this->reset('form');
        
        $this->flashSuccess('Permission created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:permissions,name,' . $this->editingId,
            'form.guard_name' => 'required|string|max:255',
        ]);

        $permission = Permission::findOrFail($this->editingId);
        $permission->update($this->form);
        
        $this->editingId = null;
        $this->reset('form');
        
        $this->flashSuccess('Permission updated successfully!');
    }

    public function delete($id)
    {
        $permission = Permission::findOrFail($id);
        $permissionName = $permission->name;
        $permission->delete();
        
        $this->flashDelete("Permission '{$permissionName}' has been successfully deleted.");
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->permissions->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $this->selectAll = count($this->selectedItems) === $this->permissions->count();
    }

    public function openBulkDeleteModal()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Please select items to delete.');
            
            return;
        }
        $this->showBulkDeleteModal = true;
    }

    public function closeBulkDeleteModal()
    {
        $this->showBulkDeleteModal = false;
    }

    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'No items selected for deletion.');
            
            return;
        }

        Permission::whereIn('id', $this->selectedItems)->delete();
        
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->showBulkDeleteModal = false;
        
        session()->flash('success', 'Selected permissions deleted successfully!');
    }

    public function render()
    {
        $permissions = Permission::query()
            ->withCount('roles')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.permissions.index', compact('permissions'))
            ->layout('admin.layout', ['title' => 'Permissions']);
    }
}
