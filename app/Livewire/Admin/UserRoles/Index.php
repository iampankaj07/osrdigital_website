<?php

namespace App\Livewire\Admin\UserRoles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\DispatchesAlertEvents;

class Index extends Component
{
    use WithPagination, DispatchesAlertEvents;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $showSlidePanel = false;
    public $isClosing = false;
    public $form = [
        'name' => '',
        'guard_name' => 'web',
        'permissions' => [],
    ];

    // Permission assignment properties
    public $showPermissionModal = false;
    public $selectedRoleId = null;
    public $rolePermissions = [];
    public $availablePermissions = [];
    public $permissionSearch = '';
    public $permissionFilterCategory = '';
    
    // Bulk operations
    public $selectedItems = [];
    public $selectAll = false;
    public $showBulkDeleteModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'permissionSearch' => ['except' => ''],
        'permissionFilterCategory' => ['except' => ''],
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
        $this->resetForm();
        $this->isCreating = true;
        $this->editingId = null;
        $this->showSlidePanel = true;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $role = Role::findOrFail($id);
        
        $this->form = [
            'name' => $role->name,
            'guard_name' => $role->guard_name,
            'permissions' => $role->permissions->pluck('id')->toArray(),
        ];

        $this->showSlidePanel = true;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->resetForm();
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
        $this->resetForm();
        $this->editingId = null;
        $this->isCreating = false;
    }

    private function resetForm()
    {
        $this->form = [
            'name' => '',
            'guard_name' => 'web',
            'permissions' => [],
        ];
    }

    public function store()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:roles,name',
            'form.guard_name' => 'required|string|max:255',
            'form.permissions' => 'array',
        ]);

        $role = Role::create([
            'name' => $this->form['name'],
            'guard_name' => $this->form['guard_name'],
        ]);

        if (!empty($this->form['permissions'])) {
            // Filter out invalid permission IDs and sync only existing permissions
            $validPermissionIds = Permission::whereIn('id', $this->form['permissions'])->pluck('id')->toArray();
            $role->syncPermissions($validPermissionIds);
        }
        
        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->resetForm();
        
        $this->flashSuccess('Role created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:roles,name,' . $this->editingId,
            'form.guard_name' => 'required|string|max:255',
            'form.permissions' => 'array',
        ]);

        $role = Role::findOrFail($this->editingId);
        $role->update([
            'name' => $this->form['name'],
            'guard_name' => $this->form['guard_name'],
        ]);

        // Filter out invalid permission IDs and sync only existing permissions
        $permissionIds = $this->form['permissions'] ?? [];
        if (!empty($permissionIds)) {
            $validPermissionIds = Permission::whereIn('id', $permissionIds)->pluck('id')->toArray();
            $role->syncPermissions($validPermissionIds);
        } else {
            $role->syncPermissions([]);
        }
        
        $this->editingId = null;
        $this->showSlidePanel = false;
        $this->resetForm();
        
        $this->flashSuccess('Role updated successfully!');
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        
        $this->flashDelete('Role has been successfully deleted.');
    }

    public function mount()
    {
        $this->loadAvailablePermissions();
    }

    public function loadAvailablePermissions()
    {
        $this->availablePermissions = Permission::orderBy('name')->get();
    }

    public function openPermissionModal($roleId)
    {
        $this->selectedRoleId = $roleId;
        $role = Role::findOrFail($roleId);
        $this->rolePermissions = $role->permissions->pluck('id')->toArray();
        $this->showPermissionModal = true;
        $this->permissionSearch = '';
        $this->permissionFilterCategory = '';
    }

    public function closePermissionModal()
    {
        $this->showPermissionModal = false;
        $this->selectedRoleId = null;
        $this->rolePermissions = [];
        $this->permissionSearch = '';
        $this->permissionFilterCategory = '';
    }

    public function updateRolePermissions()
    {
        $role = Role::findOrFail($this->selectedRoleId);
        
        // Filter out invalid permission IDs and sync only existing permissions
        if (!empty($this->rolePermissions)) {
            $validPermissionIds = Permission::whereIn('id', $this->rolePermissions)->pluck('id')->toArray();
            $role->syncPermissions($validPermissionIds);
        } else {
            $role->syncPermissions([]);
        }
        
        $this->closePermissionModal();
        
        $this->flashSuccess('Role permissions updated successfully!');
    }

    public function getFilteredPermissions()
    {
        $permissions = $this->availablePermissions;

        if (!empty($this->permissionSearch)) {
            $permissions = $permissions->filter(function ($permission) {
                return stripos($permission->name, $this->permissionSearch) !== false;
            });
        }

        if (!empty($this->permissionFilterCategory)) {
            $permissions = $permissions->filter(function ($permission) {
                return strpos($permission->name, $this->permissionFilterCategory . '.') === 0;
            });
        }

        return $permissions;
    }

    public function getPermissionCategories()
    {
        return $this->availablePermissions
            ->map(function ($permission) {
                $parts = explode('.', $permission->name);
                return $parts[0] ?? 'general';
            })
            ->unique()
            ->sort()
            ->values();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->roles->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $this->selectAll = count($this->selectedItems) === $this->roles->count();
    }

    public function openBulkDeleteModal()
    {
        if (empty($this->selectedItems)) {
            $this->dispatchErrorEvent('Please select items to delete.');
            
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
            $this->dispatchErrorEvent('No items selected for deletion.');
            
            return;
        }

        Role::whereIn('id', $this->selectedItems)->delete();
        
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->showBulkDeleteModal = false;
        
        $this->flashSuccess('Selected roles deleted successfully!');
    }

    public function render()
    {
        $roles = Role::query()
            ->with(['permissions', 'users'])
            ->withCount('users')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.user-roles.index', compact('roles'))
            ->layout('admin.layout', ['title' => 'User Roles']);
    }
}
