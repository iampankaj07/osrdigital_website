@extends('admin.layout')

@section('title', 'Media Library')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Media Library</h1>
            <p class="text-muted">Upload and manage your media files</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" onclick="openUploadModal()">
                <i class="fas fa-cloud-upload-alt"></i> Upload Files
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.media.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search media...">
                </div>
                <div class="col-md-2">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="images" {{ request('type') === 'images' ? 'selected' : '' }}>Images</option>
                        <option value="documents" {{ request('type') === 'documents' ? 'selected' : '' }}>Documents</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="user" class="form-label">Uploaded By</label>
                    <select class="form-select" id="user" name="user">
                        <option value="">All Users</option>
                        @foreach($users as $userId => $userName)
                            <option value="{{ $userId }}" {{ request('user') == $userId ? 'selected' : '' }}>
                                {{ $userName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Upload Dropzone -->
    <div class="card mb-4" id="dropzone-container" style="display: none;">
        <div class="card-body">
            <form action="{{ route('admin.media.store') }}" class="dropzone" id="media-dropzone">
                @csrf
                <div class="dz-message">
                    <div class="text-center">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h4>Drop files here or click to upload</h4>
                        <p class="text-muted">Supports images, documents, and other media files</p>
                        <p class="text-muted small">Maximum file size: 10MB</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Media Grid -->
    <div class="card">
        <div class="card-body p-0">
            @if($media->count() > 0)
                <!-- Grid Header with Select All -->
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom bg-light">
                    <div class="d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-3" id="selectAll" onchange="selectAll(this.checked)">
                        <label for="selectAll" class="form-check-label mb-0 fw-semibold">Select All</label>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2">{{ $media->total() }} items</span>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleView('grid')" id="gridViewBtn">
                                <i class="fas fa-th"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleView('list')" id="listViewBtn">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Media Grid -->
                <div class="p-4">
                    <div class="row g-4" id="media-grid">
                        @foreach($media as $item)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 media-item" data-id="{{ $item->id }}">
                                <div class="card h-100 shadow-sm border-0 media-card">
                                    <div class="position-relative">
                                        @if($item->isImage())
                                            <img src="{{ $item->thumbnail_url }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $item->alt_text ?: $item->name }}"
                                                 style="height: 200px; object-fit: cover; width: 100%;">
                                        @else
                                            <div class="card-img-top d-flex align-items-center justify-content-center bg-gradient" 
                                                 style="height: 200px; width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <i class="{{ $item->icon }} fa-4x text-white"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Selection checkbox -->
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <input type="checkbox" class="form-check-input media-select" 
                                                   value="{{ $item->id }}" style="background-color: white; transform: scale(1.2);">
                                        </div>
                                        
                                        <!-- Public/Private indicator -->
                                        <div class="position-absolute top-0 end-0 m-3">
                                            @if($item->is_public)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-globe me-1"></i>Public
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-lock me-1"></i>Private
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- File type indicator -->
                                        <div class="position-absolute bottom-0 end-0 m-3">
                                            <span class="badge bg-dark">
                                                {{ strtoupper($item->extension) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Hover overlay -->
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center overlay" 
                                             style="background: rgba(0,0,0,0.7); opacity: 0; transition: opacity 0.3s;">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-light" 
                                                        onclick="viewMedia({{ $item->id }})" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-light" 
                                                        onclick="editMedia({{ $item->id }})" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-light" 
                                                        onclick="deleteMedia({{ $item->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-truncate mb-2" title="{{ $item->name }}" style="font-size: 0.9rem; font-weight: 600;">
                                            {{ $item->name }}
                                        </h6>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-file me-1"></i>{{ $item->human_size }}
                                            </small>
                                            @if($item->isImage() && $item->width && $item->height)
                                                <small class="text-muted">
                                                    <i class="fas fa-expand me-1"></i>{{ $item->width }}×{{ $item->height }}
                                                </small>
                                            @endif
                                        </div>
                                        
                                        @if($item->category)
                                            <div class="mb-2">
                                                <span class="badge bg-secondary">{{ ucfirst($item->category) }}</span>
                                            </div>
                                        @endif
                                        
                                        <div class="text-muted small d-flex align-items-center">
                                            <i class="fas fa-user me-1"></i>
                                            <span class="text-truncate">{{ $item->uploader->name ?? 'Unknown' }}</span>
                                        </div>
                                        
                                        <div class="text-muted small">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $item->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0">
                            Showing {{ $media->firstItem() }} to {{ $media->lastItem() }} of {{ $media->total() }} results
                        </p>
                    </div>
                    <div>
                        {{ $media->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No media found</h4>
                    <p class="text-muted">Upload your first media file to get started.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-plus"></i> Upload Media
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Select Files</label>
                        <input type="file" class="form-control" id="file" name="file" multiple accept="image/*,application/pdf,.doc,.docx,.txt">
                        <div class="form-text">Maximum file size: 10MB. Supported formats: Images, PDF, Word, Excel, Text</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control" id="category" name="category" placeholder="e.g., logos, banners, documents">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_public" class="form-label">Visibility</label>
                                <select class="form-select" id="is_public" name="is_public">
                                    <option value="1">Public</option>
                                    <option value="0">Private</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="alt_text" name="alt_text" placeholder="Alternative text for accessibility">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Optional description"></textarea>
                    </div>
                </form>
                
                <!-- Upload Progress -->
                <div id="uploadProgress" class="d-none">
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="text-center">
                        <span id="uploadStatus">Uploading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="uploadMedia()">Upload</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_media_id">
                    
                    <div class="mb-3">
                        <label for="edit_alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="edit_alt_text" name="alt_text">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="edit_category" name="category">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_public" name="is_public" value="1">
                            <label class="form-check-label" for="edit_is_public">
                                Public (visible to everyone)
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateMedia()">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Actions -->
<div id="bulkActions" class="position-fixed bottom-0 end-0 p-3" style="display: none;">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <span class="me-3" id="selectedCount">0 selected</span>
                <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Dropzone.js CSS -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<style>
    /* Dropzone Styling */
    .dropzone {
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        background: #f8f9fa;
        min-height: 200px;
        padding: 2rem;
        transition: all 0.3s ease;
    }
    
    .dropzone:hover {
        border-color: #0d6efd;
        background: #e7f1ff;
    }
    
    .dropzone.dz-drag-hover {
        border-color: #0d6efd;
        background: #e7f1ff;
        transform: scale(1.02);
    }
    
    .dz-message {
        text-align: center;
        margin: 0;
    }
    
    .dz-preview {
        margin: 0.5rem;
    }
    
    .dz-preview .dz-image {
        border-radius: 0.375rem;
    }
    
    /* Media Grid Styling */
    .media-item {
        transition: all 0.3s ease;
    }
    
    .media-item:hover {
        transform: translateY(-4px);
    }
    
    .media-card {
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .media-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }
    
    .media-card:hover .overlay {
        opacity: 1 !important;
    }
    
    .media-select {
        transform: scale(1.2);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .media-select:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .badge {
        font-size: 0.7rem;
        font-weight: 500;
        padding: 0.4em 0.6em;
    }
    
    /* View Toggle Buttons */
    .btn-group .btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    
    /* Responsive adjustments */
    @media (max-width: 576px) {
        .col-12 {
            margin-bottom: 1rem;
        }
        
        .dropzone {
            min-height: 150px;
            padding: 1rem;
        }
    }
    
    @media (min-width: 1200px) {
        .col-xl-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
    }
    
    /* Loading animation */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }
</style>
@endpush

@push('scripts')
<!-- Dropzone.js JavaScript -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
let selectedMedia = new Set();
let dropzone;

// Initialize Dropzone
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Dropzone
    dropzone = new Dropzone("#media-dropzone", {
        url: "{{ route('admin.media.store') }}",
        paramName: "file",
        maxFilesize: 10, // MB
        acceptedFiles: "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar",
        addRemoveLinks: true,
        dictDefaultMessage: "Drop files here or click to upload",
        dictRemoveFile: "Remove",
        dictCancelUpload: "Cancel",
        dictUploadCanceled: "Upload canceled",
        dictInvalidFileType: "You can't upload files of this type.",
        dictFileTooBig: "File is too big (10MB max).",
        dictMaxFilesExceeded: "You can not upload any more files.",
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append("category", "general");
                formData.append("is_public", "1");
            });
            
            this.on("success", function(file, response) {
                if (response.success) {
                    showNotification('File uploaded successfully!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    this.removeFile(file);
                    showNotification(response.message || 'Upload failed', 'error');
                }
            });
            
            this.on("error", function(file, message) {
                this.removeFile(file);
                showNotification(message || 'Upload failed', 'error');
            });
        }
    });
});

// Open upload modal
function openUploadModal() {
    const dropzoneContainer = document.getElementById('dropzone-container');
    if (dropzoneContainer.style.display === 'none') {
        dropzoneContainer.style.display = 'block';
        dropzoneContainer.scrollIntoView({ behavior: 'smooth' });
    } else {
        dropzoneContainer.style.display = 'none';
    }
}

// Toggle view between grid and list
function toggleView(view) {
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    const mediaGrid = document.getElementById('media-grid');
    
    if (view === 'grid') {
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
        mediaGrid.className = 'row g-4';
    } else {
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
        mediaGrid.className = 'list-group';
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// View media
function viewMedia(id) {
    window.open('{{ route("admin.media.show", ":id") }}'.replace(':id', id), '_blank');
}

// Edit media
function editMedia(id) {
    // Fetch media details
    fetch('{{ route("admin.media.show", ":id") }}'.replace(':id', id))
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const media = data.media;
            document.getElementById('edit_media_id').value = media.id;
            document.getElementById('edit_alt_text').value = media.alt_text || '';
            document.getElementById('edit_description').value = media.description || '';
            document.getElementById('edit_category').value = media.category || '';
            document.getElementById('edit_is_public').checked = media.is_public;
            
            // Show modal
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    });
}

// Update media
function updateMedia() {
    const form = document.getElementById('editForm');
    const formData = new FormData(form);
    const mediaId = document.getElementById('edit_media_id').value;
    
    fetch('{{ route("admin.media.update", ":id") }}'.replace(':id', mediaId), {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Update failed: ' + data.message);
        }
    });
}

// Delete media
function deleteMedia(id) {
    if (confirm('Are you sure you want to delete this media item?')) {
        fetch('{{ route("admin.media.destroy", ":id") }}'.replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Delete failed: ' + data.message);
            }
        });
    }
}

