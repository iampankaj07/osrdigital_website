<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">News</h1>
            <p class="text-muted small mb-0">Manage news articles and blog posts</p>
        </div>
        <button wire:click="create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add News Article
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by title, excerpt, or author...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label for="statusFilter" class="small text-muted mb-1">Status</label>
                        <select wire:model.live="statusFilter" class="form-control form-control-sm">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
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
                    Create New News Article
                </h5>
                
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="form.title">Article Title</label>
                                <input type="text" wire:model="form.title" class="form-control" placeholder="Enter article title">
                                @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.slug">Slug</label>
                                <input type="text" wire:model="form.slug" class="form-control" placeholder="Auto-generated from title">
                                @error('form.slug') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.author_name">Author Name</label>
                                <input type="text" wire:model="form.author_name" class="form-control" placeholder="Enter author name">
                                @error('form.author_name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
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
                                <label for="form.status">Status</label>
                                <select wire:model="form.status" class="form-control">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                                @error('form.status') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.featured_image">Featured Image URL</label>
                                <input type="text" wire:model="form.featured_image" class="form-control" placeholder="Enter featured image URL">
                                @error('form.featured_image') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.published_at">Published At</label>
                                <input type="datetime-local" wire:model="form.published_at" class="form-control">
                                @error('form.published_at') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" wire:model="form.featured" class="form-check-input">
                                    Featured
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.excerpt">Excerpt</label>
                                <textarea wire:model="form.excerpt" class="form-control" rows="3" placeholder="Enter article excerpt"></textarea>
                                @error('form.excerpt') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.content">Content</label>
                                <textarea wire:model="form.content" class="form-control" rows="6" placeholder="Enter article content"></textarea>
                                @error('form.content') <span class="text-danger small">{{ $message }}</span> @enderror
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
                            Create Article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- News Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('published_at')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 15%;">
                                <span class="d-flex align-items-center">
                                    Date
                                    @if($sortField === 'published_at')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th wire:click="sortBy('title')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 35%;">
                                <span class="d-flex align-items-center">
                                    Article
                                    @if($sortField === 'title')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Author</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Category</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Status</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $article)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <div class="small text-muted">
                                        @if($article->published_at)
                                            {{ $article->published_at->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="d-flex align-items-start">
                                        @if($article->featured_image)
                                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="rounded mr-2" style="width: 40px; height: 30px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded mr-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 30px;">
                                                <i class="fas fa-newspaper text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-medium text-dark">{{ Str::limit($article->title, 50) }}</div>
                                            @if($article->excerpt)
                                                <div class="text-muted small">{{ Str::limit($article->excerpt, 60) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">{{ $article->author_name }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    @if($article->category)
                                        <span class="badge badge-info badge-sm">{{ $article->category->name }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        @if($article->featured)
                                            <span class="badge badge-warning badge-sm mb-1">Featured</span>
                                        @endif
                                        <span class="badge badge-{{ $article->status === 'published' ? 'success' : 'light' }} badge-sm">
                                            {{ ucfirst($article->status) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $article->id }})" 
                                                class="btn btn-outline-primary btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="toggleFeatured({{ $article->id }})" 
                                                class="btn btn-outline-{{ $article->featured ? 'warning' : 'secondary' }} btn-sm border-0" 
                                                title="{{ $article->featured ? 'Remove Featured' : 'Make Featured' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <button wire:click="toggleStatus({{ $article->id }})" 
                                                class="btn btn-outline-{{ $article->status === 'published' ? 'success' : 'info' }} btn-sm border-0" 
                                                title="{{ $article->status === 'published' ? 'Unpublish' : 'Publish' }}">
                                            <i class="fas fa-{{ $article->status === 'published' ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button wire:click="delete({{ $article->id }})" 
                                                class="btn btn-outline-danger btn-sm border-0"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this article?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId === $article->id)
                                <tr class="bg-light">
                                    <td colspan="6">
                                        <div class="p-3 inline-edit-form">
                                            <h5 class="mb-3">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit News Article
                                            </h5>
                                            
                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="form.title">Article Title</label>
                                                            <input type="text" wire:model="form.title" class="form-control">
                                                            @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="form.slug">Slug</label>
                                                            <input type="text" wire:model="form.slug" class="form-control">
                                                            @error('form.slug') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.author_name">Author Name</label>
                                                            <input type="text" wire:model="form.author_name" class="form-control">
                                                            @error('form.author_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
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
                                                            <label for="form.status">Status</label>
                                                            <select wire:model="form.status" class="form-control">
                                                                <option value="draft">Draft</option>
                                                                <option value="published">Published</option>
                                                            </select>
                                                            @error('form.status') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.featured_image">Featured Image URL</label>
                                                            <input type="text" wire:model="form.featured_image" class="form-control">
                                                            @error('form.featured_image') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.published_at">Published At</label>
                                                            <input type="datetime-local" wire:model="form.published_at" class="form-control">
                                                            @error('form.published_at') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" wire:model="form.featured" class="form-check-input">
                                                                Featured
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.excerpt">Excerpt</label>
                                                            <textarea wire:model="form.excerpt" class="form-control" rows="3"></textarea>
                                                            @error('form.excerpt') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.content">Content</label>
                                                            <textarea wire:model="form.content" class="form-control" rows="6"></textarea>
                                                            @error('form.content') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group text-right">
                                                    <button type="button" wire:click="cancelEdit" class="btn btn-secondary mr-2">
                                                        <i class="fas fa-times mr-1"></i>
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
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
                                        <i class="fas fa-newspaper fa-lg mb-2 opacity-50"></i>
                                        <p class="mb-1 small">No news articles found</p>
                                        <small class="text-muted">Click "Add News Article" to create your first one</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($news->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top bg-light">
                    <div class="text-muted small">
                        {{ $news->firstItem() }}-{{ $news->lastItem() }} of {{ $news->total() }}
                    </div>
                    <div>
                        {{ $news->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
