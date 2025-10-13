<div>
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs mr-2"></i>Services Management
                    </h5>
                </div>
                <div class="col-auto">
                    <button wire:click="create" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i>Add Service
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filters -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" wire:model="search" class="form-control" placeholder="Search services...">
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
                        <option value="sort_order">Sort Order</option>
                        <option value="title">Title</option>
                        <option value="created_at">Created Date</option>
                    </select>
                </div>
            </div>

            <!-- Services Table -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('title')" style="cursor: pointer;">
                                Title
                                @if($sortField === 'title')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th>Icon</th>
                            <th>Short Description</th>
                            <th wire:click="sortBy('sort_order')" style="cursor: pointer;">
                                Order
                                @if($sortField === 'sort_order')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>
                                    <strong>{{ $service->title }}</strong>
                                    @if($service->slug)
                                        <br><small class="text-muted">{{ $service->slug }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($service->icon)
                                        <i class="{{ $service->icon }} fa-lg text-primary"></i>
                                    @else
                                        <span class="text-muted">No icon</span>
                                    @endif
                                </td>
                                <td>
                                    {{ Str::limit($service->short_description, 50) }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $service->sort_order }}</span>
                                </td>
                                <td>
                                    <span wire:click="toggleActive({{ $service->id }})" 
                                          class="badge badge-{{ $service->is_active ? 'success' : 'secondary' }} badge-pill" 
                                          style="cursor: pointer;">
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <span wire:click="toggleFeatured({{ $service->id }})" 
                                          class="badge badge-{{ $service->is_featured ? 'warning' : 'light' }} badge-pill" 
                                          style="cursor: pointer;">
                                        {{ $service->is_featured ? 'Featured' : 'Not Featured' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button wire:click="edit({{ $service->id }})" 
                                                class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $service->id }})" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this service?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId == $service->id)
                                <tr>
                                    <td colspan="7" class="p-0">
                                        <div class="card m-2">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-edit mr-2"></i>Edit Service
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <form wire:submit.prevent="update">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.title">Title <span class="text-danger">*</span></label>
                                                                <input type="text" wire:model="form.title" 
                                                                       class="form-control @error('form.title') is-invalid @enderror" 
                                                                       placeholder="Enter service title">
                                                                @error('form.title')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.slug">Slug</label>
                                                                <input type="text" wire:model="form.slug" 
                                                                       class="form-control @error('form.slug') is-invalid @enderror" 
                                                                       placeholder="service-slug">
                                                                @error('form.slug')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="form.short_description">Short Description</label>
                                                        <textarea wire:model="form.short_description" 
                                                                  class="form-control @error('form.short_description') is-invalid @enderror" 
                                                                  rows="2" placeholder="Brief description of the service"></textarea>
                                                        @error('form.short_description')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="form.description">Description <span class="text-danger">*</span></label>
                                                        <textarea wire:model="form.description" 
                                                                  class="form-control @error('form.description') is-invalid @enderror" 
                                                                  rows="3" placeholder="Detailed description of the service"></textarea>
                                                        @error('form.description')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="form.icon">Service Icon</label>
                                                        <div class="input-group">
                                                            <input type="text" wire:model="form.icon" 
                                                                   class="form-control @error('form.icon') is-invalid @enderror" 
                                                                   placeholder="Select an icon" readonly>
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-secondary" 
                                                                        wire:click="openIconDropdown">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                                @if($form['icon'])
                                                                    <button type="button" class="btn btn-outline-danger" 
                                                                            wire:click="clearIcon">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if($form['icon'])
                                                            <div class="mt-2">
                                                                <small class="text-muted">Selected: </small>
                                                                <i class="{{ $form['icon'] }} text-primary"></i>
                                                                <code class="ml-2">{{ $form['icon'] }}</code>
                                                            </div>
                                                        @endif
                                                        @error('form.icon')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="form.sort_order">Sort Order <span class="text-danger">*</span></label>
                                                                <input type="number" wire:model="form.sort_order" 
                                                                       class="form-control @error('form.sort_order') is-invalid @enderror" 
                                                                       min="0">
                                                                @error('form.sort_order')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="form-check mt-4">
                                                                    <input type="checkbox" wire:model="form.is_featured" 
                                                                           class="form-check-input @error('form.is_featured') is-invalid @enderror" 
                                                                           id="form.is_featured">
                                                                    <label class="form-check-label" for="form.is_featured">
                                                                        Featured Service
                                                                    </label>
                                                                </div>
                                                                @error('form.is_featured')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="form-check mt-4">
                                                                    <input type="checkbox" wire:model="form.is_active" 
                                                                           class="form-check-input @error('form.is_active') is-invalid @enderror" 
                                                                           id="form.is_active">
                                                                    <label class="form-check-label" for="form.is_active">
                                                                        Active
                                                                    </label>
                                                                </div>
                                                                @error('form.is_active')
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
                                                            <i class="fas fa-save mr-1"></i>Update Service
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
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No services found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }} of {{ $services->total() }} results
                </div>
                <div>
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus mr-2"></i>Create New Service
                </h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.title">Title <span class="text-danger">*</span></label>
                                <input type="text" wire:model="form.title" 
                                       class="form-control @error('form.title') is-invalid @enderror" 
                                       placeholder="Enter service title">
                                @error('form.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.slug">Slug</label>
                                <input type="text" wire:model="form.slug" 
                                       class="form-control @error('form.slug') is-invalid @enderror" 
                                       placeholder="service-slug">
                                @error('form.slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form.short_description">Short Description</label>
                        <textarea wire:model="form.short_description" 
                                  class="form-control @error('form.short_description') is-invalid @enderror" 
                                  rows="2" placeholder="Brief description of the service"></textarea>
                        @error('form.short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="form.description">Description <span class="text-danger">*</span></label>
                        <textarea wire:model="form.description" 
                                  class="form-control @error('form.description') is-invalid @enderror" 
                                  rows="4" placeholder="Detailed description of the service"></textarea>
                        @error('form.description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="form.icon">Service Icon</label>
                        <div class="input-group">
                            <input type="text" wire:model="form.icon" 
                                   class="form-control @error('form.icon') is-invalid @enderror" 
                                   placeholder="Select an icon" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" 
                                        wire:click="openIconDropdown">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if($form['icon'])
                                    <button type="button" class="btn btn-outline-danger" 
                                            wire:click="clearIcon">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        @if($form['icon'])
                            <div class="mt-2">
                                <small class="text-muted">Selected: </small>
                                <i class="{{ $form['icon'] }} text-primary"></i>
                                <code class="ml-2">{{ $form['icon'] }}</code>
                            </div>
                        @endif
                        @error('form.icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.sort_order">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" wire:model="form.sort_order" 
                                       class="form-control @error('form.sort_order') is-invalid @enderror" 
                                       min="0">
                                @error('form.sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-check mt-4">
                                    <input type="checkbox" wire:model="form.is_featured" 
                                           class="form-check-input @error('form.is_featured') is-invalid @enderror" 
                                           id="form.is_featured">
                                    <label class="form-check-label" for="form.is_featured">
                                        Featured Service
                                    </label>
                                </div>
                                @error('form.is_featured')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-check mt-4">
                                    <input type="checkbox" wire:model="form.is_active" 
                                           class="form-check-input @error('form.is_active') is-invalid @enderror" 
                                           id="form.is_active">
                                    <label class="form-check-label" for="form.is_active">
                                        Active
                                    </label>
                                </div>
                                @error('form.is_active')
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
                            <i class="fas fa-save mr-1"></i>Create Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Icon Selection Modal -->
    @if($showIconDropdown)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-icons mr-2"></i>Select Service Icon
                        </h5>
                        <button type="button" class="close" wire:click="closeIconDropdown">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model="iconSearch" 
                                   class="form-control" 
                                   placeholder="Search icons by name or class...">
</div>

                        <div style="max-height: 400px; overflow-y: auto;">
                            @foreach($this->getFilteredIcons() as $iconClass => $iconName)
                                <div class="icon-option-list" 
                                     wire:click="selectIcon('{{ $iconClass }}')"
                                     style="cursor: pointer; transition: all 0.2s; padding: 10px; border: 1px solid #e9ecef; margin-bottom: 5px; border-radius: 5px;">
                                    <div class="d-flex align-items-center">
                                        <i class="{{ $iconClass }} fa-lg text-primary mr-3"></i>
                                        <div class="flex-grow-1">
                                            <strong>{{ $iconName }}</strong>
                                            <br>
                                            <code class="small text-muted">{{ $iconClass }}</code>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if(empty($this->getFilteredIcons()))
                                <div class="text-center py-4">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No icons found matching "{{ $iconSearch }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeIconDropdown">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .icon-option-list:hover {
            background-color: #f8f9fa;
            border-color: #007bff;
            transform: translateX(5px);
        }
        
        .icon-option-list {
            transition: all 0.2s ease;
        }
        
        .badge[style*="cursor: pointer"]:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }
        
        .badge[style*="cursor: pointer"] {
            transition: all 0.2s ease;
        }
    </style>
</div>