// Bulk delete
function bulkDelete() {
    if (selectedMedia.size === 0) return;
    
    if (confirm(`Are you sure you want to delete ${selectedMedia.size} media items?`)) {
        fetch('{{ route("admin.media.bulk-delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                ids: Array.from(selectedMedia)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Bulk delete failed: ' + data.message);
            }
        });
    }
}

// Handle media selection
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('media-select')) {
        const mediaId = parseInt(e.target.value);
        
        if (e.target.checked) {
            selectedMedia.add(mediaId);
        } else {
            selectedMedia.delete(mediaId);
        }
        
        // Update UI
        updateBulkActions();
    }
});

function updateBulkActions() {
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (selectedMedia.size > 0) {
        bulkActions.style.display = 'block';
        selectedCount.textContent = `${selectedMedia.size} selected`;
    } else {
        bulkActions.style.display = 'none';
    }
}

// Select all checkbox
function selectAll(checked) {
    const checkboxes = document.querySelectorAll('.media-select');
    checkboxes.forEach(checkbox => {
        checkbox.checked = checked;
        const mediaId = parseInt(checkbox.value);
        if (checked) {
            selectedMedia.add(mediaId);
        } else {
            selectedMedia.delete(mediaId);
        }
    });
    updateBulkActions();
}
</script>
@endpush
