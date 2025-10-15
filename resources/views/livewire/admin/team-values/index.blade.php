<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Team Values</h1>
            <p class="text-muted small mb-0">Manage team values and principles</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Team Value
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by title or description...">
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
                    Create New Team Value
                </h5>
                
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.title">Value Title</label>
                                <input type="text" wire:model="form.title" class="form-control" placeholder="Enter team value title">
                                @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
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
                    
                    <div class="form-group">
                        <label for="form.icon">Icon (FontAwesome class)</label>
                        <input type="text" wire:model="form.icon" class="form-control" placeholder="e.g., fas fa-users">
                        @error('form.icon') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="form.description">Description</label>
                        <textarea wire:model="form.description" class="form-control" rows="3" placeholder="Enter team value description"></textarea>
                        @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="button" wire:click="cancelEdit" class="btn btn-secondary mr-2">
                            <i class="fas fa-times mr-1"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i>
                            Create Team Value
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Team Values Table -->
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
                        <th wire:click="sortBy('title')" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100/50 transition-colors duration-150">
                            <div class="flex items-center space-x-1">
                                <span>Value</span>
                                @if($sortField === 'title')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-brand-orange-500"></i>
                                @else
                                    <i class="fas fa-sort text-gray-300"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($teamValues as $value)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $value->sort_order }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $value->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($value->icon)
                                    <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center">
                                        <i class="{{ $value->icon }} text-brand-orange-600 text-sm"></i>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-users text-gray-400 text-sm"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 max-w-xs">{{ Str::limit($value->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $value->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $value->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-1">
                                    <button wire:click="edit({{ $value->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button wire:click="toggleActive({{ $value->id }})"
                                            class="inline-flex items-center p-2 {{ $value->is_active ? 'text-yellow-500 hover:text-yellow-600' : 'text-green-500 hover:text-green-600' }} hover:bg-gray-100 rounded-lg transition-colors duration-150"
                                            title="{{ $value->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $value->is_active ? 'pause' : 'play' }} text-sm"></i>
                                    </button>
                                    <button wire:click="delete({{ $value->id }})"
                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150"
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this team value?')">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Inline Edit Form -->
                        @if($editingId === $value->id)
                            <tr class="bg-gray-50/50">
                                <td colspan="6" class="px-0">
                                    <div class="bg-white border border-gray-200 rounded-lg mx-6 my-4 shadow-sm">
                                        <div class="px-6 py-4 border-b border-gray-100">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-brand-orange-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-edit text-brand-orange-600 text-sm"></i>
                                                </div>
                                                <h5 class="text-lg font-medium text-gray-900">Edit Team Value</h5>
                                            </div>
                                        </div>
                                        <div class="p-6">
                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.title">Value Title</label>
                                                            <input type="text" wire:model="form.title" class="form-control">
                                                            @error('form.title') <span class="text-danger small">{{ $message }}</span> @enderror
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
                                                
                                                <div class="form-group">
                                                    <label for="form.icon">Icon (FontAwesome class)</label>
                                                    <input type="text" wire:model="form.icon" class="form-control" placeholder="e.g., fas fa-users">
                                                    @error('form.icon') <span class="text-danger small">{{ $message }}</span> @enderror
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="form.description">Description</label>
                                                    <textarea wire:model="form.description" class="form-control" rows="3"></textarea>
                                                    @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                                                </div>

                                                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
                                                    <button type="button" wire:click="cancelEdit" class="btn-slate">
                                                        <i class="fas fa-times mr-2"></i>
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-dark px-6 py-2">
                                                        <i class="fas fa-save mr-2"></i>
                                                        Update Value
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
                                        <i class="fas fa-users text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">No team values found</h3>
                                    <p class="text-sm text-gray-500">Create your first team value to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($teamValues->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing {{ $teamValues->firstItem() }} to {{ $teamValues->lastItem() }} of {{ $teamValues->total() }} results
                    </div>
                    <div>
                        {{ $teamValues->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>