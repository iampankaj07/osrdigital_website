@extends('admin.layout')

@section('title', 'Media Details - ' . $media->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Media Details</h1>
            <p class="text-muted">{{ $media->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Media Library
            </a>
            <button type="button" class="btn btn-primary" onclick="editMedia({{ $media->id }})">
                <i class="fas fa-edit"></i> Edit
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Media Preview -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body text-center">
                    @if($media->isImage())
                        <img src="{{ $media->public_url }}" 
                             class="img-fluid" 
                             alt="{{ $media->alt_text ?: $media->name }}"
                             style="max-height: 500px;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" 
                             style="height: 400px;">
                            <div class="text-center">
                                <i class="{{ $media->icon }} fa-5x text-muted mb-3"></i>
                                <h4 class="text-muted">{{ $media->name }}</h4>
                                <p class="text-muted">{{ $media->mime_type }}</p>
                                <a href="{{ $media->public_url }}" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Media Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Media Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $media->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong></td>
                            <td>
                                <span class="badge bg-primary">{{ $media->mime_type }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Size:</strong></td>
                            <td>{{ $media->human_size }}</td>
                        </tr>
                        @if($media->isImage() && $media->width && $media->height)
                        <tr>
                            <td><strong>Dimensions:</strong></td>
                            <td>{{ $media->width }} × {{ $media->height }} pixels</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Category:</strong></td>
                            <td>
                                @if($media->category)
                                    <span class="badge bg-secondary">{{ ucfirst($media->category) }}</span>
                                @else
                                    <span class="text-muted">No category</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Visibility:</strong></td>
                            <td>
                                @if($media->is_public)
                                    <span class="badge bg-success">Public</span>
                                @else
                                    <span class="badge bg-warning">Private</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Uploaded by:</strong></td>
                            <td>{{ $media->uploader->name ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Uploaded at:</strong></td>
                            <td>{{ $media->created_at->format('M j, Y g:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Last modified:</strong></td>
                            <td>{{ $media->updated_at->format('M j, Y g:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Alt Text & Description -->
            @if($media->alt_text || $media->description)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Details</h5>
                </div>
                <div class="card-body">
                    @if($media->alt_text)
                    <div class="mb-3">
                        <strong>Alt Text:</strong>
                        <p class="text-muted">{{ $media->alt_text }}</p>
                    </div>
                    @endif
                    
                    @if($media->description)
                    <div>
                        <strong>Description:</strong>
                        <p class="text-muted">{{ $media->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ $media->public_url }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-external-link-alt"></i> View Original
                        </a>
                        
                        @if($media->isImage())
                        <a href="{{ $media->thumbnail_url }}" class="btn btn-outline-secondary" target="_blank">
                            <i class="fas fa-image"></i> View Thumbnail
                        </a>
                        @endif
                        
                        <a href="{{ $media->public_url }}" class="btn btn-outline-success" download>
                            <i class="fas fa-download"></i> Download
                        </a>
                        
                        <button type="button" class="btn btn-outline-info" onclick="copyUrl('{{ $media->public_url }}')">
                            <i class="fas fa-copy"></i> Copy URL
                        </button>
                        
                        <button type="button" class="btn btn-outline-warning" onclick="editMedia({{ $media->id }})">
                            <i class="fas fa-edit"></i> Edit Details
                        </button>
                        
                        <button type="button" class="btn btn-outline-danger" onclick="deleteMedia({{ $media->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
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
                    
                    <div class="mb-3">
                        <label for="edit_alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="edit_alt_text" name="alt_text" 
                               value="{{ $media->alt_text }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3">{{ $media->description }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="edit_category" name="category" 
                               value="{{ $media->category }}">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_is_public" name="is_public" value="1" 
                                   {{ $media->is_public ? 'checked' : '' }}>
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
@endsection

@push('scripts')
<script>
// Edit media
function editMedia(id) {
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// Update media
function updateMedia() {
    const form = document.getElementById('editForm');
    const formData = new FormData(form);
    
    fetch('{{ route("admin.media.update", $media->id) }}', {
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
        fetch('{{ route("admin.media.destroy", $media->id) }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("admin.media.index") }}';
            } else {
                alert('Delete failed: ' + data.message);
            }
        });
    }
}

// Copy URL to clipboard
function copyUrl(url) {
    navigator.clipboard.writeText(url).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> Copied!';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-info');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-info');
        }, 2000);
    }).catch(function(err) {
        alert('Failed to copy URL: ' + err);
    });
}
</script>
@endpush
