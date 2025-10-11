@extends('admin.layout')

@section('title', 'Media Library')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Media Library</h1>
            <p class="text-muted">Manage your media files and assets</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-plus"></i> Upload Media
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

    <!-- Media Grid -->
    <div class="card">
        <div class="card-body">
            @if($media->count() > 0)
                <div class="row" id="media-grid">
                    @foreach($media as $item)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4 media-item" data-id="{{ $item->id }}">
                            <div class="card h-100">
                                <div class="position-relative">
                                    @if($item->isImage())
                                        <img src="{{ $item->thumbnail_url }}" 
                                             class="card-img-top" 
                                             alt="{{ $item->alt_text ?: $item->name }}"
                                             style="height: 150px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                                             style="height: 150px;">
                                            <i class="{{ $item->icon }} fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Selection checkbox -->
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <input type="checkbox" class="form-check-input media-select" 
                                               value="{{ $item->id }}">
                                    </div>
                                    
                                    <!-- Public/Private indicator -->
                                    <div class="position-absolute top-0 end-0 m-2">
                                        @if($item->is_public)
                                            <span class="badge bg-success">Public</span>
                                        @else
                                            <span class="badge bg-warning">Private</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="card-body p-2">
                                    <h6 class="card-title text-truncate" title="{{ $item->name }}">
                                        {{ $item->name }}
                                    </h6>
                                    <p class="card-text small text-muted mb-1">
                                        {{ $item->human_size }}
                                        @if($item->isImage() && $item->width && $item->height)
                                            • {{ $item->width }}×{{ $item->height }}
                                        @endif
                                    </p>
                                    @if($item->category)
                                        <span class="badge bg-secondary">{{ ucfirst($item->category) }}</span>
                                    @endif
                                </div>
                                
                                <div class="card-footer p-2">
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="viewMedia({{ $item->id }})" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                onclick="editMedia({{ $item->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteMedia({{ $item->id }})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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

@push('scripts')
<script>
let selectedMedia = new Set();

// Upload media
function uploadMedia() {
    const form = document.getElementById('uploadForm');
    const formData = new FormData(form);
    const progressDiv = document.getElementById('uploadProgress');
    const progressBar = progressDiv.querySelector('.progress-bar');
    const statusSpan = document.getElementById('uploadStatus');
    
    // Show progress
    progressDiv.classList.remove('d-none');
    
    fetch('{{ route("admin.media.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            statusSpan.textContent = 'Upload successful!';
            progressBar.style.width = '100%';
            progressBar.classList.add('bg-success');
            
            // Reload page after a short delay
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            statusSpan.textContent = 'Upload failed: ' + data.message;
            progressBar.classList.add('bg-danger');
        }
    })
    .catch(error => {
        statusSpan.textContent = 'Upload failed: ' + error.message;
        progressBar.classList.add('bg-danger');
    });
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
