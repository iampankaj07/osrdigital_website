<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Team Members</h1>
            <p class="text-muted small mb-0">Manage team members and their information</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Team Member
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by name, position, or department...">
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
            </div>
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mb-4">
            <div class="card-body inline-edit-form">
                <h5 class="mb-3">
                    <i class="fas fa-plus mr-2"></i>
                    Create New Team Member
                </h5>
                
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.name">Full Name</label>
                                <input type="text" wire:model="form.name" class="form-control" placeholder="Enter full name">
                                @error('form.name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.position">Position</label>
                                <input type="text" wire:model="form.position" class="form-control" placeholder="Enter position">
                                @error('form.position') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.department">Department</label>
                                <input type="text" wire:model="form.department" class="form-control" placeholder="Enter department">
                                @error('form.department') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.email">Email</label>
                                <input type="email" wire:model="form.email" class="form-control" placeholder="Enter email address">
                                @error('form.email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.linkedin">LinkedIn URL</label>
                                <input type="url" wire:model="form.linkedin" class="form-control" placeholder="https://linkedin.com/in/username">
                                @error('form.linkedin') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.twitter">Twitter URL</label>
                                <input type="url" wire:model="form.twitter" class="form-control" placeholder="https://twitter.com/username">
                                @error('form.twitter') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.avatar">Avatar URL</label>
                                <input type="text" wire:model="form.avatar" class="form-control" placeholder="Enter avatar URL or path">
                                @error('form.avatar') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.sort_order">Sort Order</label>
                                <input type="number" wire:model="form.sort_order" class="form-control" min="0">
                                @error('form.sort_order') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" wire:model="form.is_active" class="form-check-input">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="button" wire:click="cancelEdit" class="btn btn-secondary mr-2">
                            <i class="fas fa-times mr-1"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i>
                            Create Team Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Team Members Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('sort_order')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 8%;">
                                <span class="d-flex align-items-center">
                                    Order
                                    @if($sortField === 'sort_order')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th wire:click="sortBy('name')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 25%;">
                                <span class="d-flex align-items-center">
                                    Member
                                    @if($sortField === 'name')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 20%;">Position</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Department</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 12%;">Contact</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 8%;">Status</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 12%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teamMembers as $member)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <span class="badge badge-light text-dark border small">{{ $member->sort_order }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="d-flex align-items-start">
                                        @if($member->avatar)
                                            <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="rounded-circle mr-2" style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle mr-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-medium text-dark">{{ Str::limit($member->name, 25) }}</div>
                                            @if($member->email)
                                                <div class="text-muted small">{{ Str::limit($member->email, 30) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-weight-medium text-dark">{{ Str::limit($member->position, 30) }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">{{ $member->department ? Str::limit($member->department, 20) : '-' }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="d-flex flex-column">
                                        @if($member->linkedin)
                                            <a href="{{ $member->linkedin }}" target="_blank" class="text-primary small mb-1">
                                                <i class="fab fa-linkedin mr-1"></i>LinkedIn
                                            </a>
                                        @endif
                                        @if($member->twitter)
                                            <a href="{{ $member->twitter }}" target="_blank" class="text-info small">
                                                <i class="fab fa-twitter mr-1"></i>Twitter
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="badge badge-{{ $member->is_active ? 'success' : 'light' }} badge-sm">
                                        {{ $member->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $member->id }})" 
                                                class="btn btn-dark btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="toggleActive({{ $member->id }})" 
                                                class="btn btn-outline-{{ $member->is_active ? 'warning' : 'success' }} btn-sm border-0" 
                                                title="{{ $member->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $member->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                        <button wire:click="delete({{ $member->id }})" 
                                                class="btn btn-danger btn-sm border-0"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this team member?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId === $member->id)
                                <tr class="bg-light">
                                    <td colspan="7">
                                        <div class="p-3 inline-edit-form">
                                            <h5 class="mb-3">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit Team Member
                                            </h5>
                                            
                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.name">Full Name</label>
                                                            <input type="text" wire:model="form.name" class="form-control">
                                                            @error('form.name') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.position">Position</label>
                                                            <input type="text" wire:model="form.position" class="form-control">
                                                            @error('form.position') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.department">Department</label>
                                                            <input type="text" wire:model="form.department" class="form-control">
                                                            @error('form.department') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.email">Email</label>
                                                            <input type="email" wire:model="form.email" class="form-control">
                                                            @error('form.email') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.linkedin">LinkedIn URL</label>
                                                            <input type="url" wire:model="form.linkedin" class="form-control">
                                                            @error('form.linkedin') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.twitter">Twitter URL</label>
                                                            <input type="url" wire:model="form.twitter" class="form-control">
                                                            @error('form.twitter') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.avatar">Avatar URL</label>
                                                            <input type="text" wire:model="form.avatar" class="form-control">
                                                            @error('form.avatar') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.sort_order">Sort Order</label>
                                                            <input type="number" wire:model="form.sort_order" class="form-control" min="0">
                                                            @error('form.sort_order') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" wire:model="form.is_active" class="form-check-input">
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
</div>

                                                <div class="form-group text-right">
                                                    <button type="button" wire:click="cancelEdit" class="btn btn-secondary mr-2">
                                                        <i class="fas fa-times mr-1"></i>
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-dark">
                                                        <i class="fas fa-save mr-1"></i>
                                                        Update
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-lg mb-2 opacity-50"></i>
                                        <p class="mb-1 small">No team members found</p>
                                        <small class="text-muted">Click "Add Team Member" to create your first one</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($teamMembers->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top bg-light">
                    <div class="text-muted small">
                        {{ $teamMembers->firstItem() }}-{{ $teamMembers->lastItem() }} of {{ $teamMembers->total() }}
                    </div>
                    <div>
                        {{ $teamMembers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>