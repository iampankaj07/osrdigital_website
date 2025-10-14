<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Edit News Article</h1>
            <p class="text-muted small mb-0">Edit and update news article</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-dark btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Back to News
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

    <!-- Edit Article Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form wire:submit="update">
                <div class="row">
                    <!-- Left Column - Main Content -->
                    <div class="col-lg-8">
                        <!-- Title and Slug Row -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title_edit">Article Title <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.live="form.title"
                                           id="title_edit"
                                           name="title"
                                           class="form-control  @error('form.title') is-invalid @enderror"
                                           placeholder="Enter a compelling article title">
                                    @error('form.title')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="slug_edit">URL Slug <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="form.slug"
                                           id="slug_edit"
                                           name="slug"
                                           class="form-control @error('form.slug') is-invalid @enderror"
                                           placeholder="article-slug" disabled readonly>
                                    @error('form.slug')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Excerpt -->
                        <div class="form-group mb-3">
                            <label for="excerpt_edit">Article Excerpt</label>
                            <textarea wire:model="form.excerpt"
                                      id="excerpt_edit"
                                      name="excerpt"
                                      class="form-control @error('form.excerpt') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Write a brief description of the article..."></textarea>
                            @error('form.excerpt')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Content Editor -->
                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="mb-0">Article Content <span class="text-danger">*</span></label>
                            </div>
                            <div class="border rounded bg-white quill-container" style="min-height: 400px; position: relative; z-index: 1;">
                                <div id="quill-editor-edit" class="quill-editor" style="height: 400px; min-height: 400px; background: white; position: relative; z-index: 2;"></div>
                            </div>
                            <textarea wire:model.defer="form.content" id="quill-textarea-edit" style="display: none;"></textarea>
                            @error('form.content')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="form-group mb-3">
                            <label for="tags_edit">Article Tags</label>
                            <input type="text" wire:model="form.tags"
                                   id="tags_edit"
                                   name="tags"
                                   class="form-control @error('form.tags') is-invalid @enderror"
                                   placeholder="technology, news, updates (separate with commas)">
                            <small class="text-muted">Separate multiple tags with commas</small>
                            @error('form.tags')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column - Media & Settings -->
                    <div class="col-lg-4">
                        <!-- Featured Image Card -->
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="mb-3"><i class="fas fa-image mr-2"></i>Featured Image</h6>

                                <!-- Upload Method Selection -->
                                <div class="form-group mb-3">
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <input type="radio" class="btn-check" wire:model="uploadMethod" value="media_library" id="media_library_edit" name="upload_method_edit">
                                        <label class="btn btn-outline-secondary" for="media_library_edit">
                                            <i class="fas fa-folder mr-1"></i>Library
                                        </label>

                                        <input type="radio" class="btn-check" wire:model="uploadMethod" value="filepond" id="filepond_edit" name="upload_method_edit">
                                        <label class="btn btn-outline-secondary" for="filepond_edit">
                                            <i class="fas fa-upload mr-1"></i>Upload
                                        </label>
                                    </div>
                                </div>

                                @if($uploadMethod === 'media_library')
                                    <div class="border rounded p-3 text-center bg-light">
                                        @if($selectedMediaUrl)
                                            <div class="mb-3">
                                                <img src="{{ $selectedMediaUrl }}" class="img-fluid rounded shadow-sm" style="max-height: 120px; width: 100%; object-fit: cover;">
                                            </div>
                                            <button type="button" wire:click="clearSelectedMedia" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash mr-1"></i>Remove
                                            </button>
                                        @else
                                            <div class="py-4">
                                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                <p class="text-muted small mb-3">No image selected</p>
                                            </div>
                                        @endif
                                        <button type="button" wire:click="openMediaSelector" class="btn btn-dark btn-sm">
                                            <i class="fas fa-folder-open mr-1"></i>Select from Library
                                        </button>
                                    </div>
                                @endif

                                @if($uploadMethod === 'filepond')
                                    <div class="border rounded p-2" style="min-height: 120px;">
                                        <x-filepond::upload
                                            wire:model="filepondUploads"
                                            multiple="false"
                                            accepted-file-types="image/*"
                                            max-file-size="10MB"
                                            placeholder="Drop image here or <span class='filepond--label-action'>Browse</span>"
                                        />
                                    </div>
                                @endif

                                <div class="form-group mt-3">
                                    <label for="featured_image_edit" class="small">Or enter image URL:</label>
                                    <input type="url" wire:model="form.featured_image"
                                           id="featured_image_edit"
                                           name="featured_image"
                                           class="form-control form-control-sm @error('form.featured_image') is-invalid @enderror"
                                           placeholder="https://example.com/image.jpg">
                                    @error('form.featured_image')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Article Settings Card -->
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="mb-3"><i class="fas fa-cog mr-2"></i>Article Settings</h6>

                                <!-- Author -->
                                <div class="form-group mb-3">
                                    <label for="author_name_edit">Author <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="form.author_name"
                                           id="author_name_edit"
                                           name="author_name"
                                           class="form-control @error('form.author_name') is-invalid @enderror"
                                           placeholder="Author name">
                                    @error('form.author_name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="form-group mb-3">
                                    <label for="category_id_edit">Category</label>
                                    <select wire:model="form.category_id"
                                            id="category_id_edit"
                                            name="category_id"
                                            class="form-control @error('form.category_id') is-invalid @enderror">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.category_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group mb-3">
                                    <label for="status_edit">Publication Status <span class="text-danger">*</span></label>
                                    <select wire:model="form.status"
                                            id="status_edit"
                                            name="status"
                                            class="form-control @error('form.status') is-invalid @enderror">
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                    @error('form.status')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Featured Checkbox -->
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="form.featured" id="featured_edit" name="featured">
                                        <label class="form-check-label" for="featured_edit">
                                            <i class="fas fa-star mr-1"></i>Featured Article
                                        </label>
                                    </div>
                                </div>

                                <!-- Publish Date -->
                                <div class="form-group mb-3">
                                    <label for="published_at_edit">Publish Date & Time</label>
                                    <input type="datetime-local" wire:model="form.published_at"
                                           id="published_at_edit"
                                           name="published_at"
                                           class="form-control @error('form.published_at') is-invalid @enderror">
                                    @error('form.published_at')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back to News
                    </a>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="window.location.reload()">
                            <i class="fas fa-undo mr-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-save mr-1"></i>Update Article
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Media Selector Component -->
    @livewire('components.media-selector')

    <script>
    document.addEventListener('livewire:initialized', function() {
        console.log('News Edit - Livewire initialized');

        // Handle media selection events
        window.addEventListener('mediaSelected', function(event) {
            @this.call('handleMediaSelection', event.detail);
        });

        // Initialize Quill editor
        let quillEdit = null;

        function initializeQuillEditor() {
            // Destroy existing editor if it exists
            if (quillEdit) {
                try {
                    quillEdit = null;
                } catch (e) {
                    console.log('Error destroying existing editor:', e);
                }
            }

            // Wait for DOM to be ready and Quill to be available
            function tryInitialize() {
                const editorElement = document.getElementById('quill-editor-edit');
                if (editorElement && typeof Quill !== 'undefined' && !quillEdit) {
                    console.log('Initializing Quill editor for edit page');

                    try {
                        quillEdit = new Quill('#quill-editor-edit', {
                            theme: 'snow',
                            placeholder: 'Start writing your article content here...',
                            modules: {
                                toolbar: [
                                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ 'color': [] }, { 'background': [] }],
                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                                    [{ 'align': [] }],
                                    ['link', 'image', 'video'],
                                    ['blockquote', 'code-block'],
                                    ['clean']
                                ]
                            }
                        });

                        // Force visibility and prevent hiding
                        function ensureEditorVisible() {
                            const container = quillEdit.container;
                            const editor = document.getElementById('quill-editor-edit');

                            if (container) {
                                container.style.display = 'block';
                                container.style.visibility = 'visible';
                                container.style.opacity = '1';
                                container.style.position = 'relative';
                                container.style.zIndex = '2';
                            }

                            if (editor) {
                                editor.style.display = 'block';
                                editor.style.visibility = 'visible';
                                editor.style.opacity = '1';
                                editor.style.position = 'relative';
                                editor.style.zIndex = '2';
                            }

                            console.log('Editor visibility ensured');
                        }

                        ensureEditorVisible();

                        // Periodically ensure editor stays visible
                        setInterval(ensureEditorVisible, 2000);

                        // Watch for any DOM changes that might hide the editor
                        const observer = new MutationObserver(function(mutations) {
                            mutations.forEach(function(mutation) {
                                if (mutation.type === 'attributes' || mutation.type === 'childList') {
                                    const editor = document.getElementById('quill-editor-edit');
                                    if (editor) {
                                        const computedStyle = window.getComputedStyle(editor);
                                        if (computedStyle.display === 'none' ||
                                            computedStyle.visibility === 'hidden' ||
                                            computedStyle.opacity === '0') {
                                            console.log('Editor visibility compromised, restoring...');
                                            ensureEditorVisible();
                                        }
                                    }
                                }
                            });
                        });

                        // Start observing
                        const editorElement = document.getElementById('quill-editor-edit');
                        if (editorElement) {
                            observer.observe(editorElement, {
                                attributes: true,
                                childList: true,
                                subtree: true,
                                attributeFilter: ['style', 'class']
                            });

                            // Also observe the parent container
                            const container = editorElement.parentElement;
                            if (container) {
                                observer.observe(container, {
                                    attributes: true,
                                    childList: true,
                                    attributeFilter: ['style', 'class']
                                });
                            }
                        }

                        // Load existing content from Livewire - with multiple attempts
                        function loadExistingContent() {
                            const existingContent = @this.get('form.content');
                            console.log('Attempting to load content:', existingContent);

                            if (existingContent && existingContent.trim() !== '' && existingContent !== '<p><br></p>') {
                                // Use Quill's clipboard to properly set HTML content
                                const clipboard = quillEdit.clipboard;
                                const delta = clipboard.convert(existingContent);
                                quillEdit.setContents(delta, 'silent');
                                console.log('Content loaded successfully via clipboard conversion');
                            } else {
                                // Try direct HTML injection as fallback
                                setTimeout(() => {
                                    const content = @this.get('form.content');
                                    if (content && content.trim() !== '' && content !== '<p><br></p>') {
                                        quillEdit.root.innerHTML = content;
                                        console.log('Content loaded via direct HTML injection');
                                    }
                                }, 100);
                            }
                        }

                        // Load content initially
                        loadExistingContent();

                        // Also try loading after a short delay to ensure component is fully initialized
                        setTimeout(loadExistingContent, 500);
                        setTimeout(loadExistingContent, 1000);

                        // Sync editor with Livewire - with debouncing to prevent excessive updates
                        let updateTimeout = null;
                        quillEdit.on('text-change', function(delta, oldDelta, source) {
                            // Only sync if change came from user interaction, not programmatic
                            if (source === 'user') {
                                const html = quillEdit.root.innerHTML;
                                document.getElementById('quill-textarea-edit').value = html;

                                // Debounce Livewire updates to prevent interference
                                clearTimeout(updateTimeout);
                                updateTimeout = setTimeout(() => {
                                    @this.set('form.content', html, false); // false = don't re-render component
                                }, 300);
                            }
                        });

                        // Prevent editor from losing focus on Livewire updates
                        quillEdit.on('selection-change', function(range, oldRange, source) {
                            if (range) {
                                // Store cursor position
                                window.quillCursorPosition = range;
                            }
                        });

                        console.log('Quill editor initialized successfully');
                    } catch (error) {
                        console.error('Error initializing Quill editor:', error);
                        // Retry after a short delay
                        setTimeout(tryInitialize, 100);
                    }
                } else if (editorElement && typeof Quill !== 'undefined' && quillEdit) {
                    console.log('Quill editor already initialized');
                } else if (!editorElement) {
                    console.log('Editor element not found, retrying...');
                    setTimeout(tryInitialize, 100);
                } else if (typeof Quill === 'undefined') {
                    console.log('Quill not loaded yet, retrying...');
                    setTimeout(tryInitialize, 100);
                }
            }

            // Start trying to initialize
            setTimeout(tryInitialize, 100);
        }

        // Initialize editor when component loads
        initializeQuillEditor();

        // Fallback initialization after a longer delay
        setTimeout(function() {
            if (!quillEdit) {
                console.log('Fallback initialization triggered');
                initializeQuillEditor();
            } else {
                // If editor exists but no content, try to load content again
                const currentContent = quillEdit.getText().trim();
                if (currentContent === '' || currentContent === '\n') {
                    console.log('Editor exists but empty, attempting to reload content');
                    @this.call('refreshContent');
                }
            }
        }, 2000);

        // Add manual content refresh function to window for debugging
        window.refreshQuillContent = function() {
            console.log('Manual content refresh triggered');

            if (quillEdit) {
                // Ensure editor is visible
                const container = quillEdit.container;
                const editor = document.getElementById('quill-editor-edit');

                if (container) {
                    container.style.display = 'block';
                    container.style.visibility = 'visible';
                    container.style.opacity = '1';
                }

                if (editor) {
                    editor.style.display = 'block';
                    editor.style.visibility = 'visible';
                    editor.style.opacity = '1';
                }

                console.log('Editor visibility restored');
            } else {
                console.log('Editor not found, reinitializing...');
                initializeQuillEditor();
            }

            @this.call('refreshContent');
        };

        // Handle Livewire updates without reinitializing editor
        Livewire.on('$refresh', function() {
            console.log('Livewire refresh detected');
            // Don't reinitialize editor, just ensure it's still visible
            if (quillEdit) {
                setTimeout(() => {
                    // Restore focus if we had a cursor position
                    if (window.quillCursorPosition) {
                        quillEdit.setSelection(window.quillCursorPosition);
                    }

                    // Ensure editor is visible
                    const editorContainer = document.getElementById('quill-editor-edit');
                    if (editorContainer) {
                        editorContainer.style.display = 'block';
                        editorContainer.style.visibility = 'visible';
                        editorContainer.style.opacity = '1';
                        editorContainer.style.zIndex = '1';
                    }
                }, 100);
            } else {
                // Only reinitialize if editor doesn't exist
                setTimeout(initializeQuillEditor, 500);
            }
        });

        // Handle form population
        Livewire.on('editFormPopulated', function(data) {
            console.log('Form populated with data:', data);

            function setQuillContent() {
                if (quillEdit && data.content && data.content.trim() !== '') {
                    try {
                        // Method 1: Try using Quill's clipboard for proper HTML parsing
                        const clipboard = quillEdit.clipboard;
                        const delta = clipboard.convert(data.content);
                        quillEdit.setContents(delta, 'silent');
                        console.log('Content set via clipboard conversion:', data.content.substring(0, 100) + '...');
                    } catch (e) {
                        console.log('Clipboard method failed, using direct HTML:', e);
                        // Method 2: Fallback to direct HTML injection
                        quillEdit.root.innerHTML = data.content;
                        console.log('Content set via direct HTML:', data.content.substring(0, 100) + '...');
                    }
                } else {
                    console.log('No valid content to set or editor not ready');
                }
            }

            // Try immediately
            setQuillContent();

            // Also try after short delays in case editor needs time to be ready
            setTimeout(setQuillContent, 100);
            setTimeout(setQuillContent, 500);
        });

        // Handle form reset
        Livewire.on('formReset', function() {
            if (quillEdit) {
                quillEdit.setContents([]);
            }
        });
    });
    </script>

    <style>
    /* High priority Quill editor styles to prevent hiding */
    #quill-editor-edit,
    #quill-editor-edit * {
        box-sizing: border-box !important;
    }

    .quill-container {
        position: relative !important;
        z-index: 1 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    #quill-editor-edit {
        position: relative !important;
        z-index: 2 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: 400px !important;
        min-height: 400px !important;
        background: white !important;
    }

    #quill-editor-edit .ql-container {
        position: relative !important;
        z-index: 2 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        background: white !important;
        min-height: 350px !important;
        height: calc(100% - 42px) !important;
    }

    #quill-editor-edit .ql-editor {
        position: relative !important;
        z-index: 2 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        min-height: 350px !important;
        height: 100% !important;
        padding: 12px 15px !important;
        color: #495057 !important;
        line-height: 1.6 !important;
        font-family: inherit !important;
        font-size: 14px !important;
        background: white !important;
        border: none !important;
    }

    #quill-editor-edit .ql-toolbar {
        position: relative !important;
        z-index: 3 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        background: #f8f9fa !important;
        border-bottom: 1px solid #dee2e6 !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
    }

    #quill-editor-edit .ql-editor:focus {
        outline: none !important;
        box-shadow: inset 0 0 0 1px #007bff !important;
    }

    /* Prevent any hiding classes from affecting the editor */
    #quill-editor-edit .ql-editor.hide,
    #quill-editor-edit .ql-container.hide,
    #quill-editor-edit.hide {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Prevent Livewire from interfering with Quill */
    #quill-editor-edit [wire\:loading] {
        display: none !important;
    }

    #quill-editor-edit .ql-editor p {
        margin-bottom: 1em !important;
    }

    #quill-editor-edit .ql-editor:empty::before {
        font-style: italic !important;
        color: #adb5bd !important;
        content: "Start writing your article content here..." !important;
    }

    /* Override any global styles that might hide the editor */
    div[wire\:loading] #quill-editor-edit,
    div[wire\:loading] #quill-editor-edit * {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Ensure proper stacking order */
    .form-group:has(#quill-editor-edit) {
        position: relative !important;
        z-index: 1 !important;
    }
    </style>
</div>
