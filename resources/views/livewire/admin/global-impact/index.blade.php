<div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-globe mr-2"></i>Global Impact Settings
            </h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="form-group">
                    <label for="form.title">Title <span class="text-danger">*</span></label>
                    <input type="text" wire:model="form.title" 
                           class="form-control @error('form.title') is-invalid @enderror" 
                           placeholder="Enter section title">
                    @error('form.title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="form.subtitle">Subtitle <span class="text-danger">*</span></label>
                    <textarea wire:model="form.subtitle" 
                              class="form-control @error('form.subtitle') is-invalid @enderror" 
                              rows="2" placeholder="Enter section subtitle"></textarea>
                    @error('form.subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Statistics</label>
                    <div class="row">
                        @foreach($form['stats'] as $index => $stat)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Statistic {{ $index + 1 }}</h6>
                                        @if(count($form['stats']) > 1)
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    wire:click="removeStat({{ $index }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Number <span class="text-danger">*</span></label>
                                                    <input type="text" wire:model="form.stats.{{ $index }}.number" 
                                                           class="form-control @error('form.stats.'.$index.'.number') is-invalid @enderror" 
                                                           placeholder="e.g., 500+">
                                                    @error('form.stats.'.$index.'.number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Label <span class="text-danger">*</span></label>
                                                    <input type="text" wire:model="form.stats.{{ $index }}.label" 
                                                           class="form-control @error('form.stats.'.$index.'.label') is-invalid @enderror" 
                                                           placeholder="e.g., Movies Published">
                                                    @error('form.stats.'.$index.'.label')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Icon</label>
                                            <div class="input-group">
                                                <input type="text" wire:model="form.stats.{{ $index }}.icon" 
                                                       class="form-control @error('form.stats.'.$index.'.icon') is-invalid @enderror" 
                                                       placeholder="Select an icon" readonly>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" 
                                                            wire:click="openIconDropdown({{ $index }})">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                    @if($form['stats'][$index]['icon'])
                                                        <button type="button" class="btn btn-outline-danger" 
                                                                wire:click="clearIcon({{ $index }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($form['stats'][$index]['icon'])
                                                <div class="mt-2">
                                                    <small class="text-muted">Selected: </small>
                                                    <i class="{{ $form['stats'][$index]['icon'] }} text-primary"></i>
                                                    <code class="ml-2">{{ $form['stats'][$index]['icon'] }}</code>
                                                </div>
                                            @endif
                                            @error('form.stats.'.$index.'.icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if(count($form['stats']) < 6)
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-primary" wire:click="addStat">
                                <i class="fas fa-plus mr-1"></i>Add Statistic
                            </button>
                        </div>
                    @endif
                </div>
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-save mr-1"></i>Save Global Impact Settings
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
                            <i class="fas fa-icons mr-2"></i>Select Icon for Statistic {{ $selectedStatIndex + 1 }}
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
