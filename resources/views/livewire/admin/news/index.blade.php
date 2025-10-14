<div>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">News Management</h1>
                <p class="mb-0 text-muted">Create and manage news articles</p>
            </div>
            <button wire:click="create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Article
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
                               placeholder="Search articles...">
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="statusFilter" class="form-select">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select wire:model.live="categoryFilter" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="perPage" class="form-select">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button wire:click="$refresh" class="btn btn-outline-secondary w-100" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Article Form -->
        @if($isCreating)
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Create New Article</h5>
                </div>
                <div class="card-body">
                    <form wire:submit="store">
                        <div class="row">
                            <!-- Left Column - Main Content -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.live="form.title" class="form-control @error('form.title') is-invalid @enderror" placeholder="Enter article title">
                                            @error('form.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="form.slug" class="form-control @error('form.slug') is-invalid @enderror" placeholder="article-slug">
                                            @error('form.slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Excerpt</label>
                                    <textarea wire:model="form.excerpt" class="form-control @error('form.excerpt') is-invalid @enderror" rows="2" placeholder="Brief description"></textarea>
                                    @error('form.excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Content <span class="text-danger">*</span></label>
                                    <textarea wire:model="form.content" class="form-control @error('form.content') is-invalid @enderror" rows="6" placeholder="Write your article content here"></textarea>
                                    @error('form.content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Tags</label>
                                    <input type="text" wire:model="form.tags" class="form-control @error('form.tags') is-invalid @enderror" placeholder="tag1, tag2, tag3">
                                    <small class="text-muted">Separate tags with commas</small>
                                    @error('form.tags') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Right Column - Media & Settings -->
                            <div class="col-md-4">
                                <!-- Featured Image -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Featured Image</label>

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
                                                    <img src="{{ $selectedMediaUrl }}" class="img-fluid rounded" style="max-height: 100px;">
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

                                    <div class="mt-2">
                                        <input type="url" wire:model="form.featured_image" class="form-control form-control-sm @error('form.featured_image') is-invalid @enderror" placeholder="Or image URL">
                                        @error('form.featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Article Meta -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Author <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="form.author_name" class="form-control @error('form.author_name') is-invalid @enderror">
                                            @error('form.author_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Category</label>
                                            <select wire:model="form.category_id" class="form-select @error('form.category_id') is-invalid @enderror">
                                                <option value="">Select</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('form.category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select wire:model="form.status" class="form-select @error('form.status') is-invalid @enderror">
                                                <option value="draft">Draft</option>
                                                <option value="published">Published</option>
                                                <option value="archived">Archived</option>
                                            </select>
                                            @error('form.status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" wire:model="form.featured" id="featured_create">
                                            <label class="form-check-label" for="featured_create">
                                                Featured
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Publish Date</label>
                                    <input type="datetime-local" wire:model="form.published_at" class="form-control @error('form.published_at') is-invalid @enderror">
                                    @error('form.published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Article
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Articles Table -->
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Articles ({{ $news->total() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($news->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">Image</th>
                                    <th>
                                        <button wire:click="sortBy('title')" class="btn btn-sm btn-link p-0 text-decoration-none text-dark">
                                            Title
                                            @if($sortField === 'title')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </button>
                                    </th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>
                                        <button wire:click="sortBy('status')" class="btn btn-sm btn-link p-0 text-decoration-none text-dark">
                                            Status
                                            @if($sortField === 'status')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </button>
                                    </th>
                                    <th>
                                        <button wire:click="sortBy('published_at')" class="btn btn-sm btn-link p-0 text-decoration-none text-dark">
                                            Published
                                            @if($sortField === 'published_at')
                                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </button>
                                    </th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($news as $article)
                                    <tr>
                                        <td>
                                            @if($article->featured_image_url)
                                                <img src="{{ $article->featured_image_url }}"
                                                     class="rounded" style="width: 50px; height: 50px; object-fit: cover;"
                                                     alt="{{ $article->title }}">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $article->title }}</strong>
                                                @if($article->featured)
                                                    <span class="badge bg-warning text-dark ms-1">Featured</span>
                                                @endif
                                            </div>
                                            @if($article->excerpt)
                                                <small class="text-muted">{{ Str::limit($article->excerpt, 60) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($article->category)
                                                <span class="badge bg-info">{{ $article->category->name }}</span>
                                            @else
                                                <span class="text-muted">Uncategorized</span>
                                            @endif
                                        </td>
                                        <td>{{ $article->author_name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm dropdown-toggle
                                                    @if($article->status === 'published') btn-success
                                                    @elseif($article->status === 'draft') btn-warning
                                                    @else btn-secondary @endif"
                                                    type="button" data-bs-toggle="dropdown">
                                                    {{ ucfirst($article->status) }}
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><button class="dropdown-item" wire:click="changeStatus({{ $article->id }}, 'draft')">Draft</button></li>
                                                    <li><button class="dropdown-item" wire:click="changeStatus({{ $article->id }}, 'published')">Published</button></li>
                                                    <li><button class="dropdown-item" wire:click="changeStatus({{ $article->id }}, 'archived')">Archived</button></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            @if($article->published_at)
                                                {{ $article->published_at->format('M j, Y') }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button wire:click="edit({{ $article->id }})"
                                                        class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button wire:click="toggleFeatured({{ $article->id }})"
                                                        class="btn btn-outline-{{ $article->featured ? 'warning' : 'secondary' }}"
                                                        title="{{ $article->featured ? 'Remove from Featured' : 'Mark as Featured' }}">
                                                    <i class="fas fa-star"></i>
                                                </button>

                                                <button wire:click="delete({{ $article->id }})"
                                                        class="btn btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this article?')"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Inline Edit Form -->
                                    @if($editingId === $article->id)
                                        <tr class="bg-light">
                                            <td colspan="7">
                                                <div class="p-4 inline-edit-form">
                                                    <h5 class="mb-3">
                                                        <i class="fas fa-edit me-2"></i>
                                                        Edit Article: {{ $article->title }}
                                                    </h5>

                                                    <form wire:submit="update">
                                                        <div class="row">
                                                            <!-- Left Column - Main Content -->
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                                                            <input type="text" wire:model.live="form.title" class="form-control @error('form.title') is-invalid @enderror">
                                                                            @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                                                                            <input type="text" wire:model="form.slug" class="form-control @error('form.slug') is-invalid @enderror">
                                                                            @error('form.slug') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Excerpt</label>
                                                                    <textarea wire:model="form.excerpt" class="form-control @error('form.excerpt') is-invalid @enderror" rows="2"></textarea>
                                                                    @error('form.excerpt') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Content <span class="text-danger">*</span></label>
                                                                    <textarea wire:model="form.content" class="form-control @error('form.content') is-invalid @enderror" rows="4"></textarea>
                                                                    @error('form.content') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Tags</label>
                                                                    <input type="text" wire:model="form.tags" class="form-control @error('form.tags') is-invalid @enderror" placeholder="tag1, tag2, tag3">
                                                                    @error('form.tags') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Right Column - Media & Settings -->
                                                            <div class="col-md-4">
                                                                <!-- Featured Image Upload -->
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Featured Image</label>

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

                                                                    <div class="mt-2">
                                                                        <input type="url" wire:model="form.featured_image" class="form-control form-control-sm @error('form.featured_image') is-invalid @enderror" placeholder="Or image URL">
                                                                        @error('form.featured_image') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- Article Settings -->
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Author <span class="text-danger">*</span></label>
                                                                            <input type="text" wire:model="form.author_name" class="form-control form-control-sm @error('form.author_name') is-invalid @enderror">
                                                                            @error('form.author_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Category</label>
                                                                            <select wire:model="form.category_id" class="form-select form-select-sm @error('form.category_id') is-invalid @enderror">
                                                                                <option value="">Select</option>
                                                                                @foreach($categories as $category)
                                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('form.category_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-3">
                                                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                                                            <select wire:model="form.status" class="form-select form-select-sm @error('form.status') is-invalid @enderror">
                                                                                <option value="draft">Draft</option>
                                                                                <option value="published">Published</option>
                                                                                <option value="archived">Archived</option>
                                                                            </select>
                                                                            @error('form.status') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-check mt-4">
                                                                            <input class="form-check-input" type="checkbox" wire:model="form.featured" id="featured_{{ $article->id }}">
                                                                            <label class="form-check-label" for="featured_{{ $article->id }}">
                                                                                Featured
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Publish Date</label>
                                                                    <input type="datetime-local" wire:model="form.published_at" class="form-control form-control-sm @error('form.published_at') is-invalid @enderror">
                                                                    @error('form.published_at') <span class="text-danger small">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Form Actions -->
                                                        <div class="d-flex justify-content-between pt-3 border-top">
                                                            <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                                                <i class="fas fa-times me-2"></i>Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fas fa-save me-2"></i>Update Article
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
                        {{ $news->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Articles Found</h5>
                        <p class="text-muted">
                            @if($search || $statusFilter || $categoryFilter)
                                No articles match your current filters.
                            @else
                                Start by creating your first news article.
                            @endif
                        </p>
                        @if(!$search && !$statusFilter && !$categoryFilter)
                            <button wire:click="create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create First Article
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
