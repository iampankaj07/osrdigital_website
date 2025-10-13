<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
  
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Hero Section
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by title, subtitle, or content...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="page_filter" class="small text-muted mb-1">Page</label>
                        <select wire:model.live="page_filter" class="form-control form-control-sm">
                            <option value="">All Pages</option>
                            @foreach($pages as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label for="perPage" class="small text-muted mb-1">Per Page</label>
                        <select wire:model.live="perPage" class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mb-4">
            <div class="card-body inline-edit-form">
                <h5 class="mb-3">
                    <i class="fas fa-plus mr-2"></i>
                    Create New Hero Section
                </h5>
                
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.page">Page</label>
                                <select wire:model="form.page" class="form-control">
                                    <option value="">Select Page</option>
                                    <option value="home">Home</option>
                                    <option value="about">About</option>
                                    <option value="services">Services</option>
                                    <option value="portfolio">Portfolio</option>
                                    <option value="contact">Contact</option>
                                </select>
                                @error('form.page') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.title">Title</label>
                                <input type="text" wire:model="form.title" class="form-control" placeholder="Enter title">
                                @error('form.title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.subtitle">Subtitle</label>
                                <input type="text" wire:model="form.subtitle" class="form-control" placeholder="Enter subtitle">
                                @error('form.subtitle') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.content">Content</label>
                                <textarea wire:model="form.content" class="form-control" rows="3" placeholder="Enter content"></textarea>
                                @error('form.content') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.button_text">Primary Button Text</label>
                                <input type="text" wire:model="form.button_text" class="form-control" placeholder="Enter button text">
                                @error('form.button_text') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.button_url">Primary Button URL</label>
                                <input type="url" wire:model="form.button_url" class="form-control" placeholder="Enter button URL">
                                @error('form.button_url') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.button_text_secondary">Secondary Button Text</label>
                                <input type="text" wire:model="form.button_text_secondary" class="form-control" placeholder="Enter secondary button text">
                                @error('form.button_text_secondary') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.button_url_secondary">Secondary Button URL</label>
                                <input type="url" wire:model="form.button_url_secondary" class="form-control" placeholder="Enter secondary button URL">
                                @error('form.button_url_secondary') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.background_image">Background Image URL</label>
                                <input type="text" wire:model="form.background_image" class="form-control" placeholder="Enter background image URL">
                                @error('form.background_image') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" wire:model="form.is_active" class="form-check-input">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="button" wire:click="cancelEdit" class="btn btn-secondary mr-2">
                            <i class="fas fa-times mr-1"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i>
                            Create Hero Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Hero Sections Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('page')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 15%;">
                                <span class="d-flex align-items-center">
                                    Page
                                    @if($sortField === 'page')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th wire:click="sortBy('title')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 40%;">
                                <span class="d-flex align-items-center">
                                    Title
                                    @if($sortField === 'title')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 15%;">Status</th>
                            <th wire:click="sortBy('created_at')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 15%;">
                                <span class="d-flex align-items-center">
                                    Created
                                    @if($sortField === 'created_at')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heroSections as $heroSection)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <span class="badge badge-light text-dark border small">{{ ucfirst($heroSection->page) }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-weight-medium text-dark">{{ Str::limit($heroSection->title, 60) }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="badge badge-{{ $heroSection->is_active ? 'success' : 'light' }} badge-sm">
                                        {{ $heroSection->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">{{ $heroSection->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $heroSection->id }})" 
                                                class="btn btn-dark btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="toggleActive({{ $heroSection->id }})" 
                                                class="btn btn-outline-{{ $heroSection->is_active ? 'warning' : 'success' }} btn-sm border-0" 
                                                title="{{ $heroSection->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $heroSection->is_active ? 'pause' : 'play' }}"></i>
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
                            @if($editingId === $heroSection->id)
                                <tr class="bg-light">
                                    <td colspan="5">
                                        <div class="p-3 inline-edit-form">
                                            <h5 class="mb-3">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit Hero Section
                                            </h5>
                                            
                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.page">Page</label>
                                                            <select wire:model="form.page" class="form-control">
                                                                <option value="home">Home</option>
                                                                <option value="about">About</option>
                                                                <option value="services">Services</option>
                                                                <option value="portfolio">Portfolio</option>
                                                                <option value="contact">Contact</option>
                                                            </select>
                                                            @error('form.page') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.title">Title</label>
                                                            <input type="text" wire:model="form.title" class="form-control">
                                                            @error('form.title') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.subtitle">Subtitle</label>
                                                            <input type="text" wire:model="form.subtitle" class="form-control">
                                                            @error('form.subtitle') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.content">Content</label>
                                                            <textarea wire:model="form.content" class="form-control" rows="3"></textarea>
                                                            @error('form.content') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.button_text">Primary Button Text</label>
                                                            <input type="text" wire:model="form.button_text" class="form-control">
                                                            @error('form.button_text') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.button_url">Primary Button URL</label>
                                                            <input type="url" wire:model="form.button_url" class="form-control">
                                                            @error('form.button_url') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.button_text_secondary">Secondary Button Text</label>
                                                            <input type="text" wire:model="form.button_text_secondary" class="form-control">
                                                            @error('form.button_text_secondary') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.button_url_secondary">Secondary Button URL</label>
                                                            <input type="url" wire:model="form.button_url_secondary" class="form-control">
                                                            @error('form.button_url_secondary') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.background_image">Background Image URL</label>
                                                            <input type="text" wire:model="form.background_image" class="form-control">
                                                            @error('form.background_image') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" wire:model="form.is_active" class="form-check-input">
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group text-right">
                                                    <button type="button" wire:click="cancelEdit" class="btn btn-secondary mr-2">
                                                        <i class="fas fa-times mr-1"></i>
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-dark">
                                                        <i class="fas fa-save mr-1"></i>
                                                        Update
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-star fa-lg mb-2 opacity-50"></i>
                                        <p class="mb-1 small">No hero sections found</p>
                                        <small class="text-muted">Click "Add Hero Section" to create your first one</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($heroSections->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top bg-light">
                    <div class="text-muted small">
                        {{ $heroSections->firstItem() }}-{{ $heroSections->lastItem() }} of {{ $heroSections->total() }}
                    </div>
                    <div>
                        {{ $heroSections->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
