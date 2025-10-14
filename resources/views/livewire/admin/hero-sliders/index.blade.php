<div>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Hero Slider Management</h1>
                <p class="mb-0 text-muted">Create and manage hero slider slides</p>
            </div>
            <button wire:click="create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Slide
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

        <!-- Filters and Search -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" wire:model.live="search" class="form-control"
                               placeholder="Search slides...">
                    </div>
                    <div class="col-md-3">
                        <select wire:model.live="statusFilter" class="form-select">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="perPage" class="form-select">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button wire:click="$refresh" class="btn btn-outline-secondary w-100" title="Refresh">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Slide Form -->
        @if($isCreating)
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Create New Slide</h5>
                </div>
                <div class="card-body">
                    <form wire:submit="store">
                        <div class="row">
                            <!-- Left Column - Content -->
                            <div class="col-md-8">
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

                                <!-- Buttons Row -->
                                <div class="row">
                                    <div class="col-md-6">
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
                                    </div>
                                    <div class="col-md-6">
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
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Image & Settings -->
                            <div class="col-md-4">
                                <!-- Hero Image -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Hero Image</label>

                                    <!-- Upload Method Selection -->
                                    <div class="mb-2">
                                        <div class="btn-group d-block">
                                            <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
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

                                <!-- Settings -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Sort Order</label>
                                            <input type="number" wire:model="form.sort_order" class="form-control @error('form.sort_order') is-invalid @enderror" min="0">
                                            @error('form.sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" wire:model="form.is_active" id="is_active_create">
                                            <label class="form-check-label" for="is_active_create">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Slide
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Hero Sliders Table -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Hero Slides ({{ $heroSliders->total() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($heroSliders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="80">Image</th>
                                    <th>
                                        <button wire:click="sortBy('title')" class="btn btn-sm btn-link p-0 text-decoration-none text-dark">
                                            Title
                                            @if($sortField === 'title')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </button>
                                    </th>
                                    <th>Content</th>
                                    <th>Buttons</th>
                                    <th>
                                        <button wire:click="sortBy('sort_order')" class="btn btn-sm btn-link p-0 text-decoration-none text-dark">
                                            Order
                                            @if($sortField === 'sort_order')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </button>
                                    </th>
                                    <th>Status</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($heroSliders as $slider)
                                    <tr>
                                        <td>
                                            @if($slider->image_url)
                                                <img src="{{ $slider->image_url }}"
                                                     class="rounded" style="width: 60px; height: 40px; object-fit: cover;"
                                                     alt="{{ $slider->title }}">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="width: 60px; height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $slider->title }}</strong>
                                                @if($slider->subtitle)
                                                    <br><small class="text-muted">{{ Str::limit($slider->subtitle, 40) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($slider->description)
                                                <small class="text-muted">{{ Str::limit($slider->description, 80) }}</small>
                                            @else
                                                <span class="text-muted">No description</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small">
                                                @if($slider->button_text)
                                                    <span class="badge bg-primary">{{ $slider->button_text }}</span>
                                                @endif
                                                @if($slider->button_text_secondary)
                                                    <span class="badge bg-secondary">{{ $slider->button_text_secondary }}</span>
                                                @endif
                                                @if(!$slider->button_text && !$slider->button_text_secondary)
                                                    <span class="text-muted">No buttons</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $slider->sort_order }}</span>
                                        </td>
                                        <td>
                                            <button wire:click="toggleActive({{ $slider->id }})"
                                                    class="btn btn-sm btn-{{ $slider->is_active ? 'success' : 'secondary' }}">
                                                {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button wire:click="edit({{ $slider->id }})"
                                                        class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button wire:click="delete({{ $slider->id }})"
                                                        class="btn btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this slide?')"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Inline Edit Form -->
                                    @if($editingId === $slider->id)
                                        <tr class="bg-light">
                                            <td colspan="7">
                                                <div class="p-4 inline-edit-form">
                                                    <h5 class="mb-3">
                                                        <i class="fas fa-edit me-2"></i>
                                                        Edit Slide: {{ $slider->title }}
                                                    </h5>

                                                    <form wire:submit="update">
                                                        <div class="row">
                                                            <!-- Left Column - Content -->
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                                                            <input type="text" wire:model="form.title" class="form-control @error('form.title') is-invalid @enderror">
                                                                            @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Subtitle</label>
                                                                            <input type="text" wire:model="form.subtitle" class="form-control @error('form.subtitle') is-invalid @enderror">
                                                                            @error('form.subtitle') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Description</label>
                                                                    <textarea wire:model="form.description" class="form-control @error('form.description') is-invalid @enderror" rows="3"></textarea>
                                                                    @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                </div>

                                                                <!-- Buttons Row -->
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Primary Button Text</label>
                                                                            <input type="text" wire:model="form.button_text" class="form-control @error('form.button_text') is-invalid @enderror">
                                                                            @error('form.button_text') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>

                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Primary Button URL</label>
                                                                            <input type="url" wire:model="form.button_url" class="form-control @error('form.button_url') is-invalid @enderror">
                                                                            @error('form.button_url') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Secondary Button Text</label>
                                                                            <input type="text" wire:model="form.button_text_secondary" class="form-control @error('form.button_text_secondary') is-invalid @enderror">
                                                                            @error('form.button_text_secondary') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>

                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Secondary Button URL</label>
                                                                            <input type="url" wire:model="form.button_url_secondary" class="form-control @error('form.button_url_secondary') is-invalid @enderror">
                                                                            @error('form.button_url_secondary') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Right Column - Image & Settings -->
                                                            <div class="col-md-4">
                                                                <!-- Hero Image -->
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Hero Image</label>

                                                                    <!-- Upload Method Selection -->
                                                                    <div class="mb-2">
                                                                        <div class="btn-group d-block">
                                                                            <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                                                                <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;"> Media Library
                                                                            </label>
                                                                            <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                                                                <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;"> Upload New
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                    @if($uploadMethod === 'media_library')
                                                                        <div class="border rounded p-2 text-center" style="min-height: 120px;">
                                                                            @if($selectedMediaUrl)
                                                                                <img src="{{ $selectedMediaUrl }}" class="img-fluid rounded mb-2" style="max-height: 80px;">
                                                                                <br>
                                                                                <button type="button" wire:click="clearSelectedMedia" class="btn btn-sm btn-outline-danger">
                                                                                    <i class="fas fa-times"></i>
                                                                                </button>
                                                                            @else
                                                                                <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                                                                <p class="small text-muted mb-2">No image selected</p>
                                                                            @endif
                                                                            <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary btn-sm">
                                                                                <i class="fas fa-folder-open me-1"></i>Select
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
                                                                                placeholder="Drop image or <span class='filepond--label-action'>Browse</span>"
                                                                            />
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <!-- Settings -->
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Sort Order</label>
                                                                            <input type="number" wire:model="form.sort_order" class="form-control form-control-sm @error('form.sort_order') is-invalid @enderror" min="0">
                                                                            @error('form.sort_order') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-check mt-4">
                                                                            <input class="form-check-input" type="checkbox" wire:model="form.is_active" id="is_active_{{ $slider->id }}">
                                                                            <label class="form-check-label" for="is_active_{{ $slider->id }}">
                                                                                Active
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Form Actions -->
                                                        <div class="d-flex justify-content-between pt-3 border-top">
                                                            <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                                                <i class="fas fa-times me-2"></i>Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fas fa-save me-2"></i>Update Slide
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        {{ $heroSliders->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Hero Slides Found</h5>
                        <p class="text-muted">
                            @if($search || $statusFilter)
                                No slides match your current filters.
                            @else
                                Start by creating your first hero slide.
                            @endif
                        </p>
                        @if(!$search && !$statusFilter)
                            <button wire:click="create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create First Slide
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Media Selector Component -->
    @livewire('components.media-selector')
</div>
