<div>
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-key mr-2"></i>Permissions Management
                    </h5>
                </div>
                <div class="col-auto">
                    @if(count($selectedItems) > 0)
                        <button wire:click="openBulkDeleteModal" class="btn btn-danger mr-2">
                            <i class="fas fa-trash mr-1"></i>Delete Selected ({{ count($selectedItems) }})
                        </button>
                    @endif
                    <button wire:click="create" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i>Add Permission
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filters -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" wire:model="search" class="form-control" placeholder="Search permissions...">
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

            <!-- Permissions Table -->
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
                                Permission Name
                                @if($sortField === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th>Guard</th>
                            <th>Roles Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               wire:model="selectedItems" 
                                               value="{{ $permission->id }}" 
                                               class="form-check-input">
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $permission->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $permission->guard_name }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $permission->roles_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $permission->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button wire:click="edit({{ $permission->id }})" 
                                                class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $permission->id }})" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this permission?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId == $permission->id)
                                <tr>
                                    <td colspan="6" class="p-0">
                                        <div class="card m-2">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-edit mr-2"></i>Edit Permission
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <form wire:submit.prevent="update">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.name">Permission Name <span class="text-danger">*</span></label>
                                                                <input type="text" wire:model="form.name" 
                                                                       class="form-control @error('form.name') is-invalid @enderror" 
                                                                       placeholder="Enter permission name (e.g., users.create)">
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

                                                    <div class="form-group text-right">
                                                        <button type="button" class="btn btn-secondary mr-2" wire:click="cancelEdit">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save mr-1"></i>Update Permission
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
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-key fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No permissions found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $permissions->firstItem() ?? 0 }} to {{ $permissions->lastItem() ?? 0 }} of {{ $permissions->total() }} results
                </div>
                <div>
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus mr-2"></i>Create New Permission
                </h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.name">Permission Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="form.name" 
                                       class="form-control @error('form.name') is-invalid @enderror" 
                                       placeholder="Enter permission name (e.g., users.create)">
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

                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary mr-2" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Create Permission
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
                        <p>Are you sure you want to delete <strong>{{ count($selectedItems) }}</strong> selected permission(s)?</p>
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
