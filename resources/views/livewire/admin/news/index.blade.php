<div>
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
        width: 800px;
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

    /* Quill Editor Styles in Slide Panel */
    #quill-editor-slide,
    #quill-editor-slide * {
        position: relative !important;
        z-index: 2 !important;
    }

    .quill-container-slide {
        position: relative;
        z-index: 1;
    }

    #quill-editor-slide {
        position: relative !important;
        z-index: 2 !important;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    .slide-panel-backdrop.fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }

    .slide-panel.slide-out-right {
        animation: slideOutRight 0.3s ease-out forwards;
    }

    @media (max-width: 768px) {
        .slide-panel {
            width: 100vw;
            max-width: 100vw;
        }
    }
</style>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">News Management</h1>
            <p class="text-muted small mb-0">Create and manage news articles</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add New Article
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
                                    <button wire:click="edit({{ $article->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button wire:click="toggleFeatured({{ $article->id }})"
                                            class="inline-flex items-center p-2 {{ $article->featured ? 'text-yellow-500 hover:text-yellow-600' : 'text-gray-400 hover:text-gray-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="{{ $article->featured ? 'Remove from Featured' : 'Mark as Featured' }}">
                                        <i class="fas fa-star text-sm"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $article->id }}, 'news article')"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                            title="Delete">
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
                        <i class="fas fa-plus mr-2"></i>Create New Article
                    @else
                        <i class="fas fa-edit mr-2"></i>Edit Article
                    @endif
                </h5>
                <button type="button" wire:click="closeSlidePanel" class="btn btn-sm btn-link text-muted p-0" style="font-size: 1.5rem; line-height: 1;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="slide-panel-body">
                <form wire:submit="{{ $isCreating ? 'store' : 'update' }}">
                    <div class="form-group mb-3">
                        <label class="form-label">Article Title <span class="text-danger">*</span></label>
                        <input type="text" wire:model="form.title" class="form-control @error('form.title') is-invalid @enderror" placeholder="Enter article title">
                        @error('form.title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">URL Slug <span class="text-danger">*</span></label>
                        <input type="text" wire:model="form.slug" class="form-control @error('form.slug') is-invalid @enderror" placeholder="article-slug">
                        @error('form.slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Article Excerpt</label>
                        <textarea wire:model="form.excerpt" class="form-control @error('form.excerpt') is-invalid @enderror" rows="3" placeholder="Write a brief description..."></textarea>
                        @error('form.excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Content Editor -->
                    <div class="form-group mb-3">
                        <label class="form-label">Article Content <span class="text-danger">*</span></label>
                        <div class="border rounded bg-white quill-container-slide" style="min-height: 300px; position: relative; z-index: 1;" wire:ignore>
                            <div id="quill-editor-slide" class="quill-editor-slide" style="height: 300px; min-height: 300px; background: white; position: relative; z-index: 2;"></div>
                        </div>
                        <textarea wire:model.defer="form.content" id="quill-textarea-slide" style="display: none;"></textarea>
                        @error('form.content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Author <span class="text-danger">*</span></label>
                                <input type="text" wire:model="form.author_name" class="form-control @error('form.author_name') is-invalid @enderror" placeholder="Author name">
                                @error('form.author_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Category</label>
                                <select wire:model="form.category_id" class="form-control @error('form.category_id') is-invalid @enderror">
                                    <option value="">Select a category</option>
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
                                <label class="form-label">Publication Status <span class="text-danger">*</span></label>
                                <select wire:model="form.status" class="form-control @error('form.status') is-invalid @enderror">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                                @error('form.status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Publish Date & Time</label>
                                <input type="datetime-local" wire:model="form.published_at" class="form-control @error('form.published_at') is-invalid @enderror">
                                @error('form.published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Article Tags</label>
                        <input type="text" wire:model="form.tags" class="form-control @error('form.tags') is-invalid @enderror" placeholder="technology, news, updates (separate with commas)">
                        <small class="text-muted">Separate multiple tags with commas</small>
                        @error('form.tags') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Featured Image Upload -->
                    <div class="form-group mb-3">
                        <label class="form-label">Featured Image</label>
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
                                        <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-images mr-1"></i>Select Image
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model="form.featured" id="featured_slide">
                        <label class="form-check-label" for="featured_slide">
                            <i class="fas fa-star mr-1"></i>Featured Article
                        </label>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between pt-3 border-top mt-4">
                        <button type="button" wire:click="closeSlidePanel" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>{{ $isCreating ? 'Create' : 'Update' }} Article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @script
    <script>
        let quillSlide = null;
        let pendingContent = null;

        function initializeQuillEditorSlide() {
            const editorElement = document.getElementById('quill-editor-slide');
            if (!editorElement || typeof Quill === 'undefined') {
                return;
            }

            // If already initialized, just update content if needed
            if (quillSlide && quillSlide.container) {
                if (pendingContent) {
                    quillSlide.root.innerHTML = pendingContent;
                    document.getElementById('quill-textarea-slide').value = pendingContent;
                    @this.set('form.content', pendingContent);
                    pendingContent = null;
                }
                return;
            }

            try {
                quillSlide = new Quill('#quill-editor-slide', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'color': [] }, { 'background': [] }],
                            ['link', 'image'],
                            ['clean']
                        ]
                    }
                });

                quillSlide.on('text-change', function() {
                    const html = quillSlide.root.innerHTML;
                    document.getElementById('quill-textarea-slide').value = html;
                    @this.set('form.content', html);
                });

                // Populate editor if there's pending content
                if (pendingContent) {
                    quillSlide.root.innerHTML = pendingContent;
                    document.getElementById('quill-textarea-slide').value = pendingContent;
                    @this.set('form.content', pendingContent);
                    pendingContent = null;
                } else {
                    // Check form content from Livewire
                    const formContent = @this.get('form.content');
                    if (formContent && formContent.trim() !== '' && formContent.trim() !== '<p><br></p>') {
                        quillSlide.root.innerHTML = formContent;
                        document.getElementById('quill-textarea-slide').value = formContent;
                    }
                }

                // Reset editor when form is reset
                $wire.on('formReset', () => {
                    if (quillSlide) {
                        quillSlide.setContents([]);
                        document.getElementById('quill-textarea-slide').value = '';
                        pendingContent = null;
                    }
                });
            } catch (error) {
                console.error('Error initializing Quill editor:', error);
            }
        }

        // Populate editor when editing
        $wire.on('editFormPopulated', (data) => {
            const content = data && data.content ? data.content : null;
            if (content) {
                if (quillSlide && quillSlide.container) {
                    // Editor is ready, populate immediately
                    quillSlide.root.innerHTML = content;
                    document.getElementById('quill-textarea-slide').value = content;
                    @this.set('form.content', content);
                } else {
                    // Editor not ready yet, store content for later
                    pendingContent = content;
                    // Try to initialize
                    setTimeout(() => {
                        initializeQuillEditorSlide();
                    }, 50);
                }
            }
        });

        $wire.on('close-panel-animation', () => {
            setTimeout(() => {
                $wire.finishClosing();
            }, 300);
        });

        Livewire.hook('morph.updated', ({ el, component }) => {
            const panel = el.querySelector('.slide-panel.slide-out-right');
            if (panel && !panel.dataset.closingHandled) {
                panel.dataset.closingHandled = 'true';
                setTimeout(() => {
                    $wire.finishClosing();
                }, 300);
            }

            // Check if form.content has been updated and populate editor
            if (quillSlide && quillSlide.container) {
                const formContent = @this.get('form.content');
                if (formContent) {
                    const currentContent = quillSlide.root.innerHTML;
                    // Only update if content is different and not empty
                    if (formContent !== currentContent && formContent.trim() !== '<p><br></p>' && formContent.trim() !== '') {
                        quillSlide.root.innerHTML = formContent;
                        document.getElementById('quill-textarea-slide').value = formContent;
                    }
                }
            }
        });

        // Initialize Quill when slide panel opens
        $wire.on('slidePanelOpened', () => {
            setTimeout(() => {
                initializeQuillEditorSlide();
            }, 200);
        });

        // Watch for slide panel visibility
        const observer = new MutationObserver(() => {
            const panel = document.querySelector('.slide-panel:not(.slide-out-right)');
            if (panel && panel.querySelector('#quill-editor-slide')) {
                setTimeout(() => {
                    initializeQuillEditorSlide();
                }, 200);
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>
    @endscript

    @include('livewire.admin.partials.delete-confirm')
</div>
