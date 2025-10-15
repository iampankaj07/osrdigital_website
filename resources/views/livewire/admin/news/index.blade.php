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
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th wire:click="sortBy('title')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center space-x-1">
                                <span>Article</span>
                                @if($sortField === 'title')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th wire:click="sortBy('status')" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center justify-center space-x-1">
                                <span>Status</span>
                                @if($sortField === 'status')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('published_at')" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center justify-center space-x-1">
                                <span>Published</span>
                                @if($sortField === 'published_at')
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
                    @forelse($news as $article)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($article->featured_image_url)
                                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-newspaper text-gray-400 text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ Str::limit($article->title, 50) }}
                                        </div>
                                        @if($article->excerpt)
                                            <div class="text-sm text-gray-500 truncate">
                                                {{ Str::limit($article->excerpt, 60) }}
                                            </div>
                                        @endif
                                        @if($article->featured)
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-star mr-1"></i>
                                                    Featured
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($article->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $article->category->name }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">Uncategorized</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $article->author_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : ($article->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    @if($article->published_at)
                                        {{ $article->published_at->format('M j, Y') }}
                                    @else
                                        <span class="text-gray-400">Not set</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-1">
                                    <a href="{{ route('admin.news.edit', $article->id) }}"
                                       class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                       title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <button wire:click="toggleFeatured({{ $article->id }})"
                                            class="inline-flex items-center p-2 {{ $article->featured ? 'text-yellow-500 hover:text-yellow-600' : 'text-gray-400 hover:text-gray-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="{{ $article->featured ? 'Remove from Featured' : 'Mark as Featured' }}">
                                        <i class="fas fa-star text-sm"></i>
                                    </button>
                                    <button wire:click="delete({{ $article->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this article?')">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-newspaper text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">No articles found</h3>
                                    <p class="text-sm text-gray-500">
                                        @if($search || $statusFilter || $categoryFilter)
                                            No articles match your current filters.
                                        @else
                                            Create your first article to get started.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing {{ $news->firstItem() }} to {{ $news->lastItem() }} of {{ $news->total() }} results
                    </div>
                    <div>
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Media Selector Component -->
    @livewire('components.media-selector')
</div>
