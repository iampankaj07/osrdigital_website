<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Associate</h1>
            <p class="text-muted">Update associate information</p>
        </div>
        <a href="{{ route('admin.associates.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Associates
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
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter associate name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter associate description"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select wire:model="type" class="form-control @error('type') is-invalid @enderror">
                                        <option value="production">Production</option>
                                        <option value="distribution">Distribution</option>
                                        <option value="technology">Technology</option>
                                        <option value="other">Other</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website_url">Website URL</label>
                                    <input type="url" wire:model="website_url" class="form-control @error('website_url') is-invalid @enderror" placeholder="https://example.com">
                                    @error('website_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Current Logo -->
                        @if($old_logo)
                            <div class="form-group">
                                <label>Current Logo:</label>
                                <div class="border p-2 text-center">
                                    <img src="{{ Storage::url($old_logo) }}" alt="Current Logo" class="img-fluid" style="max-height: 150px;">
                                </div>
                            </div>
                        @endif

                        <!-- Logo Upload -->
                        <div class="form-group">
                            <label for="logo">New Logo</label>
                            <div class="custom-file">
                                <input type="file" wire:model="logo" class="custom-file-input @error('logo') is-invalid @enderror" accept="image/*">
                                <label class="custom-file-label" for="logo">
                                    {{ $logo ? $logo->getClientOriginalName() : 'Choose new file' }}
                                </label>
                            </div>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Upload a new logo image (max 2MB)</small>
                        </div>

                        <!-- Preview -->
                        @if($logo)
                            <div class="mt-3">
                                <label>New Logo Preview:</label>
                                <div class="border p-2 text-center">
                                    <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="img-fluid" style="max-height: 150px;">
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
                            <input type="number" wire:model="sort_order" class="form-control @error('sort_order') is-invalid @enderror" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-group mt-4">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.associates.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Update Associate
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
