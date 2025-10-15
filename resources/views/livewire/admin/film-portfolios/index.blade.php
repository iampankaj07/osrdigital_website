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

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-6 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-plus text-brand-orange-600 text-sm"></i>
                    </div>
                    <h5 class="text-lg font-medium text-gray-900">Create New Film Portfolio</h5>
                </div>
            </div>
            <div class="p-6">

                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="form.title">Film Title</label>
                                <input type="text" wire:model="form.title" class="form-control" placeholder="Enter film title">
                                @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.year">Release Year</label>
                                <input type="number" wire:model="form.year" class="form-control" min="1900" max="{{ date('Y') + 5 }}" placeholder="2024">
                                @error('form.year') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.genre">Genre</label>
                                <input type="text" wire:model="form.genre" class="form-control" placeholder="Enter genre">
                                @error('form.genre') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.sort_order">Sort Order</label>
                                <input type="number" wire:model="form.sort_order" class="form-control" min="0">
                                @error('form.sort_order') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.duration">Duration</label>
                                <input type="text" wire:model="form.duration" class="form-control" placeholder="e.g., 120 min">
                                @error('form.duration') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.rating">Rating (0-10)</label>
                                <input type="number" wire:model="form.rating" class="form-control" min="0" max="10" step="0.1" placeholder="8.5">
                                @error('form.rating') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.link">Link (Optional)</label>
                                <input type="url" wire:model="form.link" class="form-control" placeholder="https://example.com">
                                @error('form.link') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.description">Description</label>
                                <textarea wire:model="form.description" class="form-control" rows="5" placeholder="Enter film description..."></textarea>
                                @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Upload -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Featured Image</label>
                                <div class="border rounded p-3" style="border-style: dashed !important;">
                                    <div class="text-center">
                                        @if($selectedMediaUrl)
                                            <div class="mb-3">
                                                <img src="{{ $selectedMediaUrl }}" alt="Selected Image" class="img-thumbnail" style="max-height: 150px;">
                                            </div>
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-images mr-1"></i>Change Image
                                                </button>
                                                <button type="button" wire:click="clearSelectedMedia" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash mr-1"></i>Remove
                                                </button>
                                            </div>
                                        @else
                                            <div class="py-4">
                                                <i class="fas fa-cloud-upload-alt text-muted mb-3" style="font-size: 2rem;"></i>
                                                <p class="text-muted mb-3">No image selected</p>
                                                <button type="button" wire:click="openMediaSelector" class="btn-slate">
                                                    <i class="fas fa-images mr-1"></i>Select Image
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" wire:model="form.is_featured" class="form-check-input">
                                    Featured Film
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" wire:model="form.is_published" class="form-check-input">
                                    Published
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                        <button type="button" wire:click="cancelEdit" class="btn-slate">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-dark px-6 py-2">
                            <i class="fas fa-plus mr-2"></i>
                            Create Film Portfolio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Film Portfolios Table -->
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
                                <span>Film</span>
                                @if($sortField === 'title')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th wire:click="sortBy('year')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center space-x-1">
                                <span>Year</span>
                                @if($sortField === 'year')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($films as $film)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $film->sort_order }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($film->featured_image_url)
                                            <img src="{{ $film->featured_image_url }}" alt="{{ $film->title }}" class="w-12 h-16 rounded-lg object-cover shadow-sm">
                                        @else
                                            <div class="w-12 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-film text-gray-400 text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ $film->title }}
                                        </div>
                                        <div class="text-sm text-gray-500 truncate">
                                            {{ $film->genre ?: 'No genre' }}
                                        </div>
                                        @if($film->rating)
                                            <div class="flex items-center mt-1">
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star text-xs {{ $i <= ($film->rating / 2) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="ml-1 text-xs text-gray-500">{{ $film->rating }}/10</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($film->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $film->category->name }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $film->year ?: '-' }}</div>
                                @if($film->duration)
                                    <div class="text-xs text-gray-500">{{ $film->duration }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center space-y-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $film->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $film->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                    @if($film->is_featured)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-1">
                                    <button wire:click="edit({{ $film->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button wire:click="toggleFeatured({{ $film->id }})"
                                            class="inline-flex items-center p-2 {{ $film->is_featured ? 'text-yellow-500 hover:text-yellow-600' : 'text-gray-400 hover:text-gray-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="{{ $film->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}">
                                        <i class="fas fa-star text-sm"></i>
                                    </button>
                                    <button wire:click="togglePublished({{ $film->id }})"
                                            class="inline-flex items-center p-2 {{ $film->is_published ? 'text-green-500 hover:text-green-600' : 'text-gray-400 hover:text-gray-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="{{ $film->is_published ? 'Unpublish' : 'Publish' }}">
                                        <i class="fas fa-{{ $film->is_published ? 'eye-slash' : 'eye' }} text-sm"></i>
                                    </button>
                                    <button wire:click="delete({{ $film->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this film portfolio?')">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                            <!-- Inline Edit Form -->
                            @if($editingId === $film->id)
                                <tr class="bg-gray-50/50">
                                    <td colspan="6" class="px-0">
                                        <div class="bg-white border border-gray-200 rounded-lg mx-6 my-4 shadow-sm">
                                            <div class="px-6 py-4 border-b border-gray-100">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center mr-3">
                                                        <i class="fas fa-edit text-brand-orange-600 text-sm"></i>
                                                    </div>
                                                    <h5 class="text-lg font-medium text-gray-900">Edit Film Portfolio</h5>
                                                </div>
                                            </div>
                                            <div class="p-6">

                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="form.title">Film Title</label>
                                                            <input type="text" wire:model="form.title" class="form-control">
                                                            @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.year">Release Year</label>
                                                            <input type="number" wire:model="form.year" class="form-control" min="1900" max="{{ date('Y') + 5 }}">
                                                            @error('form.year') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.genre">Genre</label>
                                                            <input type="text" wire:model="form.genre" class="form-control">
                                                            @error('form.genre') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
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
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.sort_order">Sort Order</label>
                                                            <input type="number" wire:model="form.sort_order" class="form-control" min="0">
                                                            @error('form.sort_order') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.duration">Duration</label>
                                                            <input type="text" wire:model="form.duration" class="form-control">
                                                            @error('form.duration') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.rating">Rating (0-10)</label>
                                                            <input type="number" wire:model="form.rating" class="form-control" min="0" max="10" step="0.1">
                                                            @error('form.rating') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.link">Link (Optional)</label>
                                                            <input type="url" wire:model="form.link" class="form-control" placeholder="https://example.com">
                                                            @error('form.link') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.description">Description</label>
                                                            <textarea wire:model="form.description" class="form-control" rows="5" placeholder="Enter film description..."></textarea>
                                                            @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Featured Image Upload for Edit -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Featured Image</label>
                                                            <div class="border rounded p-3" style="border-style: dashed !important;">
                                                                <div class="text-center">
                                                                    @if($selectedMediaUrl)
                                                                        <div class="mb-3">
                                                                            <img src="{{ $selectedMediaUrl }}" alt="Selected Image" class="img-thumbnail" style="max-height: 150px;">
                                                                        </div>
                                                                        <div class="d-flex justify-content-center gap-2">
                                                                            <button type="button" wire:click="openMediaSelector" class="btn-slate btn-sm">
                                                                                <i class="fas fa-images mr-1"></i>Change Image
                                                                            </button>
                                                                            <button type="button" wire:click="clearSelectedMedia" class="btn btn-outline-danger btn-sm">
                                                                                <i class="fas fa-trash mr-1"></i>Remove
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <div class="py-4">
                                                                            <i class="fas fa-cloud-upload-alt text-muted mb-3" style="font-size: 2rem;"></i>
                                                                            <p class="text-muted mb-3">No image selected</p>
                                                                            <button type="button" wire:click="openMediaSelector" class="btn-slate">
                                                                                <i class="fas fa-images mr-1"></i>Select Image
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" wire:model="form.is_featured" class="form-check-input">
                                                                Featured Film
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" wire:model="form.is_published" class="form-check-input">
                                                                Published
                                                            </label>
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
                                                        Update Film
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-film text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">No film portfolios found</h3>
                                    <p class="text-sm text-gray-500">Get started by creating your first film portfolio.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($films->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $films->firstItem() }}</span> to <span class="font-medium">{{ $films->lastItem() }}</span> of <span class="font-medium">{{ $films->total() }}</span> results
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $films->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    @livewire('components.media-selector')
</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', function() {
    console.log('Film Portfolios - Livewire initialized');

    // Handle media selection events
    window.addEventListener('mediaSelected', function(event) {
        @this.call('handleMediaSelection', event.detail);
    });
});
</script>
@endpush
