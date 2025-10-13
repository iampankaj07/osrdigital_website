<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesPermissions extends Component
{
    use WithPagination;

    // Tab Management
    public $activeTab = 'roles';

    // Search and Filter
    public $search = '';
    public $perPage = 15;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $filterGuard = '';
    public $filterStatus = '';
    public $selectedItems = [];
    public $selectAll = false;

    // Role Management
    public $roleForm = [
        'name' => '',
        'description' => '',
        'guard_name' => 'web',
        'color' => '#3b82f6'
    ];
    public $editingRoleId = null;
    public $showRoleModal = false;
    public $showRoleDeleteModal = false;
    public $roleToDelete = null;

    // Permission Management
    public $permissionForm = [
        'name' => '',
        'description' => '',
        'guard_name' => 'web',
        'category' => 'general'
    ];
    public $editingPermissionId = null;
    public $showPermissionModal = false;
    public $showPermissionDeleteModal = false;
    public $permissionToDelete = null;
    public $permissionCategories = [
        'general' => 'General',
        'user' => 'User Management',
        'content' => 'Content Management',
        'settings' => 'Settings',
        'reports' => 'Reports',
        'system' => 'System'
    ];

    // User Management
    public $selectedUserId = null;
    public $showUserRoleModal = false;
    public $showUserPermissionModal = false;
    public $showUserDeleteModal = false;
    public $userToDelete = null;
    public $userRoles = [];
    public $userPermissions = [];
    public $userSearch = '';
    public $userFilterRole = '';
    public $userFilterStatus = '';

    // Role-Permission Assignment
    public $selectedRoleId = null;
    public $showRolePermissionModal = false;
    public $rolePermissions = [];
    public $permissionSearch = '';
    public $permissionFilterCategory = '';

    // Bulk Operations
    public $showBulkActionModal = false;
    public $bulkAction = '';
    public $bulkTargetRole = '';
    public $bulkTargetPermission = '';

    // Role Templates
    public $roleTemplates = [
        'admin' => [
            'name' => 'Administrator',
            'description' => 'Full system access',
            'color' => '#dc2626',
            'permissions' => []
        ],
        'editor' => [
            'name' => 'Editor',
            'description' => 'Content management access',
            'color' => '#059669',
            'permissions' => []
        ],
        'viewer' => [
            'name' => 'Viewer',
            'description' => 'Read-only access',
            'color' => '#7c3aed',
            'permissions' => []
        ]
    ];
    public $showTemplateModal = false;
    public $selectedTemplate = '';

    // Audit Log
    public $showAuditModal = false;
    public $auditLogs = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 15],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'filterGuard' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'userSearch' => ['except' => ''],
        'userFilterRole' => ['except' => ''],
        'userFilterStatus' => ['except' => ''],
        'permissionSearch' => ['except' => ''],
        'permissionFilterCategory' => ['except' => ''],
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // This method can be used to refresh data when needed
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingFilterGuard()
    {
        $this->resetPage();
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedItems = [];
        } else {
            $this->selectedItems = $this->getCurrentPageItems();
        }
        $this->selectAll = !$this->selectAll;
    }

    public function toggleItem($id)
    {
        if (in_array($id, $this->selectedItems)) {
            $this->selectedItems = array_diff($this->selectedItems, [$id]);
        } else {
            $this->selectedItems[] = $id;
        }
        $this->selectAll = false;
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterGuard = '';
        $this->filterStatus = '';
        $this->userSearch = '';
        $this->userFilterRole = '';
        $this->userFilterStatus = '';
        $this->permissionSearch = '';
        $this->permissionFilterCategory = '';
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    // Role Management Methods
    public function createRole()
    {
        $this->editingRoleId = null;
        $this->roleForm = [
            'name' => '',
            'description' => '',
            'guard_name' => 'web'
        ];
        $this->showRoleModal = true;
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $this->editingRoleId = $id;
        $this->roleForm = [
            'name' => $role->name,
            'description' => $role->description ?? '',
            'guard_name' => $role->guard_name
        ];
        $this->showRoleModal = true;
    }

    public function saveRole()
    {
        $rules = [
            'roleForm.name' => 'required|string|max:255',
            'roleForm.description' => 'nullable|string|max:500',
            'roleForm.guard_name' => 'required|string|in:web,api',
        ];

        if ($this->editingRoleId) {
            $rules['roleForm.name'] .= '|unique:roles,name,' . $this->editingRoleId;
        } else {
            $rules['roleForm.name'] .= '|unique:roles,name';
        }

        $this->validate($rules);

        try {
            if ($this->editingRoleId) {
                $role = Role::findOrFail($this->editingRoleId);
                $role->update($this->roleForm);
                session()->flash('success', 'Role updated successfully!');
            } else {
                Role::create($this->roleForm);
                session()->flash('success', 'Role created successfully!');
            }

            $this->closeRoleModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save role: ' . $e->getMessage());
        }
    }

    public function deleteRole($id)
    {
        try {
            $role = Role::findOrFail($id);
            
            // Check if role has users
            if ($role->users()->count() > 0) {
                session()->flash('error', 'Cannot delete role that has assigned users');
                return;
            }

            $role->delete();
            session()->flash('success', 'Role deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }

    public function closeRoleModal()
    {
        $this->showRoleModal = false;
        $this->editingRoleId = null;
        $this->roleForm = [
            'name' => '',
            'description' => '',
            'guard_name' => 'web'
        ];
    }

    // Permission Management Methods
    public function createPermission()
    {
        $this->editingPermissionId = null;
        $this->permissionForm = [
            'name' => '',
            'description' => '',
            'guard_name' => 'web'
        ];
        $this->showPermissionModal = true;
    }

    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $this->editingPermissionId = $id;
        $this->permissionForm = [
            'name' => $permission->name,
            'description' => $permission->description ?? '',
            'guard_name' => $permission->guard_name
        ];
        $this->showPermissionModal = true;
    }

    public function savePermission()
    {
        $rules = [
            'permissionForm.name' => 'required|string|max:255',
            'permissionForm.description' => 'nullable|string|max:500',
            'permissionForm.guard_name' => 'required|string|in:web,api',
        ];

        if ($this->editingPermissionId) {
            $rules['permissionForm.name'] .= '|unique:permissions,name,' . $this->editingPermissionId;
        } else {
            $rules['permissionForm.name'] .= '|unique:permissions,name';
        }

        $this->validate($rules);

        try {
            if ($this->editingPermissionId) {
                $permission = Permission::findOrFail($this->editingPermissionId);
                $permission->update($this->permissionForm);
                session()->flash('success', 'Permission updated successfully!');
            } else {
                Permission::create($this->permissionForm);
                session()->flash('success', 'Permission created successfully!');
            }

            $this->closePermissionModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save permission: ' . $e->getMessage());
        }
    }

    public function deletePermission($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            session()->flash('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete permission: ' . $e->getMessage());
        }
    }

    public function closePermissionModal()
    {
        $this->showPermissionModal = false;
        $this->editingPermissionId = null;
        $this->permissionForm = [
            'name' => '',
            'description' => '',
            'guard_name' => 'web'
        ];
    }

    // User Management Methods
    public function editUserRoles($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::with('roles')->findOrFail($userId);
        $this->userRoles = $user->roles->pluck('id')->toArray();
        $this->showUserRoleModal = true;
    }

    public function editUserPermissions($userId)
    {
        $this->selectedUserId = $userId;
        $user = User::with('permissions')->findOrFail($userId);
        $this->userPermissions = $user->permissions->pluck('id')->toArray();
        $this->showUserPermissionModal = true;
    }

    public function saveUserRoles()
    {
        try {
            $user = User::findOrFail($this->selectedUserId);
            $roles = Role::whereIn('id', $this->userRoles)->get();
            $user->syncRoles($roles);
            
            session()->flash('success', 'User roles updated successfully!');
            $this->closeUserRoleModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update user roles: ' . $e->getMessage());
        }
    }

    public function saveUserPermissions()
    {
        try {
            $user = User::findOrFail($this->selectedUserId);
            $permissions = Permission::whereIn('id', $this->userPermissions)->get();
            $user->syncPermissions($permissions);
            
            session()->flash('success', 'User permissions updated successfully!');
            $this->closeUserPermissionModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update user permissions: ' . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            session()->flash('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function closeUserRoleModal()
    {
        $this->showUserRoleModal = false;
        $this->selectedUserId = null;
        $this->userRoles = [];
    }

    public function closeUserPermissionModal()
    {
        $this->showUserPermissionModal = false;
        $this->selectedUserId = null;
        $this->userPermissions = [];
    }

    // Role-Permission Assignment Methods
    public function assignPermissionsToRole($roleId)
    {
        $this->selectedRoleId = $roleId;
        $role = Role::with('permissions')->findOrFail($roleId);
        $this->rolePermissions = $role->permissions->pluck('id')->toArray();
        $this->showRolePermissionModal = true;
    }

    public function saveRolePermissions()
    {
        try {
            $role = Role::findOrFail($this->selectedRoleId);
            $permissions = Permission::whereIn('id', $this->rolePermissions)->get();
            $role->syncPermissions($permissions);
            
            session()->flash('success', 'Role permissions updated successfully!');
            $this->closeRolePermissionModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update role permissions: ' . $e->getMessage());
        }
    }

    public function closeRolePermissionModal()
    {
        $this->showRolePermissionModal = false;
        $this->selectedRoleId = null;
        $this->rolePermissions = [];
    }

    // Bulk Operations
    public function openBulkActionModal()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Please select items to perform bulk actions.');
            return;
        }
        $this->showBulkActionModal = true;
    }

    public function closeBulkActionModal()
    {
        $this->showBulkActionModal = false;
        $this->bulkAction = '';
        $this->bulkTargetRole = '';
        $this->bulkTargetPermission = '';
    }

    public function executeBulkAction()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'No items selected.');
            return;
        }

        try {
            switch ($this->bulkAction) {
                case 'delete_roles':
                    $this->bulkDeleteRoles();
                    break;
                case 'delete_permissions':
                    $this->bulkDeletePermissions();
                    break;
                case 'delete_users':
                    $this->bulkDeleteUsers();
                    break;
                case 'assign_role':
                    $this->bulkAssignRole();
                    break;
                case 'assign_permission':
                    $this->bulkAssignPermission();
                    break;
                default:
                    session()->flash('error', 'Invalid bulk action selected.');
                    return;
            }
            $this->closeBulkActionModal();
            $this->selectedItems = [];
            $this->selectAll = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    private function bulkDeleteRoles()
    {
        $roles = Role::whereIn('id', $this->selectedItems)->get();
        foreach ($roles as $role) {
            if ($role->users()->count() > 0) {
                session()->flash('error', "Cannot delete role '{$role->name}' - it has assigned users.");
                return;
            }
            $role->delete();
        }
        session()->flash('success', 'Selected roles deleted successfully!');
    }

    private function bulkDeletePermissions()
    {
        Permission::whereIn('id', $this->selectedItems)->delete();
        session()->flash('success', 'Selected permissions deleted successfully!');
    }

    private function bulkDeleteUsers()
    {
        User::whereIn('id', $this->selectedItems)->delete();
        session()->flash('success', 'Selected users deleted successfully!');
    }

    private function bulkAssignRole()
    {
        if (!$this->bulkTargetRole) {
            session()->flash('error', 'Please select a target role.');
            return;
        }

        $role = Role::findOrFail($this->bulkTargetRole);
        $users = User::whereIn('id', $this->selectedItems)->get();
        
        foreach ($users as $user) {
            $user->assignRole($role);
        }
        
        session()->flash('success', 'Role assigned to selected users successfully!');
    }

    private function bulkAssignPermission()
    {
        if (!$this->bulkTargetPermission) {
            session()->flash('error', 'Please select a target permission.');
            return;
        }

        $permission = Permission::findOrFail($this->bulkTargetPermission);
        $users = User::whereIn('id', $this->selectedItems)->get();
        
        foreach ($users as $user) {
            $user->givePermissionTo($permission);
        }
        
        session()->flash('success', 'Permission assigned to selected users successfully!');
    }

    // Role Templates
    public function openTemplateModal()
    {
        $this->showTemplateModal = true;
    }

    public function closeTemplateModal()
    {
        $this->showTemplateModal = false;
        $this->selectedTemplate = '';
    }

    public function createFromTemplate()
    {
        if (!$this->selectedTemplate || !isset($this->roleTemplates[$this->selectedTemplate])) {
            session()->flash('error', 'Please select a valid template.');
            return;
        }

        $template = $this->roleTemplates[$this->selectedTemplate];
        
        $this->roleForm = [
            'name' => $template['name'],
            'description' => $template['description'],
            'guard_name' => 'web',
            'color' => $template['color']
        ];
        
        $this->closeTemplateModal();
        $this->showRoleModal = true;
    }

    // Audit Logging
    public function openAuditModal()
    {
        $this->auditLogs = $this->getAuditLogs();
        $this->showAuditModal = true;
    }

    public function closeAuditModal()
    {
        $this->showAuditModal = false;
        $this->auditLogs = [];
    }

    private function getAuditLogs()
    {
        // This would typically come from an audit log table
        // For now, we'll return a mock structure
        return [
            [
                'id' => 1,
                'action' => 'Role Created',
                'user' => 'Admin User',
                'target' => 'Editor Role',
                'timestamp' => now()->subHours(2),
                'details' => 'Created new role with permissions: view-content, edit-content'
            ],
            [
                'id' => 2,
                'action' => 'Permission Assigned',
                'user' => 'Admin User',
                'target' => 'John Doe',
                'timestamp' => now()->subHours(4),
                'details' => 'Assigned admin role to user John Doe'
            ],
            // Add more audit log entries as needed
        ];
    }

    private function logAuditAction($action, $target, $details = '')
    {
        Log::info('Role/Permission Action', [
            'action' => $action,
            'target' => $target,
            'details' => $details,
            'user_id' => auth()->id(),
            'timestamp' => now()
        ]);
    }

    private function getCurrentPageItems()
    {
        // This method should return the IDs of items on the current page
        // Implementation depends on the current tab
        if ($this->activeTab === 'roles') {
            return Role::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->when($this->filterGuard, function ($query) {
                $query->where('guard_name', $this->filterGuard);
            })->pluck('id')->toArray();
        } elseif ($this->activeTab === 'permissions') {
            return Permission::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->when($this->filterGuard, function ($query) {
                $query->where('guard_name', $this->filterGuard);
            })->pluck('id')->toArray();
        } elseif ($this->activeTab === 'users') {
            return User::when($this->userSearch, function ($query) {
                $query->where('name', 'like', '%' . $this->userSearch . '%')
                      ->orWhere('email', 'like', '%' . $this->userSearch . '%');
            })->when($this->userFilterRole, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('id', $this->userFilterRole);
                });
            })->pluck('id')->toArray();
        }
        return [];
    }

    public function render()
    {
        $roles = collect();
        $permissions = collect();
        $users = collect();

        if ($this->activeTab === 'roles') {
            $roles = Role::with(['permissions', 'users'])
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('description', 'like', '%' . $this->search . '%');
                })
                ->when($this->filterGuard, function ($query) {
                    $query->where('guard_name', $this->filterGuard);
                })
                ->withCount('users', 'permissions')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        } elseif ($this->activeTab === 'permissions') {
            $permissions = Permission::with('roles')
                ->when($this->permissionSearch, function ($query) {
                    $query->where('name', 'like', '%' . $this->permissionSearch . '%')
                          ->orWhere('description', 'like', '%' . $this->permissionSearch . '%');
                })
                ->when($this->filterGuard, function ($query) {
                    $query->where('guard_name', $this->filterGuard);
                })
                ->when($this->permissionFilterCategory, function ($query) {
                    $query->where('category', $this->permissionFilterCategory);
                })
                ->withCount('roles', 'users')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        } elseif ($this->activeTab === 'users') {
            $users = User::with(['roles', 'permissions'])
                ->when($this->userSearch, function ($query) {
                    $query->where('name', 'like', '%' . $this->userSearch . '%')
                          ->orWhere('email', 'like', '%' . $this->userSearch . '%');
                })
                ->when($this->userFilterRole, function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('id', $this->userFilterRole);
                    });
                })
                ->when($this->userFilterStatus, function ($query) {
                    if ($this->userFilterStatus === 'active') {
                        $query->where('email_verified_at', '!=', null);
                    } elseif ($this->userFilterStatus === 'inactive') {
                        $query->where('email_verified_at', null);
                    }
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        }

        // Get filter options
        $allRoles = Role::all();
        $allPermissions = Permission::all();
        $guardOptions = ['web', 'api', 'admin'];
        $roleOptions = Role::pluck('name', 'id');
        $permissionOptions = Permission::pluck('name', 'id');

        return view('livewire.admin.roles-permissions', compact(
            'roles', 
            'permissions', 
            'users', 
            'allRoles', 
            'allPermissions',
            'guardOptions',
            'roleOptions',
            'permissionOptions'
        ))->layout('admin.layout', ['title' => 'Roles & Permissions']);
    }
}
