<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-users mr-2 text-primary"></i>Users Management
            </h4>
            <p class="text-muted small mb-0">Manage system users and their access</p>
        </div>
        <div>
            <button wire:click="create" class="btn btn-dark btn-sm">
                <i class="fas fa-plus mr-1"></i>Add User
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search users...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label for="filterRole" class="small text-muted mb-1">Role</label>
                        <select wire:model.live="filterRole" class="form-control form-control-sm">
                            <option value="">All Roles</option>
                            @foreach($availableRoles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label for="filterStatus" class="small text-muted mb-1">Status</label>
                        <select wire:model.live="filterStatus" class="form-control form-control-sm">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label for="perPage" class="small text-muted mb-1">Per Page</label>
                        <select wire:model.live="perPage" class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label for="sortField" class="small text-muted mb-1">Sort By</label>
                        <select wire:model.live="sortField" class="form-control form-control-sm">
                            <option value="name">Name</option>
                            <option value="email">Email</option>
                            <option value="created_at">Created Date</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('name')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 20%;">
                                <span class="d-flex align-items-center">
                                    Name
                                    @if($sortField === 'name')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th wire:click="sortBy('email')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 25%;">
                                <span class="d-flex align-items-center">
                                    Email
                                    @if($sortField === 'email')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 20%;">Roles</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Status</th>
                            <th wire:click="sortBy('created_at')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 15%;">
                                <span class="d-flex align-items-center">
                                    Created
                                    @if($sortField === 'created_at')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 32px; height: 32px; font-size: 14px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="font-weight-medium text-dark">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <a href="mailto:{{ $user->email }}" class="text-primary small">{{ $user->email }}</a>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles->take(2) as $role)
                                            <span class="badge badge-light text-dark border small mr-1">{{ $role->name }}</span>
                                        @endforeach
                                        @if($user->roles->count() > 2)
                                            <span class="badge badge-secondary small">+{{ $user->roles->count() - 2 }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted small">No roles</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span wire:click="toggleStatus({{ $user->id }})" 
                                          class="badge badge-{{ $user->is_active ? 'success' : 'light' }} badge-sm" 
                                          style="cursor: pointer;">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">{{ $user->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $user->id }})" 
                                                class="btn btn-outline-primary btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="openRoleModal({{ $user->id }})" 
                                                class="btn btn-outline-info btn-sm border-0"
                                                title="Manage Roles">
                                            <i class="fas fa-user-tag"></i>
                                        </button>
                                        <button wire:click="delete({{ $user->id }})" 
                                                class="btn btn-danger btn-sm border-0"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId == $user->id)
                                <tr class="table-info edit-form-row">
                                    <td colspan="7" class="p-0 border-0">
                                        <div class="card m-2 border-primary">
                                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-edit mr-2"></i>Edit User: {{ $user->name }}
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-light" wire:click="cancelEdit">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <form wire:submit.prevent="update">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.name">Name <span class="text-danger">*</span></label>
                                                                <input type="text" wire:model="form.name" 
                                                                       class="form-control @error('form.name') is-invalid @enderror" 
                                                                       placeholder="Enter user name">
                                                                @error('form.name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.email">Email <span class="text-danger">*</span></label>
                                                                <input type="email" wire:model="form.email" 
                                                                       class="form-control @error('form.email') is-invalid @enderror" 
                                                                       placeholder="Enter user email">
                                                                @error('form.email')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.password">Password</label>
                                                                <input type="password" wire:model="form.password" 
                                                                       class="form-control @error('form.password') is-invalid @enderror" 
                                                                       placeholder="Leave blank to keep current password">
                                                                @error('form.password')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.password_confirmation">Confirm Password</label>
                                                                <input type="password" wire:model="form.password_confirmation" 
                                                                       class="form-control @error('form.password_confirmation') is-invalid @enderror" 
                                                                       placeholder="Confirm new password">
                                                                @error('form.password_confirmation')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Roles</label>
                                                        <div class="row">
                                                            @foreach($availableRoles as $role)
                                                                <div class="col-md-3">
                                                                    <div class="form-check">
                                                                        <input type="checkbox" 
                                                                               wire:model="form.roles" 
                                                                               value="{{ $role->id }}"
                                                                               class="form-check-input @error('form.roles') is-invalid @enderror" 
                                                                               id="role_{{ $role->id }}">
                                                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                                                            {{ $role->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @error('form.roles')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group text-right">
                                                        <button type="button" class="btn btn-secondary btn-sm mr-2" wire:click="cancelEdit">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-dark btn-sm">
                                                            <i class="fas fa-save mr-1"></i>Update User
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                                        <h5 class="font-weight-normal">No users found</h5>
                                        <p class="small">Start by creating your first user</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-muted small">
            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus mr-2"></i>Create New User
                </h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.name">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="form.name" 
                                       class="form-control @error('form.name') is-invalid @enderror" 
                                       placeholder="Enter user name">
                                @error('form.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.email">Email <span class="text-danger">*</span></label>
                                <input type="email" wire:model="form.email" 
                                       class="form-control @error('form.email') is-invalid @enderror" 
                                       placeholder="Enter user email">
                                @error('form.email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.password">Password <span class="text-danger">*</span></label>
                                <input type="password" wire:model="form.password" 
                                       class="form-control @error('form.password') is-invalid @enderror" 
                                       placeholder="Enter password">
                                @error('form.password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" wire:model="form.password_confirmation" 
                                       class="form-control @error('form.password_confirmation') is-invalid @enderror" 
                                       placeholder="Confirm password">
                                @error('form.password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Roles</label>
                        <div class="row">
                            @foreach($availableRoles as $role)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               wire:model="form.roles" 
                                               value="{{ $role->id }}"
                                               class="form-check-input @error('form.roles') is-invalid @enderror" 
                                               id="create_role_{{ $role->id }}">
                                        <label class="form-check-label" for="create_role_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('form.roles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary btn-sm mr-2" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-dark btn-sm">
                            <i class="fas fa-save mr-1"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Role Assignment Modal -->
    @if($showRoleModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-user-tag mr-2"></i>Assign Roles
                        </h5>
                        <button type="button" class="close" wire:click="closeRoleModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Select Roles</label>
                            @foreach($availableRoles as $role)
                                <div class="form-check">
                                    <input type="checkbox" 
                                           wire:model="userRoles" 
                                           value="{{ $role->id }}"
                                           class="form-check-input" 
                                           id="modal_role_{{ $role->id }}">
                                    <label class="form-check-label" for="modal_role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="closeRoleModal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-dark btn-sm" wire:click="updateUserRoles">
                            <i class="fas fa-save mr-1"></i>Update Roles
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <style>
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .badge[style*="cursor: pointer"]:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }
        
        .badge[style*="cursor: pointer"] {
            transition: all 0.2s ease;
        }
        
        /* Edit form styling */
        .table-info {
            background-color: rgba(0, 123, 255, 0.1) !important;
        }
        
        .table-info td {
            border-top: none !important;
        }
        
        .card.border-primary {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 123, 255, 0.075);
            border-width: 2px !important;
        }
        
        .card-header.bg-primary {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Smooth transition for edit form */
        .edit-form-row {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>
