<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Hero Section</h1>
            <p class="text-muted">Update hero section information</p>
        </div>
        <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Hero Sections
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
                            <label for="page">Page <span class="text-danger">*</span></label>
                            <select wire:model="page" class="form-control @error('page') is-invalid @enderror">
                                <option value="">Select a page</option>
                                @foreach($pages as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('page')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter hero section title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subtitle">Subtitle</label>
                            <input type="text" wire:model="subtitle" class="form-control @error('subtitle') is-invalid @enderror" placeholder="Enter subtitle">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Content <span class="text-danger">*</span></label>
                            <textarea wire:model="content" class="form-control @error('content') is-invalid @enderror" rows="6" placeholder="Enter hero section content"></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Primary Button</h5>
                                <div class="form-group">
                                    <label for="button_text">Button Text</label>
                                    <input type="text" wire:model="button_text" class="form-control @error('button_text') is-invalid @enderror" placeholder="e.g., Learn More">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="button_link">Button Link</label>
                                    <input type="url" wire:model="button_link" class="form-control @error('button_link') is-invalid @enderror" placeholder="https://example.com">
                                    @error('button_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Secondary Button</h5>
                                <div class="form-group">
                                    <label for="button_text_secondary">Button Text</label>
                                    <input type="text" wire:model="button_text_secondary" class="form-control @error('button_text_secondary') is-invalid @enderror" placeholder="e.g., Contact Us">
                                    @error('button_text_secondary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="button_link_secondary">Button Link</label>
                                    <input type="url" wire:model="button_link_secondary" class="form-control @error('button_link_secondary') is-invalid @enderror" placeholder="https://example.com">
                                    @error('button_link_secondary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
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

                        <!-- Preview -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Preview</h6>
                            </div>
                            <div class="card-body">
                                @if($title)
                                    <h4 class="text-primary">{{ $title }}</h4>
                                @endif
                                @if($subtitle)
                                    <p class="text-muted">{{ $subtitle }}</p>
                                @endif
                                @if($content)
                                    <p class="small">{{ Str::limit($content, 100) }}</p>
                                @endif
                                <div class="d-flex gap-2">
                                    @if($button_text)
                                        <button class="btn btn-primary btn-sm">{{ $button_text }}</button>
                                    @endif
                                    @if($button_text_secondary)
                                        <button class="btn btn-outline-primary btn-sm">{{ $button_text_secondary }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-group mt-4">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Update Hero Section
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
