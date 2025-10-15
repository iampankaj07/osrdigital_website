<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Associates</h1>
            <p class="text-muted small mb-0">Manage associate companies and partners</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Associate
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by name or website...">
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
            </div>
        </div>
    </div>

    <!-- Create Form -->
    @if($isCreating)
        <div class="card mb-4">
            <div class="card-body inline-edit-form">
                <h5 class="mb-3">
                    <i class="fas fa-plus mr-2"></i>
                    Create New Associate
                </h5>

                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.name">Company Name</label>
                                <input type="text" wire:model="form.name" class="form-control" placeholder="Enter company name">
                                @error('form.name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.sort_order">Sort Order</label>
                                <input type="number" wire:model="form.sort_order" class="form-control" min="0">
                                @error('form.sort_order') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" wire:model="form.is_active" class="form-check-input">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Logo Upload Options -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Logo Upload Method</label>
                                <div class="btn-group d-block">
                                    <label class="btn btn-slate btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                        <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;"> Media Library
                                    </label>
                                    <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                        <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;"> Upload New
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($uploadMethod === 'media_library')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select from Media Library</label>
                                    <div class="d-flex align-items-center">
                                        <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-images mr-1"></i>Browse Media
                                        </button>
                                        @if($selectedMediaUrl)
                                            <button type="button" wire:click="clearSelectedMedia" class="btn btn-outline-danger btn-sm ml-2">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                    @if($selectedMediaUrl)
                                        <div class="mt-2">
                                            <img src="{{ $selectedMediaUrl }}" alt="Selected" class="img-thumbnail" style="max-height: 60px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form.website">Website URL</label>
                                    <input type="url" wire:model="form.website" class="form-control form-control-sm" placeholder="Enter website URL">
                                    @error('form.website') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($uploadMethod === 'filepond')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload Logo</label>
                                    <div style="max-height: 100px;">
                                        <x-filepond::upload
                                            wire:model="filepondUploads"
                                            multiple="false"
                                            max-files="1"
                                            max-file-size="10MB"
                                            accepted-file-types="image/*"
                                            allow-reorder="false"
                                            credits="false"
                                            placeholder="Drop logo here"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form.website">Website URL</label>
                                    <input type="url" wire:model="form.website" class="form-control form-control-sm" placeholder="Enter website URL">
                                    @error('form.website') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group text-right">
                        <button type="button" wire:click="cancelEdit" class="btn btn-secondary mr-2">
                            <i class="fas fa-times mr-1"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i>
                            Create Associate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Associates Table -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th wire:click="sortBy('sort_order')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center space-x-1">
                                <span>Order</span>
                                @if($sortField === 'sort_order')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('name')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center space-x-1">
                                <span>Company</span>
                                @if($sortField === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Website</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($associates as $associate)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $associate->sort_order }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $associate->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($associate->logo_from_media || $associate->logo)
                                    <img src="{{ $associate->logo_from_media ?: $associate->logo }}" alt="{{ $associate->name }}" class="w-12 h-8 rounded object-cover shadow-sm">
                                @else
                                    <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-sm"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($associate->website)
                                    <a href="{{ $associate->website }}" target="_blank" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors duration-150">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Visit
                                    </a>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $associate->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $associate->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-1">
                                    <button wire:click="edit({{ $associate->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button wire:click="toggleActive({{ $associate->id }})"
                                            class="inline-flex items-center p-2 {{ $associate->is_active ? 'text-yellow-500 hover:text-yellow-600' : 'text-green-500 hover:text-green-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="{{ $associate->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $associate->is_active ? 'pause' : 'play' }} text-sm"></i>
                                    </button>
                                    <button wire:click="delete({{ $associate->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this associate?')">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Inline Edit Form -->
                        @if($editingId === $associate->id)
                            <tr class="bg-gray-50/50">
                                <td colspan="6" class="px-0">
                                    <div class="bg-white border border-gray-200 rounded-lg mx-6 my-4 shadow-sm">
                                        <div class="px-6 py-4 border-b border-gray-100">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-edit text-brand-orange-600 text-sm"></i>
                                                </div>
                                                <h5 class="text-lg font-medium text-gray-900">Edit Associate</h5>
                                            </div>
                                        </div>
                                        <div class="p-6">

                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.name">Company Name</label>
                                                            <input type="text" wire:model="form.name" class="form-control">
                                                            @error('form.name') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.sort_order">Sort Order</label>
                                                            <input type="number" wire:model="form.sort_order" class="form-control" min="0">
                                                            @error('form.sort_order') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" wire:model="form.is_active" class="form-check-input">
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Logo Upload Options for Edit -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Logo Upload Method</label>
                                                            <div class="btn-group d-block">
                                                                <label class="btn btn-slate btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                                                    <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;"> Media Library
                                                                </label>
                                                                <label class="btn btn-outline-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                                                    <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;"> Upload New
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($uploadMethod === 'media_library')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Select from Media Library</label>
                                                                <div class="d-flex align-items-center">
                                                                    <button type="button" wire:click="openMediaSelector" class="btn btn-outline-primary btn-sm">
                                                                        <i class="fas fa-images mr-1"></i>Browse Media
                                                                    </button>
                                                                    @if($selectedMediaUrl)
                                                                        <button type="button" wire:click="clearSelectedMedia" class="btn btn-outline-danger btn-sm ml-2">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                                @if($selectedMediaUrl)
                                                                    <div class="mt-2">
                                                                        <img src="{{ $selectedMediaUrl }}" alt="Selected" class="img-thumbnail" style="max-height: 60px;">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.website">Website URL</label>
                                                                <input type="url" wire:model="form.website" class="form-control form-control-sm">
                                                                @error('form.website') <span class="text-danger small">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($uploadMethod === 'filepond')
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload New Logo</label>
                                                                <div style="max-height: 100px;">
                                                                    <x-filepond::upload
                                                                        wire:model="filepondUploads"
                                                                        multiple="false"
                                                                        max-files="1"
                                                                        max-file-size="10MB"
                                                                        accepted-file-types="image/*"
                                                                        allow-reorder="false"
                                                                        credits="false"
                                                                        placeholder="Drop new logo here"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form.website">Website URL</label>
                                                                <input type="url" wire:model="form.website" class="form-control form-control-sm">
                                                                @error('form.website') <span class="text-danger small">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                                                <button type="button" wire:click="cancelEdit" class="btn-slate">
                                                    <i class="fas fa-times mr-2"></i>
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-dark px-6 py-2">
                                                    <i class="fas fa-save mr-2"></i>
                                                    Update Associate
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-handshake text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">No associates found</h3>
                                    <p class="text-sm text-gray-500">Create your first associate to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($associates->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing {{ $associates->firstItem() }} to {{ $associates->lastItem() }} of {{ $associates->total() }} results
                    </div>
                    <div>
                        {{ $associates->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Media Selector Component -->
    @livewire('components.media-selector')
</div>

<script>
document.addEventListener('livewire:initialized', function() {
    console.log('Associates component - Livewire initialized');

    // Ensure FilePond is working with Livewire
    Livewire.hook('morph.updated', ({ el, component }) => {
        if (component.name === 'admin.associates.index') {
            console.log('Associates component updated');

            // Re-initialize any FilePond instances that may have been destroyed
            setTimeout(() => {
                const filepondElements = el.querySelectorAll('[wire\\:model="filepondUploads"]');
                filepondElements.forEach(element => {
                    if (!element.filepond) {
                        console.log('Re-initializing FilePond element');
                    }
                });
            }, 100);
        }
    });

    // Handle upload method changes
    window.addEventListener('uploadMethodChanged', function() {
        console.log('Upload method changed - reinitializing FilePond if needed');
    });
});
</script>
