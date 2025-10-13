<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-home mr-2 text-primary"></i>Home Hero Sections Management
            </h4>
            <p class="text-muted small mb-0">Manage hero sections for the home page with dynamic backgrounds</p>
        </div>
        <div>
            <button wire:click="create" class="btn btn-dark btn-sm">
                <i class="fas fa-plus mr-1"></i>Add Hero Section
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search hero sections...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="perPage" class="small text-muted mb-1">Per Page</label>
                        <select wire:model.live="perPage" class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="sortField" class="small text-muted mb-1">Sort By</label>
                        <select wire:model.live="sortField" class="form-control form-control-sm">
                            <option value="sort_order">Sort Order</option>
                            <option value="title">Title</option>
                            <option value="created_at">Created Date</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Sections Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('title')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 25%;">
                                <span class="d-flex align-items-center">
                                    Title
                                    @if($sortField === 'title')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 15%;">Background</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 20%;">Content Preview</th>
                            <th wire:click="sortBy('sort_order')" class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="cursor: pointer; width: 10%;">
                                <span class="d-flex align-items-center justify-content-center">
                                    Order
                                    @if($sortField === 'sort_order')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Status</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heroSections as $heroSection)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <div class="font-weight-medium text-dark">{{ $heroSection->title }}</div>
                                    @if($heroSection->subtitle)
                                        <small class="text-muted">{{ Str::limit($heroSection->subtitle, 50) }}</small>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    @if($heroSection->background_type === 'image' && $heroSection->background_image)
                                        <div class="d-flex justify-content-center">
                                            <img src="{{ Storage::url($heroSection->background_image) }}" 
                                                 alt="Background" 
                                                 style="width: 40px; height: 30px; object-fit: cover; border-radius: 4px;">
                                        </div>
                                        <small class="text-muted">Image</small>
                                    @elseif($heroSection->background_type === 'color' && $heroSection->background_color)
                                        <div class="d-flex justify-content-center">
                                            <div style="width: 40px; height: 30px; background-color: {{ $heroSection->background_color }}; border-radius: 4px; border: 1px solid #ddd;"></div>
                                        </div>
                                        <small class="text-muted">Color</small>
                                    @else
                                        <span class="text-muted small">None</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">
                                        @if($heroSection->button_text)
                                            <div><strong>Primary:</strong> {{ $heroSection->button_text }}</div>
                                        @endif
                                        @if($heroSection->button_text_secondary)
                                            <div><strong>Secondary:</strong> {{ $heroSection->button_text_secondary }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="badge badge-light text-dark border small">{{ $heroSection->sort_order }}</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span wire:click="toggleActive({{ $heroSection->id }})" 
                                          class="badge badge-{{ $heroSection->is_active ? 'success' : 'light' }} badge-sm" 
                                          style="cursor: pointer;">
                                        {{ $heroSection->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $heroSection->id }})" 
                                                class="btn btn-dark btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $heroSection->id }})" 
                                                class="btn btn-danger btn-sm border-0"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this hero section?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId == $heroSection->id)
                                <tr>
                                    <td colspan="6" class="p-0">
                                        <div class="card m-2">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-edit mr-2"></i>Edit Hero Section
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <form wire:submit.prevent="update">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.title">Title <span class="text-danger">*</span></label>
                                                                <input type="text" wire:model="form.title" 
                                                                       class="form-control @error('form.title') is-invalid @enderror" 
                                                                       placeholder="Enter hero section title">
                                                                @error('form.title')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.subtitle">Subtitle</label>
                                                                <input type="text" wire:model="form.subtitle" 
                                                                       class="form-control @error('form.subtitle') is-invalid @enderror" 
                                                                       placeholder="Enter subtitle">
                                                                @error('form.subtitle')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="form.content">Content</label>
                                                        <textarea wire:model="form.content" 
                                                                  class="form-control @error('form.content') is-invalid @enderror" 
                                                                  rows="3" placeholder="Enter hero section content"></textarea>
                                                        @error('form.content')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.button_text">Primary Button Text</label>
                                                                <input type="text" wire:model="form.button_text" 
                                                                       class="form-control @error('form.button_text') is-invalid @enderror" 
                                                                       placeholder="e.g., Learn More">
                                                                @error('form.button_text')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.button_url">Primary Button URL</label>
                                                                <input type="url" wire:model="form.button_url" 
                                                                       class="form-control @error('form.button_url') is-invalid @enderror" 
                                                                       placeholder="https://example.com">
                                                                @error('form.button_url')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.button_text_secondary">Secondary Button Text</label>
                                                                <input type="text" wire:model="form.button_text_secondary" 
                                                                       class="form-control @error('form.button_text_secondary') is-invalid @enderror" 
                                                                       placeholder="e.g., Contact Us">
                                                                @error('form.button_text_secondary')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.button_url_secondary">Secondary Button URL</label>
                                                                <input type="url" wire:model="form.button_url_secondary" 
                                                                       class="form-control @error('form.button_url_secondary') is-invalid @enderror" 
                                                                       placeholder="https://example.com">
                                                                @error('form.button_url_secondary')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="form.background_type">Background Type</label>
                                                                <select wire:model="form.background_type" 
                                                                        class="form-control @error('form.background_type') is-invalid @enderror">
                                                                    <option value="color">Color</option>
                                                                    <option value="image">Image</option>
                                                                </select>
                                                                @error('form.background_type')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            @if($form['background_type'] === 'color')
                                                                <div class="form-group">
                                                                    <label for="form.background_color">Background Color</label>
                                                                    <input type="color" wire:model="form.background_color" 
                                                                           class="form-control @error('form.background_color') is-invalid @enderror">
                                                                    @error('form.background_color')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label for="backgroundImage">Background Image</label>
                                                                    <input type="file" wire:model="backgroundImage" 
                                                                           class="form-control @error('backgroundImage') is-invalid @enderror" 
                                                                           accept="image/*">
                                                                    @error('backgroundImage')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                    @if($form['background_image'])
                                                                        <small class="text-muted">Current: {{ basename($form['background_image']) }}</small>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="form.text_color">Text Color</label>
                                                                <input type="color" wire:model="form.text_color" 
                                                                       class="form-control @error('form.text_color') is-invalid @enderror">
                                                                @error('form.text_color')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.sort_order">Sort Order</label>
                                                                <input type="number" wire:model="form.sort_order" 
                                                                       class="form-control @error('form.sort_order') is-invalid @enderror" 
                                                                       min="0">
                                                                @error('form.sort_order')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <div class="form-check mt-4">
                                                                    <input type="checkbox" wire:model="form.is_active" 
                                                                           class="form-check-input @error('form.is_active') is-invalid @enderror" 
                                                                           id="form.is_active">
                                                                    <label class="form-check-label" for="form.is_active">
                                                                        Active
                                                                    </label>
                                                                </div>
                                                                @error('form.is_active')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group text-right">
                                                        <button type="button" class="btn btn-secondary btn-sm mr-2" wire:click="cancelEdit">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-dark btn-sm">
                                                            <i class="fas fa-save mr-1"></i>Update Hero Section
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-home fa-3x mb-3 opacity-50"></i>
                                        <h5 class="font-weight-normal">No hero sections found</h5>
                                        <p class="small">Start by creating your first hero section</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-muted small">
            Showing {{ $heroSections->firstItem() ?? 0 }} to {{ $heroSections->lastItem() ?? 0 }} of {{ $heroSections->total() }} results
        </div>
        <div>
            {{ $heroSections->links() }}
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus mr-2"></i>Create New Hero Section
                </h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.title">Title <span class="text-danger">*</span></label>
                                <input type="text" wire:model="form.title" 
                                       class="form-control @error('form.title') is-invalid @enderror" 
                                       placeholder="Enter hero section title">
                                @error('form.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.subtitle">Subtitle</label>
                                <input type="text" wire:model="form.subtitle" 
                                       class="form-control @error('form.subtitle') is-invalid @enderror" 
                                       placeholder="Enter subtitle">
                                @error('form.subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="form.content">Content</label>
                        <textarea wire:model="form.content" 
                                  class="form-control @error('form.content') is-invalid @enderror" 
                                  rows="4" placeholder="Enter hero section content"></textarea>
                        @error('form.content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.button_text">Primary Button Text</label>
                                <input type="text" wire:model="form.button_text" 
                                       class="form-control @error('form.button_text') is-invalid @enderror" 
                                       placeholder="e.g., Learn More">
                                @error('form.button_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.button_url">Primary Button URL</label>
                                <input type="url" wire:model="form.button_url" 
                                       class="form-control @error('form.button_url') is-invalid @enderror" 
                                       placeholder="https://example.com">
                                @error('form.button_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.button_text_secondary">Secondary Button Text</label>
                                <input type="text" wire:model="form.button_text_secondary" 
                                       class="form-control @error('form.button_text_secondary') is-invalid @enderror" 
                                       placeholder="e.g., Contact Us">
                                @error('form.button_text_secondary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.button_url_secondary">Secondary Button URL</label>
                                <input type="url" wire:model="form.button_url_secondary" 
                                       class="form-control @error('form.button_url_secondary') is-invalid @enderror" 
                                       placeholder="https://example.com">
                                @error('form.button_url_secondary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.background_type">Background Type</label>
                                <select wire:model="form.background_type" 
                                        class="form-control @error('form.background_type') is-invalid @enderror">
                                    <option value="color">Color</option>
                                    <option value="image">Image</option>
                                </select>
                                @error('form.background_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            @if($form['background_type'] === 'color')
                                <div class="form-group">
                                    <label for="form.background_color">Background Color</label>
                                    <input type="color" wire:model="form.background_color" 
                                           class="form-control @error('form.background_color') is-invalid @enderror">
                                    @error('form.background_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="backgroundImage">Background Image</label>
                                    <input type="file" wire:model="backgroundImage" 
                                           class="form-control @error('backgroundImage') is-invalid @enderror" 
                                           accept="image/*">
                                    @error('backgroundImage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form.text_color">Text Color</label>
                                <input type="color" wire:model="form.text_color" 
                                       class="form-control @error('form.text_color') is-invalid @enderror">
                                @error('form.text_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.sort_order">Sort Order</label>
                                <input type="number" wire:model="form.sort_order" 
                                       class="form-control @error('form.sort_order') is-invalid @enderror" 
                                       min="0">
                                @error('form.sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check mt-4">
                                    <input type="checkbox" wire:model="form.is_active" 
                                           class="form-check-input @error('form.is_active') is-invalid @enderror" 
                                           id="form.is_active">
                                    <label class="form-check-label" for="form.is_active">
                                        Active
                                    </label>
                                </div>
                                @error('form.is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary btn-sm mr-2" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-dark btn-sm">
                            <i class="fas fa-save mr-1"></i>Create Hero Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('toast', (event) => {
        if (window.Toaster) {
            window.Toaster[event.type](event.message);
        }
    });
});
</script>