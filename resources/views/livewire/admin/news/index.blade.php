<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">News Management</h1>
            <p class="text-muted small mb-0">Create and manage news articles</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add New Article
        </a>
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
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by title or content...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label for="statusFilter" class="small text-muted mb-1">Status</label>
                        <select wire:model.live="statusFilter" class="form-control form-control-sm">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
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


    <!-- Articles Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('title')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 35%;">
                                <span class="d-flex align-items-center">
                                    Title
                                    @if($sortField === 'title')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Category</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Author</th>
                            <th wire:click="sortBy('status')" class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="cursor: pointer; width: 10%;">
                                <span class="d-flex align-items-center justify-content-center">
                                    Status
                                    @if($sortField === 'status')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th wire:click="sortBy('published_at')" class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="cursor: pointer; width: 10%;">
                                <span class="d-flex align-items-center justify-content-center">
                                    Published
                                    @if($sortField === 'published_at')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $article)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <div class="d-flex align-items-start">
                                        @if($article->featured_image_url)
                                            <img src="{{ $article->featured_image_url }}"
                                                 class="rounded mr-3" style="width: 40px; height: 40px; object-fit: cover;"
                                                 alt="{{ $article->title }}">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center mr-3"
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-image text-muted small"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <div class="font-weight-medium text-dark">{{ Str::limit($article->title, 50) }}</div>
                                            @if($article->excerpt)
                                                <div class="text-muted small">{{ Str::limit($article->excerpt, 60) }}</div>
                                            @endif
                                            @if($article->featured)
                                                <span class="badge badge-warning badge-sm mt-1">Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    @if($article->category)
                                        <span class="badge badge-info badge-sm">{{ $article->category->name }}</span>
                                    @else
                                        <span class="text-muted small">Uncategorized</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">{{ $article->author_name }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="badge badge-{{ $article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'secondary') }} badge-sm">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if($article->published_at)
                                        <div class="text-muted small">{{ $article->published_at->format('M j, Y') }}</div>
                                    @else
                                        <span class="text-muted small">Not set</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.news.edit', $article->id) }}"
                                                class="btn btn-dark btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="toggleFeatured({{ $article->id }})" 
                                                class="btn btn-outline-{{ $article->featured ? 'warning' : 'secondary' }} btn-sm border-0" 
                                                title="{{ $article->featured ? 'Remove from Featured' : 'Mark as Featured' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <button wire:click="delete({{ $article->id }})" 
                                                class="btn btn-danger btn-sm border-0"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this article?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-newspaper fa-lg mb-2 opacity-50"></i>
                                        <p class="mb-1 small">No articles found</p>
                                        <small class="text-muted">
                                            @if($search || $statusFilter || $categoryFilter)
                                                No articles match your current filters.
                                            @else
                                                Click "Add New Article" to create your first one
                                            @endif
                                        </small>
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

    <!-- Media Selector Component -->
    @livewire('components.media-selector')
</div>
