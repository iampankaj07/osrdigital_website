<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Team Members</h1>
            <p class="text-muted small mb-0">Manage team members and their information</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Team Member
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by name, position, or department...">
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


    <!-- Team Members Table -->
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
                                <span>Member</span>
                                @if($sortField === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('position')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center space-x-1">
                                <span>Position</span>
                                @if($sortField === 'position')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($teamMembers as $member)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $member->sort_order }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($member->image_url)
                                            <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-full object-cover shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-gray-400 text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900 truncate">
                                            {{ $member->name }}
                                        </div>
                                        @if($member->email)
                                            <div class="text-sm text-gray-500 truncate">
                                                <i class="fas fa-envelope mr-1"></i>
                                                {{ $member->email }}
                                            </div>
                                        @endif
                                        <div class="flex items-center mt-1 space-x-2">
                                            @if($member->linkedin)
                                                <a href="{{ $member->linkedin }}" target="_blank" class="text-blue-500 hover:text-blue-600" title="LinkedIn">
                                                    <i class="fab fa-linkedin text-sm"></i>
                                                </a>
                                            @endif
                                            @if($member->twitter)
                                                <a href="{{ $member->twitter }}" target="_blank" class="text-blue-400 hover:text-blue-500" title="Twitter">
                                                    <i class="fab fa-twitter text-sm"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $member->position }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $member->department ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-1">
                                    <button wire:click="edit({{ $member->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button wire:click="toggleActive({{ $member->id }})"
                                            class="inline-flex items-center p-2 {{ $member->is_active ? 'text-yellow-500 hover:text-yellow-600' : 'text-green-500 hover:text-green-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="{{ $member->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $member->is_active ? 'pause' : 'play' }} text-sm"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $member->id }}, 'team member')"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                            title="Delete">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-users text-gray-400 text-xl"></i>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900 mb-1">No team members found</h3>
                                <p class="text-sm text-gray-500">Create your first team member to get started.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($teamMembers->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing {{ $teamMembers->firstItem() }} to {{ $teamMembers->lastItem() }} of {{ $teamMembers->total() }} results
                </div>
                <div>
                    {{ $teamMembers->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

    @livewire('components.media-selector')

    <!-- Slide Panel -->
    @if($showSlidePanel)
        <!-- Backdrop -->
        <div class="slide-panel-backdrop {{ $isClosing ? 'fade-out' : '' }}"
             wire:click="closeSlidePanel"
             wire:key="backdrop-{{ $showSlidePanel }}"></div>

        <!-- Slide Panel -->
        <div class="slide-panel {{ $isClosing ? 'slide-out-right' : '' }}"
             wire:key="panel-{{ $showSlidePanel }}">
            <div class="slide-panel-header">
                <h5 class="mb-0">
                    @if($isCreating)
                        <i class="fas fa-plus mr-2"></i>Create New Team Member
                    @else
                        <i class="fas fa-edit mr-2"></i>Edit Team Member
                    @endif
                </h5>
                <button type="button" wire:click="closeSlidePanel" class="btn btn-sm btn-link text-muted p-0" style="font-size: 1.5rem; line-height: 1;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="slide-panel-body">
                <form wire:submit="{{ $isCreating ? 'store' : 'update' }}">
                    <div class="form-group mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror" placeholder="Enter full name">
                        @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Position <span class="text-danger">*</span></label>
                        <input type="text" wire:model="form.position" class="form-control @error('form.position') is-invalid @enderror" placeholder="Enter position/title">
                        @error('form.position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" wire:model="form.department" class="form-control @error('form.department') is-invalid @enderror" placeholder="Enter department">
                        @error('form.department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" wire:model="form.email" class="form-control @error('form.email') is-invalid @enderror" placeholder="Enter email address">
                        @error('form.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" wire:model="form.linkedin" class="form-control @error('form.linkedin') is-invalid @enderror" placeholder="https://linkedin.com/in/username">
                        @error('form.linkedin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Twitter URL</label>
                        <input type="url" wire:model="form.twitter" class="form-control @error('form.twitter') is-invalid @enderror" placeholder="https://twitter.com/username">
                        @error('form.twitter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Avatar Upload Options -->
                    <div class="form-group mb-3">
                        <label class="form-label">Avatar Upload Method</label>
                        <div class="btn-group d-block">
                            <label class="btn btn-dark btn-sm {{ $uploadMethod === 'media_library' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'media_library')">
                                <input type="radio" wire:model="uploadMethod" value="media_library" style="display: none;"> Media Library
                            </label>
                            <label class="btn btn-primary btn-sm {{ $uploadMethod === 'filepond' ? 'active' : '' }}" wire:click="$set('uploadMethod', 'filepond')">
                                <input type="radio" wire:model="uploadMethod" value="filepond" style="display: none;"> Upload New
                            </label>
                        </div>
                    </div>

                    @if($uploadMethod === 'media_library')
                        <div class="form-group mb-3">
                            <label class="form-label">Select from Media Library</label>
                            <div class="d-flex align-items-center mb-2">
                                <button type="button" wire:click="openMediaSelector" class="btn btn-primary btn-sm">
                                    <i class="fas fa-images mr-1"></i>Browse Media
                                </button>
                                @if($selectedMediaUrl)
                                    <button type="button" wire:click="clearSelectedMedia" class="btn btn-outline-danger btn-sm ml-2">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                @endif
                            </div>
                            @if($selectedMediaUrl)
                                <div class="mt-2">
                                    <img src="{{ $selectedMediaUrl }}" alt="Selected Avatar" class="img-thumbnail rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($uploadMethod === 'filepond')
                        <div class="form-group mb-3">
                            <label class="form-label">Upload Avatar</label>
                            <div style="max-height: 120px;">
                                <x-filepond::upload
                                    wire:model="filepondUploads"
                                    multiple="false"
                                    accepted-file-types="image/*"
                                    max-file-size="10MB"
                                    placeholder="Drop avatar here or <span class='filepond--label-action'>Browse</span>"
                                />
                            </div>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" wire:model="form.sort_order" class="form-control @error('form.sort_order') is-invalid @enderror" min="0">
                        @error('form.sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model="form.is_active" id="is_active_slide">
                        <label class="form-check-label" for="is_active_slide">
                            Active
                        </label>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between pt-3 border-top mt-4">
                        <button type="button" wire:click="closeSlidePanel" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>{{ $isCreating ? 'Create' : 'Update' }} Team Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @script
    <script>
        $wire.on('close-panel-animation', () => {
            setTimeout(() => {
                $wire.finishClosing();
            }, 300);
        });

        Livewire.hook('morph.updated', ({ el, component }) => {
            const panel = el.querySelector('.slide-panel.slide-out-right');
            if (panel && !panel.dataset.closingHandled) {
                panel.dataset.closingHandled = 'true';
                setTimeout(() => {
                    $wire.finishClosing();
                }, 300);
            }
        });
    </script>
    @endscript

<style>
    /* Slide Panel Styles */
    .slide-panel-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        animation: fadeIn 0.3s ease-out;
    }

    .slide-panel {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        width: 600px;
        max-width: 90vw;
        background: white;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1050;
        display: flex;
        flex-direction: column;
        animation: slideInRight 0.3s ease-out;
        overflow-y: auto;
    }

    .slide-panel-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .slide-panel-body {
        padding: 1.5rem;
        flex: 1;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(100%);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    .slide-panel-backdrop.fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }

    .slide-panel.slide-out-right {
        animation: slideOutRight 0.3s ease-out forwards;
    }

    @media (max-width: 768px) {
        .slide-panel {
            width: 100vw;
            max-width: 100vw;
        }
    }
</style>
    @include('livewire.admin.partials.delete-confirm')
</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', function() {
    console.log('Team Members - Livewire initialized');

    // Handle media selection events
    window.addEventListener('mediaSelected', function(event) {
        @this.call('handleMediaSelection', event.detail);
    });
});
</script>
@endpush
