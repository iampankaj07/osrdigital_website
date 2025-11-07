<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Legal Pages Management</h1>
            <p class="text-muted small mb-0">Manage Privacy Policy, Terms of Service, and Cookies Policy</p>
        </div>
        @if($editingId)
            <button wire:click="preview" class="btn btn-primary btn-sm" target="_blank">
                <i class="fas fa-external-link-alt mr-1"></i>Preview Page
            </button>
        @endif
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

    @if (session()->has('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Page Type Selector -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label for="pageType" class="form-label mb-2">Select Legal Page to Edit</label>
                    <select wire:model.live="selectedPageType" id="pageType" class="form-control">
                        @foreach($pageTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center h-100">
                        @if($selectedPageType && $pages->has($selectedPageType))
                            <div class="ms-3">
                                <span class="badge badge-{{ $pages[$selectedPageType]->is_published ? 'success' : 'warning' }}">
                                    {{ $pages[$selectedPageType]->is_published ? 'Published' : 'Draft' }}
                                </span>
                                @if($pages[$selectedPageType]->last_updated_at)
                                    <small class="text-muted d-block mt-1">
                                        Last updated: {{ $pages[$selectedPageType]->last_updated_at->format('M j, Y g:i A') }}
                                    </small>
                                @endif
                            </div>
                        @else
                            <div class="ms-3">
                                <span class="badge badge-secondary">New Page</span>
                                <small class="text-muted d-block mt-1">This page hasn't been created yet</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <form wire:submit="save">
        <div class="row">
            <!-- Left Column - Main Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <!-- Title and Slug -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Page Title <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.defer="form.title"
                                           id="title"
                                           class="form-control @error('form.title') is-invalid @enderror"
                                           placeholder="Enter page title">
                                    @error('form.title')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slug">URL Slug <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.defer="form.slug"
                                           id="slug"
                                           class="form-control @error('form.slug') is-invalid @enderror"
                                           placeholder="page-slug">
                                    @error('form.slug')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Excerpt -->
                        <div class="form-group mb-3">
                            <label for="excerpt">Page Excerpt</label>
                            <textarea wire:model.defer="form.excerpt"
                                      id="excerpt"
                                      class="form-control @error('form.excerpt') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Brief description of this page..."></textarea>
                            @error('form.excerpt')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Content Editor -->
                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="mb-0">Page Content <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.refreshQuillContentLegal && window.refreshQuillContentLegal()">
                                        <i class="fas fa-sync mr-1"></i>Refresh Editor
                                    </button>

                                </div>
                            </div>
                            <div class="border rounded bg-white quill-container-legal" style="min-height: 400px; position: relative; z-index: 1;" wire:ignore>
                                <div id="quill-editor-legal" class="quill-editor-legal" style="height: 400px; min-height: 400px; background: white; position: relative; z-index: 2;"></div>
                            </div>
                            <textarea wire:model.defer="form.content" id="quill-textarea-legal" style="display: none;"></textarea>
                            @error('form.content')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - SEO & Settings -->
            <div class="col-lg-4">
                <!-- SEO Settings Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="fas fa-search mr-2"></i>SEO Settings</h6>

                        <!-- Meta Title -->
                        <div class="form-group mb-3">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" wire:model.defer="form.meta_title"
                                   id="meta_title"
                                   class="form-control @error('form.meta_title') is-invalid @enderror"
                                   placeholder="SEO page title">
                            @error('form.meta_title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="form-group mb-3">
                            <label for="meta_description">Meta Description</label>
                            <textarea wire:model.defer="form.meta_description"
                                      id="meta_description"
                                      class="form-control @error('form.meta_description') is-invalid @enderror"
                                      rows="3"
                                      placeholder="SEO description for search engines"></textarea>
                            @error('form.meta_description')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Publish Settings Card -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="mb-3"><i class="fas fa-cog mr-2"></i>Publish Settings</h6>

                        <!-- Published Checkbox -->
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model.defer="form.is_published" id="is_published">
                                <label class="form-check-label" for="is_published">
                                    <i class="fas fa-globe mr-1"></i>Published (visible to public)
                                </label>
                            </div>
                        </div>

                        @if($editingId && $selectedPageType && isset($pages[$selectedPageType]) && $pages[$selectedPageType]->updated_by)
                            <div class="small text-muted">
                                <i class="fas fa-user mr-1"></i>
                                Last updated by: {{ $pages[$selectedPageType]->updated_by }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <div class="text-muted small">
                <i class="fas fa-info-circle mr-1"></i>
                Changes will be visible on the website once saved and published
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()">
                    <i class="fas fa-undo mr-1"></i>Reset Changes
                </button>
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save mr-1"></i>
                    {{ $editingId ? 'Update' : 'Create' }} Page
                </button>
            </div>
        </div>
    </form>

    <script>
    document.addEventListener('livewire:initialized', function() {
        console.log('Legal Pages - Livewire initialized');

        // Initialize Quill editor
        let quillLegal = null;
        let isInitializingLegal = false;

        function initializeQuillEditor() {
            // Prevent multiple simultaneous initializations
            if (isInitializingLegal) {
                console.log('Legal editor initialization already in progress');
                return;
            }

            // Don't destroy existing editor if it's working
            if (quillLegal && quillLegal.container && document.getElementById('quill-editor-legal')) {
                console.log('Legal editor already exists and is working');
                return;
            }

            isInitializingLegal = true;

            // Wait for DOM to be ready and Quill to be available
            function tryInitialize() {
                const editorElement = document.getElementById('quill-editor-legal');
                if (editorElement && typeof Quill !== 'undefined') {
                    console.log('Initializing Quill editor for legal pages');

                    try {
                        quillLegal = new Quill('#quill-editor-legal', {
                            theme: 'snow',
                            placeholder: 'Start writing your legal page content here...',
                            modules: {
                                toolbar: [
                                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ 'color': [] }, { 'background': [] }],
                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                                    [{ 'align': [] }],
                                    ['link'],
                                    ['blockquote', 'code-block'],
                                    ['clean']
                                ]
                            }
                        });

                        // Force visibility and prevent hiding
                        function ensureEditorVisible() {
                            const container = quillLegal.container;
                            const editor = document.getElementById('quill-editor-legal');

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

                            console.log('Legal editor visibility ensured');
                        }

                        ensureEditorVisible();

                        // Periodically ensure editor stays visible
                        setInterval(ensureEditorVisible, 2000);

                        // Watch for any DOM changes that might hide the editor
                        const observer = new MutationObserver(function(mutations) {
                            mutations.forEach(function(mutation) {
                                if (mutation.type === 'attributes' || mutation.type === 'childList') {
                                    const editor = document.getElementById('quill-editor-legal');
                                    if (editor) {
                                        const computedStyle = window.getComputedStyle(editor);
                                        if (computedStyle.display === 'none' ||
                                            computedStyle.visibility === 'hidden' ||
                                            computedStyle.opacity === '0') {
                                            console.log('Legal editor visibility compromised, restoring...');
                                            ensureEditorVisible();
                                        }
                                    }
                                }
                            });
                        });

                        // Start observing
                        const editorElement = document.getElementById('quill-editor-legal');
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
                            console.log('Attempting to load legal content:', existingContent);

                            if (existingContent && existingContent.trim() !== '' && existingContent !== '<p><br></p>') {
                                // Use Quill's clipboard to properly set HTML content
                                try {
                                    const clipboard = quillLegal.clipboard;
                                    const delta = clipboard.convert(existingContent);
                                    quillLegal.setContents(delta, 'silent');
                                    console.log('Legal content loaded successfully via clipboard conversion');
                                } catch (e) {
                                    console.log('Legal clipboard method failed, using direct HTML:', e);
                                    quillLegal.root.innerHTML = existingContent;
                                    console.log('Legal content loaded via direct HTML injection');
                                }
                            }
                        }

                        // Load content initially
                        loadExistingContent();

                        // Also try loading after short delays
                        setTimeout(loadExistingContent, 500);
                        setTimeout(loadExistingContent, 1000);

                        // Sync editor with Livewire - with debouncing to prevent excessive updates
                        let updateTimeout = null;
                        quillLegal.on('text-change', function(delta, oldDelta, source) {
                            // Only sync if change came from user interaction, not programmatic
                            if (source === 'user') {
                                const html = quillLegal.root.innerHTML;
                                document.getElementById('quill-textarea-legal').value = html;

                                // Debounce Livewire updates to prevent interference
                                clearTimeout(updateTimeout);
                                updateTimeout = setTimeout(() => {
                                    @this.set('form.content', html, false); // false = don't re-render component
                                }, 300);
                            }
                        });

                        // Prevent editor from losing focus on Livewire updates
                        quillLegal.on('selection-change', function(range, oldRange, source) {
                            if (range) {
                                // Store cursor position
                                window.quillLegalCursorPosition = range;
                            }
                        });

                        console.log('Legal Quill editor initialized successfully');
                        isInitializingLegal = false;
                    } catch (error) {
                        console.error('Error initializing Legal Quill editor:', error);
                        isInitializingLegal = false;
                        // Retry after a short delay
                        setTimeout(tryInitialize, 100);
                    }
                } else if (editorElement && typeof Quill !== 'undefined' && quillLegal) {
                    console.log('Legal Quill editor already initialized');
                } else if (!editorElement) {
                    console.log('Legal editor element not found, retrying...');
                    setTimeout(tryInitialize, 100);
                } else if (typeof Quill === 'undefined') {
                    console.log('Quill not loaded yet for legal, retrying...');
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
            if (!quillLegal) {
                console.log('Legal fallback initialization triggered');
                initializeQuillEditor();
            } else {
                // If editor exists but ensure visibility
                const currentContent = quillLegal.getText().trim();
                console.log('Legal editor exists, ensuring visibility');
                const editorElement = document.getElementById('quill-editor-legal');
                if (editorElement) {
                    editorElement.style.display = 'block';
                    editorElement.style.visibility = 'visible';
                    editorElement.style.opacity = '1';
                }
            }
        }, 2000);

        // Add manual content refresh function to window for debugging
        window.refreshQuillContentLegal = function() {
            console.log('Manual legal content refresh triggered');

            if (quillLegal) {
                // Ensure editor is visible
                const container = quillLegal.container;
                const editor = document.getElementById('quill-editor-legal');

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

                console.log('Legal editor visibility restored');

                // Reload content
                const existingContent = @this.get('form.content');
                if (existingContent && existingContent.trim() !== '' && existingContent !== '<p><br></p>') {
                    quillLegal.root.innerHTML = existingContent;
                }
            } else {
                console.log('Legal editor not found, reinitializing...');
                initializeQuillEditor();
            }
        };

        // Handle specific legal page events to preserve editor
        Livewire.on('update', function() {
            console.log('Legal update event detected, preserving editor');
            // Don't reinitialize editor during updates
            if (quillLegal && quillLegal.container) {
                console.log('Legal editor preserved during update');
            }
        });

        Livewire.on('save', function() {
            console.log('Legal save event detected, preserving editor');
            // Don't reinitialize editor during save operations
            if (quillLegal && quillLegal.container) {
                console.log('Legal editor preserved during save');
            }
        });

        // Handle content loading when page type changes
        Livewire.on('legalPageContentLoaded', function(data) {
            console.log('Legal page content loaded:', data);

            function setQuillLegalContent() {
                if (quillLegal && data && data[0] && data[0].content) {
                    try {
                        // Method 1: Try using Quill's clipboard for proper HTML parsing
                        const clipboard = quillLegal.clipboard;
                        const delta = clipboard.convert(data[0].content);
                        quillLegal.setContents(delta, 'silent');
                        console.log('Legal content set via clipboard conversion');
                    } catch (e) {
                        console.log('Legal clipboard method failed, using direct HTML:', e);
                        // Method 2: Fallback to direct HTML injection
                        quillLegal.root.innerHTML = data[0].content;
                        console.log('Legal content set via direct HTML');
                    }
                } else {
                    console.log('No valid legal content to set or editor not ready');
                }
            }

            // Try immediately and with delays
            setQuillLegalContent();
            setTimeout(setQuillLegalContent, 100);
            setTimeout(setQuillLegalContent, 500);
        });

        // Handle Livewire updates without reinitializing editor
        Livewire.on('$refresh', function() {
            console.log('Legal Livewire refresh detected');
            // Don't reinitialize editor, just ensure it's still visible
            if (quillLegal && quillLegal.container) {
                setTimeout(() => {
                    // Restore focus if we had a cursor position
                    if (window.quillLegalCursorPosition) {
                        quillLegal.setSelection(window.quillLegalCursorPosition);
                    }

                    // Ensure editor is visible
                    const editorContainer = document.getElementById('quill-editor-legal');
                    if (editorContainer) {
                        editorContainer.style.display = 'block';
                        editorContainer.style.visibility = 'visible';
                        editorContainer.style.opacity = '1';
                        editorContainer.style.zIndex = '2';

                        // Ensure Quill container is also visible
                        if (quillLegal && quillLegal.container) {
                            quillLegal.container.style.display = 'block';
                            quillLegal.container.style.visibility = 'visible';
                            quillLegal.container.style.opacity = '1';
                            quillLegal.container.style.zIndex = '2';
                        }
                    }
                    console.log('Legal editor maintained after Livewire refresh');
                }, 100);
            } else {
                // Only reinitialize if editor doesn't exist
                console.log('Legal editor not found after refresh, reinitializing');
                setTimeout(initializeQuillEditor, 300);
            }
        });

        // Handle component updates specifically (triggered during page type changes and form updates)
        document.addEventListener('livewire:updated', function() {
            console.log('Legal Livewire updated event detected');
            setTimeout(() => {
                if (quillLegal) {
                    const editorContainer = document.getElementById('quill-editor-legal');
                    if (editorContainer) {
                        // Force visibility immediately
                        editorContainer.style.display = 'block';
                        editorContainer.style.visibility = 'visible';
                        editorContainer.style.opacity = '1';
                        editorContainer.style.zIndex = '2';

                        // Also ensure Quill container is visible
                        if (quillLegal.container) {
                            quillLegal.container.style.display = 'block';
                            quillLegal.container.style.visibility = 'visible';
                            quillLegal.container.style.opacity = '1';
                        }

                        console.log('Legal editor visibility restored after livewire:updated');
                    }
                } else {
                    console.log('Legal editor not found during livewire:updated, reinitializing');
                    initializeQuillEditor();
                }
            }, 50);
        });

        // Add additional protection for page type changes
        const pageTypeSelector = document.getElementById('pageType');
        if (pageTypeSelector) {
            pageTypeSelector.addEventListener('change', function() {
                console.log('Page type selector changed, protecting editor');
                setTimeout(() => {
                    if (quillLegal) {
                        const editorContainer = document.getElementById('quill-editor-legal');
                        if (editorContainer) {
                            editorContainer.style.display = 'block !important';
                            editorContainer.style.visibility = 'visible !important';
                            editorContainer.style.opacity = '1 !important';
                            editorContainer.style.zIndex = '2 !important';
                        }
                    }
                }, 100);
            });
        }
    });
    </script>

    <style>
    /* High priority Quill editor styles to prevent hiding - Legal Pages */
    #quill-editor-legal,
    #quill-editor-legal * {
        box-sizing: border-box !important;
    }

    .quill-container-legal {
        position: relative !important;
        z-index: 1 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    #quill-editor-legal {
        position: relative !important;
        z-index: 2 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: 400px !important;
        min-height: 400px !important;
        background: white !important;
    }

    #quill-editor-legal .ql-container {
        position: relative !important;
        z-index: 2 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        background: white !important;
        min-height: 350px !important;
        height: calc(100% - 42px) !important;
    }

    #quill-editor-legal .ql-editor {
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

    #quill-editor-legal .ql-toolbar {
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

    #quill-editor-legal .ql-editor:focus {
        outline: none !important;
        box-shadow: inset 0 0 0 1px #007bff !important;
    }

    /* Prevent any hiding classes from affecting the legal editor */
    #quill-editor-legal .ql-editor.hide,
    #quill-editor-legal .ql-container.hide,
    #quill-editor-legal.hide {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Prevent Livewire from interfering with Legal Quill */
    #quill-editor-legal [wire\:loading] {
        display: none !important;
    }

    #quill-editor-legal .ql-editor p {
        margin-bottom: 1em !important;
    }

    #quill-editor-legal .ql-editor:empty::before {
        font-style: italic !important;
        color: #adb5bd !important;
        content: "Start writing your legal page content here..." !important;
    }

    /* Override any global styles that might hide the legal editor */
    div[wire\:loading] #quill-editor-legal,
    div[wire\:loading] #quill-editor-legal * {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Ensure proper stacking order for legal */
    .form-group:has(#quill-editor-legal) {
        position: relative !important;
        z-index: 1 !important;
    }

    /* Extra protection during page updates and type changes */
    [wire\:loading] #quill-editor-legal,
    [wire\:loading] #quill-editor-legal *,
    [wire\:loading] .quill-container-legal {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Animation protection */
    #quill-editor-legal {
        transition: none !important;
        animation: none !important;
    }

    #quill-editor-legal .ql-container,
    #quill-editor-legal .ql-editor {
        transition: none !important;
        animation: none !important;
    }

    /* Force visibility during DOM updates */
    .quill-container-legal[style*="display: none"] #quill-editor-legal {
        display: block !important;
    }

    /* Override any external hiding styles */
    body #quill-editor-legal {
        display: block !important;
    }

    body .quill-container-legal {
        display: block !important;
    }
    </style>
</div>
