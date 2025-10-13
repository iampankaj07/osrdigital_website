<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-key mr-2 text-primary"></i>Permissions Management
            </h4>
            <p class="text-muted small mb-0">Manage system permissions and access controls</p>
        </div>
        <div>
            <button wire:click="create" class="btn btn-dark btn-sm">
                <i class="fas fa-plus mr-1"></i>Add Permission
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search permissions...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="perPage" class="small text-muted mb-1">Per Page</label>
                        <select wire:model.live="perPage" class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="sortField" class="small text-muted mb-1">Sort By</label>
                        <select wire:model.live="sortField" class="form-control form-control-sm">
                            <option value="name">Name</option>
                            <option value="created_at">Created Date</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('name')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 40%;">
                                <span class="d-flex align-items-center">
                                    Permission Name
                                    @if($sortField === 'name')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 15%;">Guard</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 15%;">Roles Count</th>
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
                        @forelse($permissions as $permission)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <div class="font-weight-medium text-dark">{{ $permission->name }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="badge badge-light text-dark border small">{{ $permission->guard_name }}</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="badge badge-{{ $permission->roles_count > 0 ? 'success' : 'light' }} badge-sm">
                                        {{ $permission->roles_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">{{ $permission->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $permission->id }})" 
                                                class="btn btn-dark btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $permission->id }})" 
                                                class="btn btn-danger btn-sm border-0"
                                                title="Delete"
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
                        <button type="button" class="btn btn-secondary btn-sm mr-2" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-dark btn-sm">
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
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-key fa-3x mb-3 opacity-50"></i>
                                        <h5 class="font-weight-normal">No permissions found</h5>
                                        <p class="small">Start by creating your first permission</p>
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
            Showing {{ $permissions->firstItem() ?? 0 }} to {{ $permissions->lastItem() ?? 0 }} of {{ $permissions->total() }} results
        </div>
        <div>
            {{ $permissions->links() }}
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
                        <button type="button" class="btn btn-secondary btn-sm mr-2" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-dark btn-sm">
                            <i class="fas fa-save mr-1"></i>Create Permission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
