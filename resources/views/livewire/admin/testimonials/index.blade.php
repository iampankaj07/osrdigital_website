<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Testimonials</h1>
            <p class="text-muted small mb-0">Manage client testimonials and reviews</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Testimonial
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by name, content, company, or project...">
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
                    Create New Testimonial
                </h5>
                
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.name">Client Name</label>
                                <input type="text" wire:model="form.name" class="form-control" placeholder="Enter client name">
                                @error('form.name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.role">Role/Title</label>
                                <input type="text" wire:model="form.role" class="form-control" placeholder="e.g., CEO, Director">
                                @error('form.role') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.company">Company</label>
                                <input type="text" wire:model="form.company" class="form-control" placeholder="Company name">
                                @error('form.company') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.project">Project</label>
                                <input type="text" wire:model="form.project" class="form-control" placeholder="Project name or type">
                                @error('form.project') <span class="text-danger small">{{ $message }}</span> @enderror
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
                                    <input type="checkbox" wire:model="form.is_featured" class="form-check-input">
                                    Featured
                                </label>
                                <br>
                                <label class="form-check-label">
                                    <input type="checkbox" wire:model="form.is_published" class="form-check-input">
                                    Published
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.content">Testimonial Content</label>
                                <textarea wire:model="form.content" class="form-control" rows="4" placeholder="Enter testimonial content"></textarea>
                                @error('form.content') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.avatar_url">Avatar URL</label>
                                <input type="text" wire:model="form.avatar_url" class="form-control" placeholder="Enter avatar image URL">
                                @error('form.avatar_url') <span class="text-danger small">{{ $message }}</span> @enderror
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
                            Create Testimonial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Testimonials Table -->
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
                                    Client
                                    @if($sortField === 'name')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Company/Project</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 35%;">Testimonial</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Status</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 7%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <span class="badge badge-light text-dark border small">{{ $testimonial->sort_order }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="d-flex align-items-start">
                                        @if($testimonial->avatar_url)
                                            <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" class="rounded-circle mr-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-medium text-dark">{{ $testimonial->name }}</div>
                                            @if($testimonial->role)
                                                <div class="text-muted small">{{ $testimonial->role }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="small">
                                        @if($testimonial->company)
                                            <div class="font-weight-medium text-dark">{{ $testimonial->company }}</div>
                                        @endif
                                        @if($testimonial->project)
                                            <div class="text-muted">{{ $testimonial->project }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">{{ Str::limit($testimonial->content, 100) }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        @if($testimonial->is_featured)
                                            <span class="badge badge-warning badge-sm mb-1">Featured</span>
                                        @endif
                                        <span class="badge badge-{{ $testimonial->is_published ? 'success' : 'light' }} badge-sm">
                                            {{ $testimonial->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $testimonial->id }})" 
                                                class="btn btn-dark btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="toggleFeatured({{ $testimonial->id }})" 
                                                class="btn btn-outline-{{ $testimonial->is_featured ? 'warning' : 'secondary' }} btn-sm border-0" 
                                                title="{{ $testimonial->is_featured ? 'Remove Featured' : 'Make Featured' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <button wire:click="togglePublished({{ $testimonial->id }})" 
                                                class="btn btn-outline-{{ $testimonial->is_published ? 'success' : 'info' }} btn-sm border-0" 
                                                title="{{ $testimonial->is_published ? 'Unpublish' : 'Publish' }}">
                                            <i class="fas fa-{{ $testimonial->is_published ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button wire:click="delete({{ $testimonial->id }})" 
                                                class="btn btn-danger btn-sm border-0"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this testimonial?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId === $testimonial->id)
                                <tr class="bg-light">
                                    <td colspan="6">
                                        <div class="p-3 inline-edit-form">
                                            <h5 class="mb-3">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit Testimonial
                                            </h5>
                                            
                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.name">Client Name</label>
                                                            <input type="text" wire:model="form.name" class="form-control">
                                                            @error('form.name') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.role">Role/Title</label>
                                                            <input type="text" wire:model="form.role" class="form-control">
                                                            @error('form.role') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.company">Company</label>
                                                            <input type="text" wire:model="form.company" class="form-control">
                                                            @error('form.company') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.project">Project</label>
                                                            <input type="text" wire:model="form.project" class="form-control">
                                                            @error('form.project') <span class="text-danger small">{{ $message }}</span> @enderror
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
                                                                <input type="checkbox" wire:model="form.is_featured" class="form-check-input">
                                                                Featured
                                                            </label>
                                                            <br>
                                                            <label class="form-check-label">
                                                                <input type="checkbox" wire:model="form.is_published" class="form-check-input">
                                                                Published
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.content">Testimonial Content</label>
                                                            <textarea wire:model="form.content" class="form-control" rows="4"></textarea>
                                                            @error('form.content') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.avatar_url">Avatar URL</label>
                                                            <input type="text" wire:model="form.avatar_url" class="form-control">
                                                            @error('form.avatar_url') <span class="text-danger small">{{ $message }}</span> @enderror
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
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-quote-left fa-lg mb-2 opacity-50"></i>
                                        <p class="mb-1 small">No testimonials found</p>
                                        <small class="text-muted">Click "Add Testimonial" to create your first one</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($testimonials->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top bg-light">
                    <div class="text-muted small">
                        {{ $testimonials->firstItem() }}-{{ $testimonials->lastItem() }} of {{ $testimonials->total() }}
                    </div>
                    <div>
                        {{ $testimonials->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>