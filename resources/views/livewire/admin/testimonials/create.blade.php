<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create Testimonial</h1>
            <p class="text-muted">Add a new customer testimonial</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Testimonials
        </a>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Basic Information -->
                        <div class="form-group">
                            <label for="author_name">Author Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="author_name" class="form-control @error('author_name') is-invalid @enderror" placeholder="Enter author name">
                            @error('author_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="author_title">Author Title <span class="text-danger">*</span></label>
                            <input type="text" wire:model="author_title" class="form-control @error('author_title') is-invalid @enderror" placeholder="Enter author title/position">
                            @error('author_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Testimonial Content <span class="text-danger">*</span></label>
                            <textarea wire:model="content" class="form-control @error('content') is-invalid @enderror" rows="6" placeholder="Enter testimonial content"></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Avatar Upload -->
                        <div class="form-group">
                            <label for="avatar">Author Avatar</label>
                            <div class="custom-file">
                                <input type="file" wire:model="avatar" class="custom-file-input @error('avatar') is-invalid @enderror" accept="image/*">
                                <label class="custom-file-label" for="avatar">
                                    {{ $avatar ? $avatar->getClientOriginalName() : 'Choose file' }}
                                </label>
                            </div>
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Upload an avatar image (max 2MB)</small>
                        </div>

                        <!-- Preview -->
                        @if($avatar)
                            <div class="mt-3">
                                <label>Preview:</label>
                                <div class="border p-2 text-center">
                                    <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            </div>
                        @endif

                        <!-- Settings -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" wire:model="is_active" class="custom-control-input" id="is_active">
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" wire:model="sort_order" class="form-control @error('sort_order') is-invalid @enderror" min="0" value="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-group mt-4">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Create Testimonial
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
