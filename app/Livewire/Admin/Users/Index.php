<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Traits\DispatchesAlertEvents;
use App\Livewire\Admin\Traits\WithDeleteConfirmation;

class Index extends Component
{
    use WithPagination, DispatchesAlertEvents, WithDeleteConfirmation;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $filterRole = '';
    public $filterStatus = '';

    // Bulk operations
    public $selectedItems = [];
    public $selectAll = false;
    public $showBulkDeleteModal = false;

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $showSlidePanel = false;
    public $isClosing = false;
    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'roles' => [],
    ];

    // Role assignment properties
    public $showRoleModal = false;
    public $selectedUserId = null;
    public $userRoles = [];
    public $availableRoles = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'filterRole' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function mount()
    {
        $this->loadAvailableRoles();
    }

    public function loadAvailableRoles()
    {
        $this->availableRoles = Role::orderBy('name')->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->users->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $this->selectAll = count($this->selectedItems) === $this->users->count();
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

        // Check if any selected users are the last admin
        $adminUsers = User::role('admin')->whereIn('id', $this->selectedItems);
        if ($adminUsers->count() > 0 && User::role('admin')->count() <= $adminUsers->count()) {
            $this->dispatchErrorEvent('Cannot delete all admin users!');

            return;
        }

        User::whereIn('id', $this->selectedItems)->delete();

        $this->selectedItems = [];
        $this->selectAll = false;
        $this->showBulkDeleteModal = false;

        $this->flashSuccess('Selected users deleted successfully!');
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

    public function closeAllForms()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        // Close any existing edit forms
        $this->editingId = null;
        $this->isCreating = false;

        // Set the new editing ID
        $this->editingId = $id;
        $user = User::findOrFail($id);

        $this->form = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => '',
            'roles' => $user->roles->pluck('id')->toArray(),
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
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'roles' => [],
        ];
    }

    public function store()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|string|email|max:255|unique:users,email',
            'form.password' => 'required|string|min:8|confirmed',
            'form.roles' => 'array',
        ]);

        DB::transaction(function () {
            $user = User::create([
                'name' => $this->form['name'],
                'email' => $this->form['email'],
                'password' => Hash::make($this->form['password']),
            ]);

            if (!empty($this->form['roles'])) {
                // Convert role IDs to role names or role objects
                $roles = Role::whereIn('id', $this->form['roles'])->get();
                $user->assignRole($roles);
            }
        });

        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->resetForm();

        $this->flashSuccess('User created successfully!');
    }

    public function update()
    {
        $user = User::findOrFail($this->editingId);

        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|string|email|max:255|unique:users,email,' . $this->editingId,
            'form.password' => 'nullable|string|min:8|confirmed',
            'form.roles' => 'array',
        ]);

        DB::transaction(function () use ($user) {
            $updateData = [
                'name' => $this->form['name'],
                'email' => $this->form['email'],
            ];

            if (!empty($this->form['password'])) {
                $updateData['password'] = Hash::make($this->form['password']);
            }

            $user->update($updateData);

            // Convert role IDs to role objects
            if (!empty($this->form['roles'])) {
                $roles = Role::whereIn('id', $this->form['roles'])->get();
                $user->syncRoles($roles);
            } else {
                $user->syncRoles([]);
            }
        });

        $this->editingId = null;
        $this->showSlidePanel = false;
        $this->resetForm();

        $this->flashSuccess('User updated successfully!');
    }

    public function delete($id)
    {
        // Legacy direct delete kept for backward compatibility; route through confirm system
        $this->performActualDelete($id);
    }

    // Renamed actual delete logic
    public function performActualDelete($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting the last admin user
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            $this->dispatchErrorEvent('Cannot delete the last admin user!');

            return;
        }

        $userName = $user->name;
        $user->delete();

        $this->flashDelete("User '{$userName}' has been successfully deleted.");
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Prevent deactivating the last admin user
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            $this->dispatchErrorEvent('Cannot deactivate the last admin user!');

            return;
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        $this->dispatchSuccessEvent("User '{$user->name}' has been {$status}.");
    }

    public function openRoleModal($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::findOrFail($userId);
        $this->userRoles = $user->roles->pluck('id')->toArray();
        $this->showRoleModal = true;
    }

    public function closeRoleModal()
    {
        $this->showRoleModal = false;
        $this->selectedUserId = null;
        $this->userRoles = [];
    }

    public function updateUserRoles()
    {
        $user = User::findOrFail($this->selectedUserId);

        // Prevent removing admin role from the last admin user
        $adminRole = Role::where('name', 'admin')->first();
        if ($user->hasRole('admin') && $adminRole && !in_array($adminRole->id, $this->userRoles)) {
            if (User::role('admin')->count() <= 1) {
                $this->dispatchErrorEvent('Cannot remove admin role from the last admin user!');

                return;
            }
        }

        // Convert role IDs to role objects
        if (!empty($this->userRoles)) {
            $roles = Role::whereIn('id', $this->userRoles)->get();
            $user->syncRoles($roles);
        } else {
            $user->syncRoles([]);
        }

        $this->closeRoleModal();

        $this->flashSuccess('User roles updated successfully!');
    }

    public function render()
    {
        $users = User::query()
            ->with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('roles.id', $this->filterRole);
                });
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('is_active', $this->filterStatus);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.users.index', compact('users'));
    }
}
