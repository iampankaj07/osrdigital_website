<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Hero Slider Management</h1>
            <p class="text-muted small mb-0">Create and manage hero slider slides</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add New Slide
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by title, subtitle, or content...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label for="statusFilter" class="small text-muted mb-1">Status</label>
                        <select wire:model.live="statusFilter" class="form-control form-control-sm">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
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
                <div class="col-md-1">
                    <div class="form-group mb-0">
                        <label class="small text-muted mb-1">&nbsp;</label>
                        <button wire:click="$refresh" class="btn btn-outline-secondary btn-sm w-100" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Hero Sliders Table -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($heroSliders->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 80px;">Image</th>
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
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 20%;">Content</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 15%;">Buttons</th>
                            <th wire:click="sortBy('sort_order')" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                                <div class="flex items-center justify-center space-x-1">
                                    <span>Order</span>
                                    @if($sortField === 'sort_order')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                    @else
                                        <i class="fas fa-sort text-gray-300"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($heroSliders as $slider)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($slider->image_url)
                                        <img src="{{ $slider->image_url }}"
                                             class="rounded" style="width: 60px; height: 40px; object-fit: cover;"
                                             alt="{{ $slider->title }}">
                                    @else
                                        <div class="bg-gray-100 rounded flex items-center justify-center"
                                             style="width: 60px; height: 40px;">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $slider->title }}</div>
                                        @if($slider->subtitle)
                                            <div class="text-sm text-gray-500">{{ Str::limit($slider->subtitle, 40) }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($slider->description)
                                        <div class="text-sm text-gray-600 max-w-xs">{{ Str::limit($slider->description, 80) }}</div>
                                    @else
                                        <span class="text-sm text-gray-400">No description</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if($slider->button_text)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $slider->button_text }}</span>
                                        @endif
                                        @if($slider->button_text_secondary)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $slider->button_text_secondary }}</span>
                                        @endif
                                        @if(!$slider->button_text && !$slider->button_text_secondary)
                                            <span class="text-sm text-gray-400">No buttons</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $slider->sort_order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-1">
                                        <button wire:click="edit({{ $slider->id }})"
                                                class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                                title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>

                                        <button wire:click="toggleActive({{ $slider->id }})"
                                                class="inline-flex items-center p-2 {{ $slider->is_active ? 'text-yellow-500 hover:text-yellow-600' : 'text-green-500 hover:text-green-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                                title="{{ $slider->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $slider->is_active ? 'pause' : 'play' }} text-sm"></i>
                                        </button>

                                        <button wire:click="delete({{ $slider->id }})"
                                                class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                                onclick="return confirm('Are you sure you want to delete this slide?')"
                                                title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-image text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900 mb-1">No Hero Slides Found</h3>
                        <p class="text-sm text-gray-500">
                            @if($search || $statusFilter)
                                No slides match your current filters.
                            @else
                                Start by creating your first hero slide.
                            @endif
                        </p>
                        @if(!$search && !$statusFilter)
                            <button wire:click="create" class="btn btn-dark mt-3">
                                <i class="fas fa-plus mr-2"></i>Create First Slide
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($heroSliders->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing {{ $heroSliders->firstItem() }} to {{ $heroSliders->lastItem() }} of {{ $heroSliders->total() }} results
                    </div>
                    <div>
                        {{ $heroSliders->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Media Selector Component -->
    @livewire('components.media-selector')

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
                        <i class="fas fa-plus mr-2"></i>Create New Slide
                    @else
                        <i class="fas fa-edit mr-2"></i>Edit Slide
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
                        <input type="text" wire:model="form.title" class="form-control @error('form.title') is-invalid @enderror" placeholder="Enter slide title">
                        @error('form.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text" wire:model="form.subtitle" class="form-control @error('form.subtitle') is-invalid @enderror" placeholder="Enter subtitle (optional)">
                        @error('form.subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Description</label>
                        <textarea wire:model="form.description" class="form-control @error('form.description') is-invalid @enderror" rows="4" placeholder="Enter description"></textarea>
                        @error('form.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Hero Image -->
                    <div class="form-group mb-3">
                        <label class="form-label">Hero Image</label>

                        <!-- Upload Method Selection -->
                        <div class="mb-2">
                            <div class="btn-group d-block">
                                <label class="btn btn-slate btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                    <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;"> Media Library
                                </label>
                                <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                    <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;"> Upload New
                                </label>
                            </div>
                        </div>

                        @if($uploadMethod === 'media_library')
                            <div class="border rounded p-3 text-center">
                                @if($selectedMediaUrl)
                                    <div class="mb-2">
                                        <img src="{{ $selectedMediaUrl }}" class="img-fluid rounded" style="max-height: 120px;">
                                        <br>
                                        <button type="button" wire:click="clearSelectedMedia" class="btn btn-sm btn-outline-danger mt-2">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                @else
                                    <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                    <p class="text-muted small">No image selected</p>
                                @endif
                                <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-folder-open me-1"></i>Select from Library
                                </button>
                            </div>
                        @endif

                        @if($uploadMethod === 'filepond')
                            <div style="max-height: 120px;">
                                <x-filepond::upload
                                    wire:model="filepondUploads"
                                    multiple="false"
                                    accepted-file-types="image/*"
                                    max-file-size="10MB"
                                    placeholder="Drop image here or <span class='filepond--label-action'>Browse</span>"
                                />
                            </div>
                        @endif
                    </div>

                    <!-- Primary Button -->
                    <div class="form-group mb-3">
                        <label class="form-label">Primary Button Text</label>
                        <input type="text" wire:model="form.button_text" class="form-control @error('form.button_text') is-invalid @enderror" placeholder="e.g. Get Started">
                        @error('form.button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Primary Button URL</label>
                        <input type="url" wire:model="form.button_url" class="form-control @error('form.button_url') is-invalid @enderror" placeholder="https://example.com">
                        @error('form.button_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Secondary Button -->
                    <div class="form-group mb-3">
                        <label class="form-label">Secondary Button Text</label>
                        <input type="text" wire:model="form.button_text_secondary" class="form-control @error('form.button_text_secondary') is-invalid @enderror" placeholder="e.g. Learn More">
                        @error('form.button_text_secondary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Secondary Button URL</label>
                        <input type="url" wire:model="form.button_url_secondary" class="form-control @error('form.button_url_secondary') is-invalid @enderror" placeholder="https://example.com">
                        @error('form.button_url_secondary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Settings -->
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
                            <i class="fas fa-save me-2"></i>{{ $isCreating ? 'Create' : 'Update' }} Slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @script
    <script>
        $wire.on('close-panel-animation', () => {
            // Wait for animation to complete
            setTimeout(() => {
                $wire.finishClosing();
            }, 300);
        });

        // Watch for isClosing property changes
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
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

    .slide-panel-backdrop.fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }

    .slide-panel.slide-out-right {
        animation: slideOutRight 0.3s ease-out forwards;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    @media (max-width: 768px) {
        .slide-panel {
            width: 100vw;
            max-width: 100vw;
        }
    }
</style>
</div>