<div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-bullseye mr-2"></i>Mission & Vision
            </h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-bullseye mr-2"></i>Mission
                        </h6>
                        <div class="form-group">
                            <label for="form.mission_title">Mission Title <span class="text-danger">*</span></label>
                            <input type="text" wire:model="form.mission_title" 
                                   class="form-control @error('form.mission_title') is-invalid @enderror" 
                                   placeholder="Enter mission title">
                            @error('form.mission_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
    </div>

                        <div class="form-group">
                            <label for="form.mission_description">Mission Description <span class="text-danger">*</span></label>
                            <textarea wire:model="form.mission_description" 
                                      class="form-control @error('form.mission_description') is-invalid @enderror" 
                                      rows="4" placeholder="Enter mission description"></textarea>
                            @error('form.mission_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                        
                        <div class="form-group">
                            <label for="form.mission_icon">Mission Icon</label>
                            <div class="input-group">
                                <input type="text" wire:model="form.mission_icon" 
                                       class="form-control @error('form.mission_icon') is-invalid @enderror" 
                                       placeholder="Select an icon" readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            wire:click="openIconDropdown('mission')">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if($form['mission_icon'])
                                        <button type="button" class="btn btn-outline-danger" 
                                                wire:click="clearIcon('mission')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                    </div>
                </div>
                            @if($form['mission_icon'])
                                <div class="mt-2">
                                    <small class="text-muted">Selected: </small>
                                    <i class="{{ $form['mission_icon'] }} text-primary"></i>
                                    <code class="ml-2">{{ $form['mission_icon'] }}</code>
            </div>
                            @endif
                            @error('form.mission_icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
        </div>
    </div>

                        <div class="col-md-6">
                        <h6 class="text-info mb-3">
                            <i class="fas fa-eye mr-2"></i>Vision
                        </h6>
                            <div class="form-group">
                            <label for="form.vision_title">Vision Title <span class="text-danger">*</span></label>
                            <input type="text" wire:model="form.vision_title" 
                                   class="form-control @error('form.vision_title') is-invalid @enderror" 
                                   placeholder="Enter vision title">
                            @error('form.vision_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        
                            <div class="form-group">
                            <label for="form.vision_description">Vision Description <span class="text-danger">*</span></label>
                            <textarea wire:model="form.vision_description" 
                                      class="form-control @error('form.vision_description') is-invalid @enderror" 
                                      rows="4" placeholder="Enter vision description"></textarea>
                            @error('form.vision_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                            <div class="form-group">
                            <label for="form.vision_icon">Vision Icon</label>
                            <div class="input-group">
                                <input type="text" wire:model="form.vision_icon" 
                                       class="form-control @error('form.vision_icon') is-invalid @enderror" 
                                       placeholder="Select an icon" readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            wire:click="openIconDropdown('vision')">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if($form['vision_icon'])
                                        <button type="button" class="btn btn-outline-danger" 
                                                wire:click="clearIcon('vision')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                            </div>
                            </div>
                            @if($form['vision_icon'])
                                <div class="mt-2">
                                    <small class="text-muted">Selected: </small>
                                    <i class="{{ $form['vision_icon'] }} text-primary"></i>
                                    <code class="ml-2">{{ $form['vision_icon'] }}</code>
                                </div>
                            @endif
                            @error('form.vision_icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <div class="form-check">
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
                            <small class="form-text text-muted">Uncheck to hide Mission & Vision from the website</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Save Mission & Vision
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <!-- Icon Selection Modal -->
    @if($showIconDropdown)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-icons mr-2"></i>Select Icon for {{ ucfirst($selectedIconField) }}
                        </h5>
                        <button type="button" class="close" wire:click="closeIconDropdown">
                            <span>&times;</span>
                        </button>
                                        </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model="iconSearch" 
                                   class="form-control" 
                                   placeholder="Search icons by name or class...">
                                    </div>
                        
                        <div style="max-height: 400px; overflow-y: auto;">
                            @foreach($this->getFilteredIcons() as $iconClass => $iconName)
                                <div class="icon-option-list" 
                                     wire:click="selectIcon('{{ $iconClass }}')"
                                     style="cursor: pointer; transition: all 0.2s; padding: 10px; border: 1px solid #e9ecef; margin-bottom: 5px; border-radius: 5px;">
                                    <div class="d-flex align-items-center">
                                        <i class="{{ $iconClass }} fa-lg text-primary mr-3"></i>
                                        <div class="flex-grow-1">
                                            <strong>{{ $iconName }}</strong>
                                            <br>
                                            <code class="small text-muted">{{ $iconClass }}</code>
                                        </div>
                                    </div>
                                    </div>
                            @endforeach
                            
                            @if(empty($this->getFilteredIcons()))
                                <div class="text-center py-4">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No icons found matching "{{ $iconSearch }}"</p>
                                        </div>
                            @endif
            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeIconDropdown">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .icon-option-list:hover {
            background-color: #f8f9fa;
            border-color: #007bff;
            transform: translateX(5px);
        }
        
        .icon-option-list {
            transition: all 0.2s ease;
        }
    </style>
</div>