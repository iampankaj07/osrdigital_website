<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Film Portfolios</h1>
            <p class="text-muted small mb-0">Manage film portfolios and their information</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Film Portfolio
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by title, description, or genre...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="categoryFilter" class="small text-muted mb-1">Category</label>
                        <select wire:model.live="categoryFilter" class="form-control form-control-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
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
            </div>
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mb-4">
            <div class="card-body inline-edit-form">
                <h5 class="mb-3">
                    <i class="fas fa-plus mr-2"></i>
                    Create New Film Portfolio
                </h5>

                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.title">Film Title</label>
                                <input type="text" wire:model="form.title" class="form-control" placeholder="Enter film title">
                                @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.year">Year</label>
                                <input type="number" wire:model="form.year" class="form-control" min="1900" max="{{ date('Y') + 5 }}">
                                @error('form.year') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.genre">Genre</label>
                                <input type="text" wire:model="form.genre" class="form-control" placeholder="e.g., Action, Drama">
                                @error('form.genre') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.slug">Slug</label>
                                <input type="text" wire:model="form.slug" class="form-control" placeholder="Auto-generated from title">
                                @error('form.slug') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.rating">Rating (0-10)</label>
                                <input type="number" wire:model="form.rating" class="form-control" min="0" max="10" step="0.1">
                                @error('form.rating') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.duration">Duration</label>
                                <input type="text" wire:model="form.duration" class="form-control" placeholder="e.g., 120 min">
                                @error('form.duration') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.category_id">Category</label>
                                <select wire:model="form.category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('form.category_id') <span class="text-danger small">{{ $message }}</span> @enderror
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
                                <label for="form.description">Description</label>
                                <textarea wire:model="form.description" class="form-control" rows="3" placeholder="Enter film description"></textarea>
                                @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Upload Options -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Featured Image Upload Method</label>
                                <div class="btn-group d-block" role="group">
                                    <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                        <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;">
                                        <i class="fas fa-folder-open mr-1"></i>
                                        Media Library
                                    </label>
                                    <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                        <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;">
                                        <i class="fas fa-cloud-upload-alt mr-1"></i>
                                        Upload New
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($uploadMethod === 'media_library')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select from Media Library</label>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="openMediaLibrary('featured_image')">
                                            <i class="fas fa-folder-open mr-1"></i>
                                            Browse Media
                                        </button>
                                        @if($selectedMediaUrl)
                                            <button type="button" class="btn btn-outline-danger btn-sm ml-2" wire:click="$set('selectedMediaId', null)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($selectedMediaUrl)
                                    <div class="form-group">
                                        <label>Selected Image</label>
                                        <div class="border rounded p-2">
                                            <img src="{{ $selectedMediaUrl }}" alt="Selected image" class="img-fluid rounded" style="max-height: 150px;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif($uploadMethod === 'filepond')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload New Featured Image</label>
                                    <div class="filepond-upload-area">
                                        <x-filepond::upload wire:model="filepondUploads" multiple="false"
                                            accepted-file-types="image/*" max-file-size="10MB"
                                            placeholder="Drop featured image here or <span class='filepond--label-action'>Browse</span>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($filepondUploads))
                                    <div class="form-group">
                                        <label>Uploaded Image Preview</label>
                                        <div class="border rounded p-2 bg-light">
                                            <div class="text-center">
                                                <i class="fas fa-check-circle text-success mb-2"></i>
                                                <p class="mb-0 small text-muted">Featured image uploaded successfully</p>
                                                <small class="text-muted d-block mt-1">Ready to save</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @error('filepondUploads')
                                    <div class="form-group">
                                        <div class="alert alert-danger alert-sm">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.image_url">Image URL (Alternative)</label>
                                <input type="text" wire:model="form.image_url" class="form-control" placeholder="Enter image URL">
                                @error('form.image_url') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.featured_image">Featured Image URL (Alternative)</label>
                                <input type="text" wire:model="form.featured_image" class="form-control" placeholder="Enter featured image URL">
                                @error('form.featured_image') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.video_url">Video URL</label>
                                <input type="url" wire:model="form.video_url" class="form-control" placeholder="Enter video URL">
                                @error('form.video_url') <span class="text-danger small">{{ $message }}</span> @enderror
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
                            Create Film Portfolio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Film Portfolios Table -->
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
                            <th wire:click="sortBy('title')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 25%;">
                                <span class="d-flex align-items-center">
                                    Film
                                    @if($sortField === 'title')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Category</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Details</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 20%;">Description</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Status</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 7%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($films as $film)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <span class="badge badge-light text-dark border small">{{ $film->sort_order }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="d-flex align-items-start">
                                        @if($film->featured_image)
                                            <img src="{{ $film->featured_image }}" alt="{{ $film->title }}" class="rounded mr-2" style="width: 40px; height: 30px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 30px;">
                                                <i class="fas fa-film text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-medium text-dark">{{ Str::limit($film->title, 30) }}</div>
                                            <div class="text-muted small">{{ $film->year }} • {{ $film->genre }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    @if($film->category)
                                        <span class="badge badge-info badge-sm">{{ $film->category->name }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    <div class="small">
                                        @if($film->rating)
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i> {{ $film->rating }}/10
                                            </div>
                                        @endif
                                        @if($film->duration)
                                            <div class="text-muted">{{ $film->duration }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">{{ Str::limit($film->description, 60) }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        @if($film->is_featured)
                                            <span class="badge badge-warning badge-sm mb-1">Featured</span>
                                        @endif
                                        <span class="badge badge-{{ $film->is_published ? 'success' : 'light' }} badge-sm">
                                            {{ $film->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $film->id }})"
                                                class="btn btn-dark btn-sm border-0"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="toggleFeatured({{ $film->id }})"
                                                class="btn btn-outline-{{ $film->is_featured ? 'warning' : 'secondary' }} btn-sm border-0"
                                                title="{{ $film->is_featured ? 'Remove Featured' : 'Make Featured' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <button wire:click="togglePublished({{ $film->id }})"
                                                class="btn btn-outline-{{ $film->is_published ? 'success' : 'info' }} btn-sm border-0"
                                                title="{{ $film->is_published ? 'Unpublish' : 'Publish' }}">
                                            <i class="fas fa-{{ $film->is_published ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button wire:click="delete({{ $film->id }})"
                                                class="btn btn-danger btn-sm border-0"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this film portfolio?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Inline Edit Form -->
                            @if($editingId === $film->id)
                                <tr class="bg-light">
                                    <td colspan="7">
                                        <div class="p-3 inline-edit-form">
                                            <h5 class="mb-3">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit Film Portfolio
                                            </h5>

                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.title">Film Title</label>
                                                            <input type="text" wire:model="form.title" class="form-control">
                                                            @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.year">Year</label>
                                                            <input type="number" wire:model="form.year" class="form-control" min="1900" max="{{ date('Y') + 5 }}">
                                                            @error('form.year') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.genre">Genre</label>
                                                            <input type="text" wire:model="form.genre" class="form-control">
                                                            @error('form.genre') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.slug">Slug</label>
                                                            <input type="text" wire:model="form.slug" class="form-control">
                                                            @error('form.slug') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.rating">Rating</label>
                                                            <input type="number" wire:model="form.rating" class="form-control" min="0" max="10" step="0.1">
                                                            @error('form.rating') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.duration">Duration</label>
                                                            <input type="text" wire:model="form.duration" class="form-control">
                                                            @error('form.duration') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.category_id">Category</label>
                                                            <select wire:model="form.category_id" class="form-control">
                                                                <option value="">Select Category</option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('form.category_id') <span class="text-danger small">{{ $message }}</span> @enderror
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
                                                            <label for="form.description">Description</label>
                                                            <textarea wire:model="form.description" class="form-control" rows="3"></textarea>
                                                            @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Featured Image Upload Options for Edit -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Featured Image Upload Method</label>
                                                            <div class="btn-group d-block" role="group">
                                                                <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                                                    <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;">
                                                                    <i class="fas fa-folder-open mr-1"></i>
                                                                    Media Library
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                                                    <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;">
                                                                    <i class="fas fa-cloud-upload-alt mr-1"></i>
                                                                    Upload New
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($uploadMethod === 'media_library')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Select from Media Library</label>
                                                                <div class="d-flex align-items-center">
                                                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="openMediaLibrary('featured_image')">
                                                                        <i class="fas fa-folder-open mr-1"></i>
                                                                        Browse Media
                                                                    </button>
                                                                    @if($selectedMediaUrl)
                                                                        <button type="button" class="btn btn-outline-danger btn-sm ml-2" wire:click="$set('selectedMediaId', null)">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if($selectedMediaUrl)
                                                                <div class="form-group">
                                                                    <label>Selected Image</label>
                                                                    <div class="border rounded p-2">
                                                                        <img src="{{ $selectedMediaUrl }}" alt="Selected image" class="img-fluid rounded" style="max-height: 150px;">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @elseif($uploadMethod === 'filepond')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload New Featured Image</label>
                                                                <div class="filepond-upload-area">
                                                                    <x-filepond::upload wire:model="filepondUploads" multiple="false"
                                                                        accepted-file-types="image/*" max-file-size="10MB"
                                                                        placeholder="Drop featured image here or <span class='filepond--label-action'>Browse</span>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            @if (!empty($filepondUploads))
                                                                <div class="form-group">
                                                                    <label>Uploaded Image Preview</label>
                                                                    <div class="border rounded p-2 bg-light">
                                                                        <div class="text-center">
                                                                            <i class="fas fa-check-circle text-success mb-2"></i>
                                                                            <p class="mb-0 small text-muted">Featured image uploaded successfully</p>
                                                                            <small class="text-muted d-block mt-1">Ready to save</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @error('filepondUploads')
                                                                <div class="form-group">
                                                                    <div class="alert alert-danger alert-sm">
                                                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                        {{ $message }}
                                                                    </div>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.image_url">Image URL (Alternative)</label>
                                                            <input type="text" wire:model="form.image_url" class="form-control">
                                                            @error('form.image_url') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.featured_image">Featured Image URL (Alternative)</label>
                                                            <input type="text" wire:model="form.featured_image" class="form-control">
                                                            @error('form.featured_image') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.video_url">Video URL</label>
                                                            <input type="url" wire:model="form.video_url" class="form-control">
                                                            @error('form.video_url') <span class="text-danger small">{{ $message }}</span> @enderror
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
                                        <i class="fas fa-film fa-lg mb-2 opacity-50"></i>
                                        <p class="mb-1 small">No film portfolios found</p>
                                        <small class="text-muted">Click "Add Film Portfolio" to create your first one</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($films->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top bg-light">
                    <div class="text-muted small">
                        {{ $films->firstItem() }}-{{ $films->lastItem() }} of {{ $films->total() }}
                    </div>
                    <div>
                        {{ $films->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Media Library Modal -->
    <div wire:ignore>
        @include('admin.media-library.modal')
    </div>
</div>

@push('scripts')
<script>
function openMediaLibrary(field) {
    if (typeof window.mediaLibraryModal !== 'undefined') {
        window.mediaLibraryModal.show();
        window.currentMediaField = field;
    }
}

// Listen for media selection events
document.addEventListener('livewire:initialized', function () {
    window.addEventListener('media-selected', function(e) {
        if (window.currentMediaField === 'featured_image') {
            @this.call('handleMediaSelection', {
                id: e.detail.id,
                url: e.detail.url
            });
        }
        if (typeof window.mediaLibraryModal !== 'undefined') {
            window.mediaLibraryModal.hide();
        }
    });

    // Enhanced FilePond event handling
    window.addEventListener('filepond-upload-started', function(e) {
        console.log('Upload started:', e.detail);
        // Show loading state
        const uploadAreas = document.querySelectorAll('.filepond-upload-area');
        uploadAreas.forEach(area => {
            area.classList.add('uploading');
        });
    });

    window.addEventListener('filepond-upload-finished', function(e) {
        console.log('Upload finished:', e.detail);
        // Remove loading state
        const uploadAreas = document.querySelectorAll('.filepond-upload-area');
        uploadAreas.forEach(area => {
            area.classList.remove('uploading');
            area.classList.add('upload-success');
        });

        // Trigger Livewire refresh for preview
        @this.$refresh();
    });

    window.addEventListener('filepond-upload-reset', function(e) {
        console.log('Upload reset:', e.detail);
        // Reset states
        const uploadAreas = document.querySelectorAll('.filepond-upload-area');
        uploadAreas.forEach(area => {
            area.classList.remove('uploading', 'upload-success', 'upload-error');
        });
    });

    window.addEventListener('filepond-upload-reverted', function(e) {
        console.log('Upload reverted:', e.detail);
        // Reset preview
        @this.$refresh();
    });
});
</script>
@endpush

@push('styles')
    <style>
        /* FilePond styling for film portfolios */
        .filepond-upload-area {
            min-height: 120px;
        }

        .filepond--root {
            font-size: 0.875rem;
        }

        /* Drop area styling */
        .filepond--drop-label {
            height: auto !important;
            min-height: 100px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .filepond--panel-root {
            min-height: 100px !important;
            border-radius: 0.375rem;
            border: 2px dashed #e9ecef;
            background-color: #f8f9fa;
        }

        /* File item styling */
        .filepond--item {
            height: auto !important;
            min-height: 80px !important;
        }

        .filepond--item-panel {
            height: auto !important;
            min-height: 80px !important;
        }

        /* Image preview styling */
        .filepond--image-preview-wrapper {
            height: auto !important;
            min-height: 80px !important;
        }

        .filepond--image-preview {
            height: auto !important;
            min-height: 80px !important;
            max-height: 120px !important;
            border-radius: 0.375rem;
        }

        /* Process indicator styling */
        .filepond--file-action-button {
            width: 26px;
            height: 26px;
        }

        /* Loading state */
        .filepond--item-panel .filepond--item-process {
            background-color: rgba(0, 123, 255, 0.1);
            border-radius: 0.375rem;
        }

        /* Success state */
        .filepond--item[data-filepond-item-state="processing-complete"] .filepond--item-panel {
            background-color: rgba(40, 167, 69, 0.1);
            border-color: #28a745;
        }

        /* Error state */
        .filepond--item[data-filepond-item-state="processing-error"] .filepond--item-panel {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
        }

        /* Upload area states */
        .filepond-upload-area.uploading {
            opacity: 0.7;
            pointer-events: none;
        }

        .filepond-upload-area.uploading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 123, 255, 0.1);
            border-radius: 0.375rem;
            z-index: 1;
        }

        .filepond-upload-area.upload-success {
            animation: uploadSuccess 0.5s ease-in-out;
        }

        @keyframes uploadSuccess {
            0% { background-color: transparent; }
            50% { background-color: rgba(40, 167, 69, 0.1); }
            100% { background-color: transparent; }
        }

        /* Inline edit form improvements */
        .inline-edit-form {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            margin: 0.5rem 0;
        }

        .inline-edit-form .filepond-upload-area {
            background-color: white;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }

        /* Alert styling */
        .alert-sm {
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .alert-sm i {
            font-size: 0.75rem;
        }

        /* Upload method button styling */
        .btn-group .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn-group .btn.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .btn-group .btn:hover:not(.active) {
            background-color: rgba(0, 123, 255, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .filepond--drop-label {
                min-height: 80px !important;
            }

            .filepond--panel-root {
                min-height: 80px !important;
            }

            .filepond-upload-area {
                min-height: 100px;
            }
        }
    </style>
@endpush
