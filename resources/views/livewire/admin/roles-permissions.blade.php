<div><div class="container-fluid">

    <!-- Tab Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill" role="tablist">
                <li class="nav-item">
                    <button wire:click="switchTab('roles')" 
                            class="nav-link {{ $activeTab === 'roles' ? 'active' : '' }} d-flex align-items-center justify-content-center">
                        <i class="fas fa-users-cog mr-2"></i>
                        <span>Roles</span>
                        @if($roles->count() > 0)
                            <span class="badge badge-light ml-2">{{ $roles->total() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="switchTab('permissions')" 
                            class="nav-link {{ $activeTab === 'permissions' ? 'active' : '' }} d-flex align-items-center justify-content-center">
                        <i class="fas fa-key mr-2"></i>
                        <span>Permissions</span>
                        @if($permissions->count() > 0)
                            <span class="badge badge-light ml-2">{{ $permissions->total() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button wire:click="switchTab('users')" 
                            class="nav-link {{ $activeTab === 'users' ? 'active' : '' }} d-flex align-items-center justify-content-center">
                        <i class="fas fa-users mr-2"></i>
                        <span>Users</span>
                        @if($users->count() > 0)
                            <span class="badge badge-light ml-2">{{ $users->total() }}</span>
                        @endif
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Search -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Search</label>
                                @if($activeTab === 'permissions')
                                    <input type="text" wire:model.lazy="permissionSearch" 
                                           class="form-control" placeholder="Search permissions...">
                                @elseif($activeTab === 'users')
                                    <input type="text" wire:model.lazy="userSearch" 
                                           class="form-control" placeholder="Search users...">
                                @else
                                    <input type="text" wire:model.lazy="search" 
                                           class="form-control" placeholder="Search roles...">
                                @endif
                            </div>
                        </div>

                        <!-- Guard Filter -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Guard</label>
                                <select wire:model.lazy="filterGuard" class="form-control">
                                    <option value="">All Guards</option>
                                    @foreach($guardOptions as $guard)
                                        <option value="{{ $guard }}">{{ ucfirst($guard) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Additional Filters -->
                        @if($activeTab === 'permissions')
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select wire:model.lazy="permissionFilterCategory" class="form-control">
                                        <option value="">All Categories</option>
                                        @foreach($permissionCategories as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @elseif($activeTab === 'users')
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <select wire:model.lazy="userFilterRole" class="form-control">
                                        <option value="">All Roles</option>
                                        @foreach($roleOptions as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select wire:model.lazy="userFilterStatus" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        @endif

                        <!-- Per Page -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Per Page</label>
                                <select wire:model.lazy="perPage" class="form-control">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    @if(!empty($selectedItems))
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ count($selectedItems) }} item(s) selected
                    </span>
                    <div>
                        <button wire:click="openBulkActionModal" class="btn btn-sm btn-dark mr-2">
                            <i class="fas fa-tasks mr-1"></i>Bulk Actions
                        </button>
                        <button wire:click="selectedItems = []; selectAll = false" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times mr-1"></i>Clear Selection
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Content Tabs -->
    <div class="row">
        <div class="col-12">
            <!-- Roles Tab -->
            @if($activeTab === 'roles')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-users-cog mr-2"></i>Roles Management
                        </h5>
                        <button wire:click="createRole" class="btn btn-dark">
                            <i class="fas fa-plus mr-1"></i>Create Role
                        </button>
                    </div>
                    <div class="card-body p-0">
                        @if($roles->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll">
                                            </th>
                                            <th wire:click="sortBy('name')" style="cursor: pointer;">
                                                Name
                                                @if($sortField === 'name')
                                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                                @endif
                                            </th>
                                            <th>Description</th>
                                            <th>Color</th>
                                            <th>Guard</th>
                                            <th>Users</th>
                                            <th>Permissions</th>
                                            <th>Created</th>
                                            <th width="150">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" 
                                                           wire:model="selectedItems" 
                                                           value="{{ $role->id }}"
                                                           wire:click="toggleItem({{ $role->id }})">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="role-color-indicator" 
                                                             style="background-color: {{ $role->color ?? '#3b82f6' }}; width: 12px; height: 12px; border-radius: 50%; margin-right: 8px;"></div>
                                                        <strong>{{ $role->name }}</strong>
                                                    </div>
                                                </td>
                                                <td>{{ $role->description ?? 'No description' }}</td>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $role->color ?? '#3b82f6' }}; color: white;">
                                                        {{ $role->color ?? '#3b82f6' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ $role->guard_name }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $role->users_count }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-success">{{ $role->permissions_count }}</span>
                                                </td>
                                                <td>{{ $role->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button wire:click="editRole({{ $role->id }})" 
                                                                class="btn btn-dark btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button wire:click="manageRolePermissions({{ $role->id }})" 
                                                                class="btn btn-outline-info btn-sm" title="Permissions">
                                                            <i class="fas fa-key"></i>
                                                        </button>
                                                        <button wire:click="confirmDeleteRole({{ $role->id }})" 
                                                                class="btn btn-outline-danger btn-sm" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users-cog fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No roles found</h5>
                                <p class="text-muted">Create your first role to get started.</p>
                                <button wire:click="createRole" class="btn btn-dark">
                                    <i class="fas fa-plus mr-1"></i>Create Role
                                </button>
                            </div>
                        @endif
                    </div>
                    @if($roles->hasPages())
                        <div class="card-footer">
                            {{ $roles->links() }}
                        </div>
                    @endif
                </div>

            <!-- Permissions Tab -->
            @elseif($activeTab === 'permissions')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-key mr-2"></i>Permissions Management
                        </h5>
                        <button wire:click="createPermission" class="btn btn-dark">
                            <i class="fas fa-plus mr-1"></i>Create Permission
                        </button>
                    </div>
                    <div class="card-body p-0">
                        @if($permissions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll">
                                            </th>
                                            <th wire:click="sortBy('name')" style="cursor: pointer;">
                                                Name
                                                @if($sortField === 'name')
                                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                                @endif
                                            </th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Guard</th>
                                            <th>Roles</th>
                                            <th>Users</th>
                                            <th>Created</th>
                                            <th width="150">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" 
                                                           wire:model="selectedItems" 
                                                           value="{{ $permission->id }}"
                                                           wire:click="toggleItem({{ $permission->id }})">
                                                </td>
                                                <td>
                                                    <code class="text-primary">{{ $permission->name }}</code>
                                                </td>
                                                <td>{{ $permission->description ?? 'No description' }}</td>
                                                <td>
                                                    <span class="badge badge-outline-primary">
                                                        {{ $permissionCategories[$permission->category] ?? 'General' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ $permission->guard_name }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $permission->roles_count }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-success">{{ $permission->users_count }}</span>
                                                </td>
                                                <td>{{ $permission->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button wire:click="editPermission({{ $permission->id }})" 
                                                                class="btn btn-dark btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button wire:click="confirmDeletePermission({{ $permission->id }})" 
                                                                class="btn btn-outline-danger btn-sm" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-key fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No permissions found</h5>
                                <p class="text-muted">Create your first permission to get started.</p>
                                <button wire:click="createPermission" class="btn btn-dark">
                                    <i class="fas fa-plus mr-1"></i>Create Permission
                                </button>
                            </div>
                        @endif
                    </div>
                    @if($permissions->hasPages())
                        <div class="card-footer">
                            {{ $permissions->links() }}
                        </div>
                    @endif
                </div>

            <!-- Users Tab -->
            @elseif($activeTab === 'users')
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-users mr-2"></i>Users Management
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll">
                                            </th>
                                            <th wire:click="sortBy('name')" style="cursor: pointer;">
                                                User
                                                @if($sortField === 'name')
                                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                                @endif
                                            </th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Permissions</th>
                                            <th>Status</th>
                                            <th>Last Login</th>
                                            <th width="150">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" 
                                                           wire:model="selectedItems" 
                                                           value="{{ $user->id }}"
                                                           wire:click="toggleItem({{ $user->id }})">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <strong>{{ $user->name }}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if($user->roles->count() > 0)
                                                        @foreach($user->roles->take(2) as $role)
                                                            <span class="badge badge-primary me-1">{{ $role->name }}</span>
                                                        @endforeach
                                                        @if($user->roles->count() > 2)
                                                            <span class="badge badge-light">+{{ $user->roles->count() - 2 }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">No roles</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->permissions->count() > 0)
                                                        <span class="badge badge-success">{{ $user->permissions->count() }}</span>
                                                    @else
                                                        <span class="text-muted">0</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->email_verified_at)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-warning">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y') : 'Never' }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button wire:click="manageUserRoles({{ $user->id }})" 
                                                                class="btn btn-dark btn-sm" title="Manage Roles">
                                                            <i class="fas fa-users-cog"></i>
                                                        </button>
                                                        <button wire:click="manageUserPermissions({{ $user->id }})" 
                                                                class="btn btn-outline-info btn-sm" title="Manage Permissions">
                                                            <i class="fas fa-key"></i>
                                                        </button>
                                                        <button wire:click="confirmDeleteUser({{ $user->id }})" 
                                                                class="btn btn-outline-danger btn-sm" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No users found</h5>
                                <p class="text-muted">No users match your current filters.</p>
                            </div>
                        @endif
                    </div>
                    @if($users->hasPages())
                        <div class="card-footer">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Role Modal -->
@if($showRoleModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-users-cog mr-2"></i>
                        {{ $editingRoleId ? 'Edit Role' : 'Create Role' }}
                    </h5>
                    <button wire:click="closeRoleModal" class="btn-close"></button>
                </div>
                <form wire:submit.prevent="saveRole">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Role Name <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="roleForm.name" 
                                           class="form-control @error('roleForm.name') is-invalid @enderror"
                                           placeholder="e.g., editor, manager">
                                    @error('roleForm.name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Guard Name</label>
                                    <select wire:model="roleForm.guard_name" class="form-control">
                                        <option value="web">Web</option>
                                        <option value="api">API</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Description</label>
                            <textarea wire:model="roleForm.description" 
                                      class="form-control @error('roleForm.description') is-invalid @enderror"
                                      rows="3" placeholder="Describe the role's purpose and responsibilities"></textarea>
                            @error('roleForm.description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Role Color</label>
                            <div class="d-flex align-items-center">
                                <input type="color" wire:model="roleForm.color" 
                                       class="form-control form-control-color me-3" style="width: 60px;">
                                <span class="text-muted">Choose a color to identify this role</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeRoleModal" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-save mr-1"></i>Save Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Permission Modal -->
@if($showPermissionModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key mr-2"></i>
                        {{ $editingPermissionId ? 'Edit Permission' : 'Create Permission' }}
                    </h5>
                    <button wire:click="closePermissionModal" class="btn-close"></button>
                </div>
                <form wire:submit.prevent="savePermission">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="permissionForm.name" 
                                           class="form-control @error('permissionForm.name') is-invalid @enderror"
                                           placeholder="e.g., edit-posts, view-reports">
                                    @error('permissionForm.name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Category</label>
                                    <select wire:model="permissionForm.category" class="form-control">
                                        @foreach($permissionCategories as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Guard Name</label>
                                    <select wire:model="permissionForm.guard_name" class="form-control">
                                        <option value="web">Web</option>
                                        <option value="api">API</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Description</label>
                            <textarea wire:model="permissionForm.description" 
                                      class="form-control @error('permissionForm.description') is-invalid @enderror"
                                      rows="3" placeholder="Describe what this permission allows"></textarea>
                            @error('permissionForm.description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closePermissionModal" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-save mr-1"></i>Save Permission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Bulk Action Modal -->
@if($showBulkActionModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-tasks mr-2"></i>Bulk Actions
                    </h5>
                    <button wire:click="closeBulkActionModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Action</label>
                        <select wire:model="bulkAction" class="form-control">
                            <option value="">Select Action</option>
                            @if($activeTab === 'roles')
                                <option value="delete_roles">Delete Selected Roles</option>
                                <option value="assign_role">Assign Role to Users</option>
                            @elseif($activeTab === 'permissions')
                                <option value="delete_permissions">Delete Selected Permissions</option>
                                <option value="assign_permission">Assign Permission to Users</option>
                            @elseif($activeTab === 'users')
                                <option value="delete_users">Delete Selected Users</option>
                                <option value="assign_role">Assign Role to Users</option>
                                <option value="assign_permission">Assign Permission to Users</option>
                            @endif
                        </select>
                    </div>

                    @if($bulkAction === 'assign_role')
                        <div class="form-group mb-3">
                            <label class="form-label">Target Role</label>
                            <select wire:model="bulkTargetRole" class="form-control">
                                <option value="">Select Role</option>
                                @foreach($roleOptions as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if($bulkAction === 'assign_permission')
                        <div class="form-group mb-3">
                            <label class="form-label">Target Permission</label>
                            <select wire:model="bulkTargetPermission" class="form-control">
                                <option value="">Select Permission</option>
                                @foreach($permissionOptions as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        This action will affect {{ count($selectedItems) }} selected item(s). This cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="closeBulkActionModal" class="btn btn-secondary">Cancel</button>
                    <button wire:click="executeBulkAction" class="btn btn-danger">
                        <i class="fas fa-check mr-1"></i>Execute Action
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Template Modal -->
@if($showTemplateModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus mr-2"></i>Create Role from Template
                    </h5>
                    <button wire:click="closeTemplateModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach($roleTemplates as $key => $template)
                            <div class="col-md-4 mb-3">
                                <div class="card template-card" wire:click="selectedTemplate = '{{ $key }}'"
                                     style="cursor: pointer; {{ $selectedTemplate === $key ? 'border-color: #007bff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);' : '' }}">
                                    <div class="card-body text-center">
                                        <div class="template-icon mb-3">
                                            <div class="avatar-lg mx-auto" style="background-color: {{ $template['color'] }};">
                                                <i class="fas fa-user-tag fa-2x text-white"></i>
                                            </div>
                                        </div>
                                        <h6 class="card-title">{{ $template['name'] }}</h6>
                                        <p class="card-text text-muted small">{{ $template['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="closeTemplateModal" class="btn btn-secondary">Cancel</button>
                    <button wire:click="createFromTemplate" class="btn btn-dark" {{ !$selectedTemplate ? 'disabled' : '' }}>
                        <i class="fas fa-plus mr-1"></i>Create Role
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Audit Log Modal -->
@if($showAuditModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-history mr-2"></i>Audit Log
                    </h5>
                    <button wire:click="closeAuditModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Action</th>
                                    <th>User</th>
                                    <th>Target</th>
                                    <th>Details</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auditLogs as $log)
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary">{{ $log['action'] }}</span>
                                        </td>
                                        <td>{{ $log['user'] }}</td>
                                        <td>{{ $log['target'] }}</td>
                                        <td>{{ $log['details'] }}</td>
                                        <td>{{ $log['timestamp']->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="closeAuditModal" class="btn btn-secondary">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Delete Confirmation Modals -->
@if($showRoleDeleteModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Delete
                    </h5>
                    <button wire:click="closeRoleDeleteModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this role? This action cannot be undone.</p>
                    @if($roleToDelete && $roleToDelete->users()->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-warning mr-2"></i>
                            This role has {{ $roleToDelete->users()->count() }} assigned user(s). You cannot delete it.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button wire:click="closeRoleDeleteModal" class="btn btn-secondary">Cancel</button>
                    @if(!$roleToDelete || $roleToDelete->users()->count() === 0)
                        <button wire:click="deleteRole" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i>Delete Role
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@if($showPermissionDeleteModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Delete
                    </h5>
                    <button wire:click="closePermissionDeleteModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this permission? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button wire:click="closePermissionDeleteModal" class="btn btn-secondary">Cancel</button>
                    <button wire:click="deletePermission" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i>Delete Permission
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

@if($showUserDeleteModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Delete
                    </h5>
                    <button wire:click="closeUserDeleteModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button wire:click="closeUserDeleteModal" class="btn btn-secondary">Cancel</button>
                    <button wire:click="deleteUser" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i>Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
.template-card {
    transition: all 0.3s ease;
}

.template-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}

.avatar-lg {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.role-color-indicator {
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
}

.badge-outline-primary {
    color: #007bff;
    border: 1px solid #007bff;
    background-color: transparent;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.modal.show {
    display: block !important;
}

.template-card.selected {
    border-color: #007bff !important;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
}
</style></div>