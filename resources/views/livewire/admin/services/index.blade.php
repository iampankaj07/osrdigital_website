<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Services</h1>
            <p class="text-muted small mb-0">Manage company services and offerings</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Service
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by title or description...">
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
                    Create New Service
                </h5>

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
                        <button type="button" class="btn btn-secondary btn-sm mr-2" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-dark btn-sm">
                            <i class="fas fa-save mr-1"></i>Create Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Services Table -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th wire:click="sortBy('sort_order')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center space-x-1">
                                <span>Order</span>
                                @if($sortField === 'sort_order')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('title')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center space-x-1">
                                <span>Title</span>
                                @if($sortField === 'title')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($services as $service)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $service->sort_order }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $service->title }}</div>
                                @if($service->slug)
                                    <div class="text-sm text-gray-500">{{ $service->slug }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($service->icon)
                                    <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center">
                                        <i class="{{ $service->icon }} text-brand-orange-600 text-sm"></i>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-cog text-gray-400 text-sm"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 max-w-xs">{{ Str::limit($service->short_description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span wire:click="toggleActive({{ $service->id }})" 
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cursor-pointer transition-colors duration-150 {{ $service->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span wire:click="toggleFeatured({{ $service->id }})" 
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cursor-pointer transition-colors duration-150 {{ $service->is_featured ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                    {{ $service->is_featured ? 'Featured' : 'Not Featured' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="edit({{ $service->id }})" 
                                            class="w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg flex items-center justify-center transition-colors duration-150" 
                                            title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button wire:click="delete({{ $service->id }})" 
                                            class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors duration-150"
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this service?')">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Inline Edit Form -->
                        @if($editingId == $service->id)
                            <tr class="bg-gray-50/50">
                                <td colspan="7" class="px-0">
                                    <div class="bg-white border border-gray-200 rounded-lg mx-6 my-4 shadow-sm">
                                        <div class="px-6 py-4 border-b border-gray-100">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-edit text-brand-orange-600 text-sm"></i>
                                                </div>
                                                <h5 class="text-lg font-medium text-gray-900">Edit Service</h5>
                                            </div>
                                        </div>
                                        <div class="p-6">
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

                                                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                                                    <button type="button" wire:click="cancelEdit" class="btn-slate">
                                                        <i class="fas fa-times mr-2"></i>
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-dark px-6 py-2">
                                                        <i class="fas fa-save mr-2"></i>
                                                        Update Service
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-cogs text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">No services found</h3>
                                    <p class="text-sm text-gray-500">Create your first service to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing {{ $services->firstItem() }} to {{ $services->lastItem() }} of {{ $services->total() }} results
                    </div>
                    <div>
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

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
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="closeIconDropdown">
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