@extends('admin.layout-falcon')

@section('title', 'Create New Associate')

@section('content')
<div class="row">
    <!-- Header Card -->
    <div class="col-12 mb-4">
        <div class="falcon-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="card-title mb-1">Create New Associate</h2>
                        <p class="text-muted mb-0">Add a new associate to your organization</p>
                    </div>
                    <a href="{{ route('admin.associates.index') }}" class="btn btn-falcon-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Associates
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="col-lg-8">
        <div class="falcon-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Associate Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.associates.store') }}" method="POST" enctype="multipart/form-data" id="associateForm">
                    @csrf
                    
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag me-1"></i>
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Enter associate name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">
                                <i class="fas fa-sort-numeric-down me-1"></i>
                                Sort Order
                            </label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                                   placeholder="Enter sort order" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-1"></i>
                                Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Enter associate description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo Upload -->
                        <div class="col-12 mb-3">
                            <label for="logo" class="form-label">
                                <i class="fas fa-image me-1"></i>
                                Logo
                            </label>
                            <div class="file-upload-area border-2 border-dashed border-secondary rounded p-4 text-center" 
                                 onclick="document.getElementById('logo').click()">
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                       id="logo" name="logo" accept="image/*" style="display: none;">
                                <div id="logoPreview" class="d-none">
                                    <img id="logoPreviewImg" src="" alt="Logo Preview" class="img-thumbnail mb-2" style="max-height: 100px;">
                                    <p class="text-muted small mb-0">Click to change logo</p>
                                </div>
                                <div id="logoPlaceholder">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Click to upload logo or drag and drop</p>
                                    <small class="text-muted">PNG, JPG, GIF up to 2MB</small>
                                </div>
                            </div>
                            @error('logo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-toggle-on me-1"></i>
                                Status
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <!-- Featured -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-star me-1"></i>
                                Featured
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                       value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Associate
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.associates.index') }}" class="btn btn-falcon-secondary">
                            <i class="fas fa-times me-1"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-falcon-primary" id="submitBtn">
                            <i class="fas fa-save me-1"></i>
                            Create Associate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Help Card -->
        <div class="falcon-card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-question-circle me-2"></i>
                    Help & Tips
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Use descriptive names for better organization</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Sort order determines display sequence</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Upload high-quality logos for best results</small>
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Featured associates appear prominently</small>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="falcon-card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-eye me-2"></i>
                    Preview
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div id="previewLogo" class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px; margin: 0 auto;">
                        <i class="fas fa-image text-muted"></i>
                    </div>
                    <h6 id="previewName" class="mb-1">Associate Name</h6>
                    <p id="previewDescription" class="text-muted small mb-2">Description will appear here</p>
                    <div class="d-flex justify-content-center gap-1">
                        <span id="previewStatus" class="badge badge-falcon-success">Active</span>
                        <span id="previewFeatured" class="badge badge-falcon-primary d-none">Featured</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Form Enhancements */
.form-label {
    font-weight: 500;
    color: var(--falcon-heading-color);
    margin-bottom: 0.5rem;
}

.form-control:focus {
    border-color: var(--falcon-primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
}

.form-check-input:checked {
    background-color: var(--falcon-primary);
    border-color: var(--falcon-primary);
}

/* File Upload Area */
.file-upload-area {
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: var(--falcon-primary) !important;
    background-color: rgba(44, 123, 229, 0.05);
}

.file-upload-area.dragover {
    border-color: var(--falcon-primary) !important;
    background-color: rgba(44, 123, 229, 0.1);
}

/* Preview Styles */
#previewLogo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.375rem;
}

/* Loading States */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 1rem;
    height: 1rem;
    margin: -0.5rem 0 0 -0.5rem;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Animations */
.fade-in {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.slide-in {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from { transform: translateX(-100%); }
    to { transform: translateX(0); }
}

/* Validation States */
.is-invalid {
    border-color: var(--falcon-danger);
}

.is-valid {
    border-color: var(--falcon-success);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: var(--falcon-danger);
}

.valid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: var(--falcon-success);
}
</style>
@endpush

@push('scripts')
<script>
// Form functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('associateForm');
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logoPreview');
    const logoPlaceholder = document.getElementById('logoPlaceholder');
    const logoPreviewImg = document.getElementById('logoPreviewImg');
    const submitBtn = document.getElementById('submitBtn');
    
    // Logo preview functionality
    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreviewImg.src = e.target.result;
                logoPreview.classList.remove('d-none');
                logoPlaceholder.classList.add('d-none');
                
                // Update preview
                updatePreview();
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Drag and drop functionality
    const fileUploadArea = document.querySelector('.file-upload-area');
    
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            logoInput.files = files;
            logoInput.dispatchEvent(new Event('change'));
        }
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Add loading state
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
        
        // Validate form
        if (validateForm()) {
            // Submit form
            this.submit();
        } else {
            // Remove loading state
            submitBtn.classList.remove('btn-loading');
            submitBtn.disabled = false;
        }
    });
    
    // Real-time preview updates
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const isActiveInput = document.getElementById('is_active');
    const isFeaturedInput = document.getElementById('is_featured');
    
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    isActiveInput.addEventListener('change', updatePreview);
    isFeaturedInput.addEventListener('change', updatePreview);
    
    function updatePreview() {
        const previewName = document.getElementById('previewName');
        const previewDescription = document.getElementById('previewDescription');
        const previewStatus = document.getElementById('previewStatus');
        const previewFeatured = document.getElementById('previewFeatured');
        
        previewName.textContent = nameInput.value || 'Associate Name';
        previewDescription.textContent = descriptionInput.value || 'Description will appear here';
        
        if (isActiveInput.checked) {
            previewStatus.textContent = 'Active';
            previewStatus.className = 'badge badge-falcon-success';
        } else {
            previewStatus.textContent = 'Inactive';
            previewStatus.className = 'badge badge-falcon-secondary';
        }
        
        if (isFeaturedInput.checked) {
            previewFeatured.classList.remove('d-none');
        } else {
            previewFeatured.classList.add('d-none');
        }
    }
    
    function validateForm() {
        let isValid = true;
        
        // Clear previous validation
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        
        // Validate name
        const nameInput = document.getElementById('name');
        if (!nameInput.value.trim()) {
            nameInput.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate logo file size
        const logoInput = document.getElementById('logo');
        if (logoInput.files.length > 0) {
            const file = logoInput.files[0];
            if (file.size > 2 * 1024 * 1024) { // 2MB
                logoInput.classList.add('is-invalid');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    // Add loading animation to cards
    const cards = document.querySelectorAll('.falcon-card');
    cards.forEach(card => {
        card.classList.add('fade-in');
    });
});

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush


