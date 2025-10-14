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

        <!-- Create/Edit Form -->
        @if($isCreating || $editingId)
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ $isCreating ? 'Create New Article' : 'Edit Article' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit="{{ $isCreating ? 'store' : 'update' }}">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.live="form.title" class="form-control @error('form.title') is-invalid @enderror" 
                                           id="title" placeholder="Enter article title">
                                    @error('form.title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="form.slug" class="form-control @error('form.slug') is-invalid @enderror" 
                                           id="slug" placeholder="article-slug">
                                    @error('form.slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Excerpt</label>
                                    <textarea wire:model="form.excerpt" class="form-control @error('form.excerpt') is-invalid @enderror" 
                                              id="excerpt" rows="3" placeholder="Brief description of the article"></textarea>
                                    @error('form.excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                    <textarea wire:model="form.content" class="form-control @error('form.content') is-invalid @enderror" 
                                              id="content" rows="8" placeholder="Write your article content here"></textarea>
                                    @error('form.content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <input type="text" wire:model="form.tags" class="form-control @error('form.tags') is-invalid @enderror" 
                                           id="tags" placeholder="tag1, tag2, tag3">
                                    <small class="text-muted">Separate tags with commas</small>
                                    @error('form.tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-md-4">
                                <!-- Featured Image -->
                                <div class="mb-4">
                                    <label class="form-label">Featured Image</label>
                                    
                                    <!-- Upload Method Selection -->
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model="uploadMethod" 
                                                   id="media_library" value="media_library">
                                            <label class="form-check-label" for="media_library">Media Library</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model="uploadMethod" 
                                                   id="direct_upload" value="filepond">
                                            <label class="form-check-label" for="direct_upload">Upload New</label>
                                        </div>
                                    </div>

                                    <!-- Media Library Selection -->
                                    @if($uploadMethod === 'media_library')
                                        <div class="border rounded p-3 text-center">
                                            @if($selectedMediaUrl)
                                                <div class="mb-3">
                                                    <img src="{{ $selectedMediaUrl }}" class="img-fluid rounded" 
                                                         style="max-height: 200px;" alt="Selected media">
                                                    <button type="button" wire:click="clearSelectedMedia" 
                                                            class="btn btn-sm btn-outline-danger mt-2">
                                                        <i class="fas fa-times me-1"></i>Remove
                                                    </button>
                                                </div>
                                            @else
                                                <div class="mb-3">
                                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">No image selected</p>
                                                </div>
                                            @endif
                                            <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary">
                                                <i class="fas fa-folder-open me-2"></i>Select from Media Library
                                            </button>
                                        </div>
                                    @endif

                                    <!-- FilePond Upload -->
                                    @if($uploadMethod === 'filepond')
                                        <div wire:ignore>
                                            <x-filepond 
                                                wire:model="filepondUploads" 
                                                multiple="false"
                                                accept-file-types="['image/png', 'image/jpg', 'image/jpeg', 'image/gif']"
                                                max-file-size="10MB"
                                            />
                                        </div>
                                    @endif

                                    <!-- Alternative URL Input -->
                                    <div class="mt-3">
                                        <label for="featured_image" class="form-label">Or Image URL</label>
                                        <input type="url" wire:model="form.featured_image" 
                                               class="form-control @error('form.featured_image') is-invalid @enderror" 
                                               id="featured_image" placeholder="https://example.com/image.jpg">
                                        @error('form.featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Article Meta -->
                                <div class="mb-3">
                                    <label for="author_name" class="form-label">Author <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="form.author_name" 
                                           class="form-control @error('form.author_name') is-invalid @enderror" 
                                           id="author_name" placeholder="Author name">
                                    @error('form.author_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select wire:model="form.category_id" class="form-select @error('form.category_id') is-invalid @enderror" 
                                            id="category_id">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select wire:model="form.status" class="form-select @error('form.status') is-invalid @enderror" 
                                            id="status">
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                    @error('form.status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Publish Date</label>
                                    <input type="datetime-local" wire:model="form.published_at" 
                                           class="form-control @error('form.published_at') is-invalid @enderror" 
                                           id="published_at">
                                    @error('form.published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" wire:model="form.featured" 
                                           id="featured">
                                    <label class="form-check-label" for="featured">
                                        Featured Article
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ $isCreating ? 'Create Article' : 'Update Article' }}
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