<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Settings</h1>
            <p class="text-muted small mb-0">Manage application settings and configuration</p>
        </div>
        <button wire:click="create" class="btn btn-dark btn-sm">
            <i class="fas fa-plus mr-1"></i>
            Add Setting
        </button>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label for="search" class="small text-muted mb-1">Search</label>
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search by key, description, or group...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label for="groupFilter" class="small text-muted mb-1">Group</label>
                        <select wire:model.live="groupFilter" class="form-control form-control-sm">
                            <option value="">All Groups</option>
                            @foreach($groups as $group)
                                <option value="{{ $group }}">{{ ucfirst($group) }}</option>
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
                    Create New Setting
                </h5>
                
                <form wire:submit.prevent="store">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form.key">Setting Key</label>
                                <input type="text" wire:model="form.key" class="form-control" placeholder="e.g., site_name">
                                @error('form.key') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.type">Type</label>
                                <select wire:model="form.type" class="form-control">
                                    <option value="string">String</option>
                                    <option value="number">Number</option>
                                    <option value="boolean">Boolean</option>
                                    <option value="json">JSON</option>
                                    <option value="text">Text</option>
                                </select>
                                @error('form.type') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="form.group">Group</label>
                                <input type="text" wire:model="form.group" class="form-control" placeholder="e.g., general">
                                @error('form.group') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.value">Value</label>
                                <textarea wire:model="form.value" class="form-control" rows="3" placeholder="Enter setting value"></textarea>
                                @error('form.value') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form.description">Description</label>
                                <textarea wire:model="form.description" class="form-control" rows="2" placeholder="Enter setting description"></textarea>
                                @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" wire:model="form.is_public" class="form-check-input">
                                    Public Setting
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm mr-2">
                            <i class="fas fa-times mr-1"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save mr-1"></i>
                            Create Setting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Settings Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('key')" class="border-0 py-2 px-3 text-muted font-weight-normal" style="cursor: pointer; width: 20%;">
                                <span class="d-flex align-items-center">
                                    Key
                                    @if($sortField === 'key')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1 text-primary"></i>
                                    @else
                                        <i class="fas fa-sort ml-1 text-muted"></i>
                                    @endif
                                </span>
                            </th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Group</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 15%;">Type</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal" style="width: 30%;">Value</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Status</th>
                            <th class="border-0 py-2 px-3 text-muted font-weight-normal text-center" style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $setting)
                            <tr class="border-bottom">
                                <td class="py-3 px-3">
                                    <div class="font-weight-medium text-dark">{{ $setting->key }}</div>
                                    @if($setting->description)
                                        <div class="text-muted small">{{ Str::limit($setting->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    <span class="badge badge-info badge-sm">{{ ucfirst($setting->group) }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="badge badge-{{ $setting->type === 'string' ? 'primary' : ($setting->type === 'number' ? 'success' : ($setting->type === 'boolean' ? 'warning' : ($setting->type === 'json' ? 'danger' : 'secondary'))) }} badge-sm">
                                        {{ ucfirst($setting->type) }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-muted small">
                                        @if($setting->type === 'json')
                                            {{ Str::limit(json_encode($setting->value), 50) }}
                                        @elseif($setting->type === 'boolean')
                                            {{ $setting->value ? 'true' : 'false' }}
                                        @else
                                            {{ Str::limit($setting->value, 50) }}
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="badge badge-{{ $setting->is_public ? 'success' : 'light' }} badge-sm">
                                        {{ $setting->is_public ? 'Public' : 'Private' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $setting->id }})" 
                                                class="btn btn-dark btn-sm border-0" 
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="togglePublic({{ $setting->id }})" 
                                                class="btn btn-outline-{{ $setting->is_public ? 'warning' : 'success' }} btn-sm border-0" 
                                                title="{{ $setting->is_public ? 'Make Private' : 'Make Public' }}">
                                            <i class="fas fa-{{ $setting->is_public ? 'lock' : 'unlock' }}"></i>
                                        </button>
                                        <button wire:click="delete({{ $setting->id }})" 
                                                class="btn btn-danger btn-sm border-0"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this setting?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Inline Edit Form -->
                            @if($editingId === $setting->id)
                                <tr class="bg-light">
                                    <td colspan="6">
                                        <div class="p-3 inline-edit-form">
                                            <h5 class="mb-3">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit Setting
                                            </h5>
                                            
                                            <form wire:submit.prevent="update">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form.key">Setting Key</label>
                                                            <input type="text" wire:model="form.key" class="form-control">
                                                            @error('form.key') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.type">Type</label>
                                                            <select wire:model="form.type" class="form-control">
                                                                <option value="string">String</option>
                                                                <option value="number">Number</option>
                                                                <option value="boolean">Boolean</option>
                                                                <option value="json">JSON</option>
                                                                <option value="text">Text</option>
                                                            </select>
                                                            @error('form.type') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="form.group">Group</label>
                                                            <input type="text" wire:model="form.group" class="form-control">
                                                            @error('form.group') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.value">Value</label>
                                                            <textarea wire:model="form.value" class="form-control" rows="3"></textarea>
                                                            @error('form.value') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form.description">Description</label>
                                                            <textarea wire:model="form.description" class="form-control" rows="2"></textarea>
                                                            @error('form.description') <span class="text-danger small">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" wire:model="form.is_public" class="form-check-input">
                                                                Public Setting
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group text-right">
                                                    <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm mr-2">
                                                        <i class="fas fa-times mr-1"></i>
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-dark btn-sm">
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
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-cog fa-lg mb-2 opacity-50"></i>
                                        <p class="mb-1 small">No settings found</p>
                                        <small class="text-muted">Click "Add Setting" to create your first one</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($settings->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top bg-light">
                    <div class="text-muted small">
                        {{ $settings->firstItem() }}-{{ $settings->lastItem() }} of {{ $settings->total() }}
                    </div>
                    <div>
                        {{ $settings->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
