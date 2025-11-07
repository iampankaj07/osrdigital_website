<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Distribution Services</h1>
            <p class="text-muted small mb-0">Manage distribution services and platforms</p>
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


    <!-- Distribution Services Table -->
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
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($service->icon_data)
                                    @if($service->icon_type === 'font-awesome')
                                        <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center">
                                            <i class="{{ $service->icon_data }} text-brand-orange-600 text-sm"></i>
                                        </div>
                                    @elseif($service->icon_type === 'svg')
                                        <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center">
                                            <div style="width: 16px; height: 16px;">{!! $service->icon_data !!}</div>
                                        </div>
                                    @elseif($service->icon_type === 'image')
                                        <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center">
                                            <img src="{{ $service->icon_data }}" alt="{{ $service->title }}" class="w-4 h-4 rounded">
                                        </div>
                                    @endif
                                @else
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-broadcast-tower text-gray-400 text-sm"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 max-w-xs">{{ Str::limit($service->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($service->link)
                                    <a href="{{ $service->link }}" target="_blank" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors duration-150">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Visit
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-1">
                                    <button wire:click="edit({{ $service->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button wire:click="toggleActive({{ $service->id }})"
                                            class="inline-flex items-center p-2 {{ $service->is_active ? 'text-yellow-500 hover:text-yellow-600' : 'text-green-500 hover:text-green-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="{{ $service->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $service->is_active ? 'pause' : 'play' }} text-sm"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $service->id }}, 'distribution service')"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                            title="Delete">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-broadcast-tower text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">No distribution services found</h3>
                                    <p class="text-sm text-gray-500">Create your first distribution service to get started.</p>
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

    <!-- Slide Panel -->
    @if($showSlidePanel)
        <!-- Backdrop -->
        <div class="slide-panel-backdrop {{ $isClosing ? 'fade-out' : '' }}"
             wire:click="closeSlidePanel"
             wire:key="backdrop-{{ $showSlidePanel }}"></div>

        <!-- Slide Panel -->
        <div class="slide-panel {{ $isClosing ? 'slide-out-right' : '' }}"
             wire:key="panel-{{ $showSlidePanel }}">
            <div class="slide-panel-header">
                <h5 class="mb-0">
                    @if($isCreating)
                        <i class="fas fa-plus mr-2"></i>Create New Distribution Service
                    @else
                        <i class="fas fa-edit mr-2"></i>Edit Distribution Service
                    @endif
                </h5>
                <button type="button" wire:click="closeSlidePanel" class="btn btn-sm btn-link text-muted p-0" style="font-size: 1.5rem; line-height: 1;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="slide-panel-body">
                <form wire:submit="{{ $isCreating ? 'store' : 'update' }}">
                    <div class="form-group mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" wire:model="form.title" class="form-control @error('form.title') is-invalid @enderror" placeholder="Enter service title">
                        @error('form.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea wire:model="form.description" class="form-control @error('form.description') is-invalid @enderror" rows="4" placeholder="Detailed description of the service"></textarea>
                        @error('form.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Link</label>
                        <input type="url" wire:model="form.link" class="form-control @error('form.link') is-invalid @enderror" placeholder="https://example.com">
                        @error('form.link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Icon <span class="text-danger">*</span></label>
                        <select wire:model="form.icon_data" class="form-control @error('form.icon_data') is-invalid @enderror">
                            @foreach($availableIcons as $iconClass => $iconName)
                                <option value="{{ $iconClass }}">{{ $iconName }}</option>
                            @endforeach
                        </select>
                        @error('form.icon_data') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if($form['icon_data'])
                            <div class="mt-2">
                                <small class="text-muted">Preview: </small>
                                <i class="{{ $form['icon_data'] }} text-primary fa-lg"></i>
                                <code class="ml-2 small">{{ $form['icon_data'] }}</code>
                            </div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" wire:model="form.sort_order" class="form-control @error('form.sort_order') is-invalid @enderror" min="0">
                        @error('form.sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model="form.is_active" id="is_active_slide">
                        <label class="form-check-label" for="is_active_slide">
                            Active
                        </label>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between pt-3 border-top mt-4">
                        <button type="button" wire:click="closeSlidePanel" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>{{ $isCreating ? 'Create' : 'Update' }} Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @script
    <script>
        $wire.on('close-panel-animation', () => {
            setTimeout(() => {
                $wire.finishClosing();
            }, 300);
        });

        Livewire.hook('morph.updated', ({ el, component }) => {
            const panel = el.querySelector('.slide-panel.slide-out-right');
            if (panel && !panel.dataset.closingHandled) {
                panel.dataset.closingHandled = 'true';
                setTimeout(() => {
                    $wire.finishClosing();
                }, 300);
            }
        });
    </script>
    @endscript

<style>
    /* Slide Panel Styles */
    .slide-panel-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        animation: fadeIn 0.3s ease-out;
    }

    .slide-panel {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        width: 600px;
        max-width: 90vw;
        background: white;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1050;
        display: flex;
        flex-direction: column;
        animation: slideInRight 0.3s ease-out;
        overflow-y: auto;
    }

    .slide-panel-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .slide-panel-body {
        padding: 1.5rem;
        flex: 1;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(100%);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    .slide-panel-backdrop.fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }

    .slide-panel.slide-out-right {
        animation: slideOutRight 0.3s ease-out forwards;
    }

    @media (max-width: 768px) {
        .slide-panel {
            width: 100vw;
            max-width: 100vw;
        }
    }
</style>
    @include('livewire.admin.partials.delete-confirm')
</div>
