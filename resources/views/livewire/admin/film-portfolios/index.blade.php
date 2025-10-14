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
        <div class="card mb-4">
            <div class="card-body inline-edit-form">
                <h5 class="mb-3">
                    <i class="fas fa-plus mr-2"></i>
                    Create New Film Portfolio
                </h5>

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
                                <label for="form.description">Description</label>
                                <div id="quill-editor-create" style="height: 200px;"></div>
                                <textarea wire:model="form.description" id="quill-textarea-create" style="display: none;"></textarea>
                                @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Upload Options -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Featured Image Upload Method</label>
                                <div class="btn-group d-block">
                                    <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                        <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;"> Media Library
                                    </label>
                                    <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                        <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;"> Upload New
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
                                        <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-images mr-1"></i>Browse Media
                                        </button>
                                        @if($selectedMediaUrl)
                                            <button type="button" wire:click="clearSelectedMedia" class="btn btn-outline-danger btn-sm ml-2">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                    @if($selectedMediaUrl)
                                        <div class="mt-2">
                                            <img src="{{ $selectedMediaUrl }}" alt="Selected Image" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($uploadMethod === 'filepond')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload Featured Image</label>
                                    <div style="max-height: 120px;">
                                        <x-filepond::upload
                                            wire:model="filepondUploads"
                                            multiple="false"
                                            accepted-file-types="image/*"
                                            max-file-size="10MB"
                                            placeholder="Drop image here or <span class='filepond--label-action'>Browse</span>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

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
                            <th wire:click="sortBy('title')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 35%;">
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
                            <th wire:click="sortBy('year')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 10%;">
                                <span class="d-flex align-items-center">
                                    Year
                                    @if($sortField === 'year')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 12%;">Status</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 20%;">Actions</th>
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
                                        @if($film->featured_image_url)
                                            <img src="{{ $film->featured_image_url }}" alt="{{ $film->title }}" class="rounded mr-2" style="width: 50px; height: 35px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded mr-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 35px;">
                                                <i class="fas fa-film text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-medium text-dark">{{ Str::limit($film->title, 40) }}</div>
                                            <div class="text-muted small">{{ Str::limit($film->genre, 20) ?: 'No genre' }}</div>
                                            @if($film->rating)
                                                <div class="text-warning small">
                                                    <i class="fas fa-star mr-1"></i>
                                                    {{ $film->rating }}/10
                                                </div>
                                            @endif
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
                                    <div class="text-muted small">{{ $film->year ?: '-' }}</div>
                                    @if($film->duration)
                                        <div class="text-muted small">{{ $film->duration }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="d-flex flex-column">
                                        <span class="badge badge-{{ $film->is_published ? 'success' : 'light' }} badge-sm mb-1">
                                            {{ $film->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                        @if($film->is_featured)
                                            <span class="badge badge-warning badge-sm">Featured</span>
                                        @endif
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
                                                title="{{ $film->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <button wire:click="togglePublished({{ $film->id }})"
                                                class="btn btn-outline-{{ $film->is_published ? 'warning' : 'success' }} btn-sm border-0"
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
                                    <td colspan="6">
                                        <div class="p-3 inline-edit-form">
                                            <h5 class="mb-3">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit Film Portfolio
                                            </h5>

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
                                                            <label for="form.description">Description</label>
                                                            <div id="quill-editor-edit" style="height: 200px;"></div>
                                                            <textarea wire:model="form.description" id="quill-textarea-edit" style="display: none;"></textarea>
                                                            @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Featured Image Upload Options for Edit -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Featured Image Upload Method</label>
                                                            <div class="btn-group d-block">
                                                                <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                                                    <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;"> Media Library
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                                                    <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;"> Upload New
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
                                                                    <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary btn-sm">
                                                                        <i class="fas fa-images mr-1"></i>Browse Media
                                                                    </button>
                                                                    @if($selectedMediaUrl)
                                                                        <button type="button" wire:click="clearSelectedMedia" class="btn btn-outline-danger btn-sm ml-2">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                @if($selectedMediaUrl)
                                                                    <div class="mt-2">
                                                                        <img src="{{ $selectedMediaUrl }}" alt="Selected Image" class="img-thumbnail" style="max-height: 100px;">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($uploadMethod === 'filepond')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload Featured Image</label>
                                                                <div style="max-height: 120px;">
                                                                    <x-filepond::upload
                                                                        wire:model="filepondUploads"
                                                                        multiple="false"
                                                                        accepted-file-types="image/*"
                                                                        max-file-size="10MB"
                                                                        placeholder="Drop image here or <span class='filepond--label-action'>Browse</span>"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

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

    // Initialize Quill editors
    let quillCreate = null;
    let quillEdit = null;

    function initializeQuillEditors() {
        // Initialize create editor
        if (document.getElementById('quill-editor-create') && !quillCreate) {
            quillCreate = new Quill('#quill-editor-create', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            // Sync create editor with Livewire
            quillCreate.on('text-change', function() {
                const html = quillCreate.root.innerHTML;
                document.getElementById('quill-textarea-create').value = html;
                @this.set('form.description', html);
            });
        }

        // Initialize edit editor
        if (document.getElementById('quill-editor-edit') && !quillEdit) {
            quillEdit = new Quill('#quill-editor-edit', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            // Sync edit editor with Livewire
            quillEdit.on('text-change', function() {
                const html = quillEdit.root.innerHTML;
                document.getElementById('quill-textarea-edit').value = html;
                @this.set('form.description', html);
            });
        }
    }

    // Initialize editors when component loads
    initializeQuillEditors();

    // Re-initialize editors when forms are shown
    Livewire.on('$refresh', function() {
        setTimeout(initializeQuillEditors, 100);
    });

    // Handle form switching
    Livewire.on('formReset', function() {
        if (quillCreate) {
            quillCreate.setContents([]);
        }
        if (quillEdit) {
            quillEdit.setContents([]);
        }
    });

    // Handle edit form population
    Livewire.on('editFormPopulated', function(data) {
        if (quillEdit && data.description) {
            quillEdit.root.innerHTML = data.description;
        }
    });
});
</script>
@endpush
