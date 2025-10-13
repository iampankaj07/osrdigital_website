<div>
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-users mr-2"></i>Users Management
                    </h5>
                </div>
                <div class="col-auto">
                    @if(count($selectedItems) > 0)
                        <button wire:click="openBulkDeleteModal" class="btn btn-danger mr-2">
                            <i class="fas fa-trash mr-1"></i>Delete Selected ({{ count($selectedItems) }})
                        </button>
                    @endif
                    <button wire:click="create" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i>Add User
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filters -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" wire:model="search" class="form-control" placeholder="Search users...">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <select wire:model="filterRole" class="form-control">
                        <option value="">All Roles</option>
                        @foreach($availableRoles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="filterStatus" class="form-control">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="perPage" class="form-control">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="sortField" class="form-control">
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                        <option value="created_at">Created Date</option>
                    </select>
                </div>
            </div>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input type="checkbox" wire:model="selectAll" class="form-check-input">
                                    <label class="form-check-label">All</label>
                                </div>
                            </th>
                            <th wire:click="sortBy('name')" style="cursor: pointer;">
                                Name
                                @if($sortField === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('email')" style="cursor: pointer;">
                                Email
                                @if($sortField === 'email')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                                Created
                                @if($sortField === 'created_at')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               wire:model="selectedItems" 
                                               value="{{ $user->id }}" 
                                               class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <strong>{{ $user->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}" class="text-primary">{{ $user->email }}</a>
                                </td>
                                <td>
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-info mr-1">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No roles</span>
                                    @endif
                                </td>
                                <td>
                                    <span wire:click="toggleStatus({{ $user->id }})" 
                                          class="badge badge-{{ $user->is_active ? 'success' : 'secondary' }} badge-pill" 
                                          style="cursor: pointer;">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button wire:click="edit({{ $user->id }})" 
                                                class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="openRoleModal({{ $user->id }})" 
                                                class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-user-tag"></i>
                                        </button>
                                        <button wire:click="delete({{ $user->id }})" 
                                                class="btn btn-sm btn-outline-danger"
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
                                                        <button type="button" class="btn btn-secondary mr-2" wire:click="cancelEdit">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
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
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
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
                        <button type="button" class="btn btn-secondary mr-2" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
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
                        <button type="button" class="btn btn-secondary" wire:click="closeRoleModal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="updateUserRoles">
                            <i class="fas fa-save mr-1"></i>Update Roles
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Bulk Delete Modal -->
    @if($showBulkDeleteModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle mr-2 text-warning"></i>Confirm Bulk Delete
                        </h5>
                        <button type="button" class="close" wire:click="closeBulkDeleteModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <strong>{{ count($selectedItems) }}</strong> selected user(s)?</p>
                        <p class="text-danger"><strong>This action cannot be undone!</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeBulkDeleteModal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-danger" wire:click="bulkDelete">
                            <i class="fas fa-trash mr-1"></i>Delete Selected
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
