<div>
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-user-tag mr-2"></i>User Roles Management
                    </h5>
                </div>
                <div class="col-auto">
                    @if(count($selectedItems) > 0)
                        <button wire:click="openBulkDeleteModal" class="btn btn-danger mr-2">
                            <i class="fas fa-trash mr-1"></i>Delete Selected ({{ count($selectedItems) }})
                        </button>
                    @endif
                    <button wire:click="create" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i>Add Role
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filters -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" wire:model="search" class="form-control" placeholder="Search roles...">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <select wire:model="perPage" class="form-control">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select wire:model="sortField" class="form-control">
                        <option value="name">Name</option>
                        <option value="created_at">Created Date</option>
                    </select>
                </div>
            </div>

            <!-- Roles Table -->
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
                                Role Name
                                @if($sortField === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th>Guard</th>
                            <th>Permissions</th>
                            <th>Users Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               wire:model="selectedItems" 
                                               value="{{ $role->id }}" 
                                               class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $role->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $role->guard_name }}</span>
                                </td>
                                <td>
                                    @if($role->permissions->count() > 0)
                                        <span class="badge badge-success">{{ $role->permissions->count() }} permissions</span>
                                        <br>
                                        <small class="text-muted">
                                            @foreach($role->permissions->take(3) as $permission)
                                                {{ $permission->name }}@if(!$loop->last), @endif
                                            @endforeach
                                            @if($role->permissions->count() > 3)
                                                +{{ $role->permissions->count() - 3 }} more
                                            @endif
                                        </small>
                                    @else
                                        <span class="text-muted">No permissions</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $role->users_count }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $role->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button wire:click="edit({{ $role->id }})" 
                                                class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $role->id }})" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this role?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId == $role->id)
                                <tr>
                                    <td colspan="7" class="p-0">
                                        <div class="card m-2">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-edit mr-2"></i>Edit Role
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <form wire:submit.prevent="update">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.name">Role Name <span class="text-danger">*</span></label>
                                                                <input type="text" wire:model="form.name" 
                                                                       class="form-control @error('form.name') is-invalid @enderror" 
                                                                       placeholder="Enter role name">
                                                                @error('form.name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.guard_name">Guard Name <span class="text-danger">*</span></label>
                                                                <select wire:model="form.guard_name" 
                                                                        class="form-control @error('form.guard_name') is-invalid @enderror">
                                                                    <option value="web">Web</option>
                                                                    <option value="api">API</option>
                                                                </select>
                                                                @error('form.guard_name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Permissions</label>
                                                        <div class="row" style="max-height: 200px; overflow-y: auto;">
                                                            @foreach($availablePermissions as $permission)
                                                                <div class="col-md-4">
                                                                    <div class="form-check">
                                                                        <input type="checkbox" 
                                                                               wire:model="form.permissions" 
                                                                               value="{{ $permission->id }}"
                                                                               class="form-check-input" 
                                                                               id="edit_permission_{{ $permission->id }}">
                                                                        <label class="form-check-label" for="edit_permission_{{ $permission->id }}">
                                                                            {{ $permission->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="form-group text-right">
                                                        <button type="button" class="btn btn-secondary mr-2" wire:click="cancelEdit">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save mr-1"></i>Update Role
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
                                    <i class="fas fa-user-tag fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No roles found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }} results
                </div>
                <div>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus mr-2"></i>Create New Role
                </h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.name">Role Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="form.name" 
                                       class="form-control @error('form.name') is-invalid @enderror" 
                                       placeholder="Enter role name">
                                @error('form.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.guard_name">Guard Name <span class="text-danger">*</span></label>
                                <select wire:model="form.guard_name" 
                                        class="form-control @error('form.guard_name') is-invalid @enderror">
                                    <option value="web">Web</option>
                                    <option value="api">API</option>
                                </select>
                                @error('form.guard_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Permissions</label>
                        <div class="row" style="max-height: 200px; overflow-y: auto;">
                            @foreach($availablePermissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               wire:model="form.permissions" 
                                               value="{{ $permission->id }}"
                                               class="form-check-input" 
                                               id="create_permission_{{ $permission->id }}">
                                        <label class="form-check-label" for="create_permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary mr-2" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Create Role
                        </button>
                    </div>
                </form>
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
                        <p>Are you sure you want to delete <strong>{{ count($selectedItems) }}</strong> selected role(s)?</p>
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
</div>
