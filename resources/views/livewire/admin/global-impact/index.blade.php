<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Global Impact Settings</h1>
            <p class="text-muted small mb-0">Configure statistics and impact metrics for the homepage</p>
        </div>
        <button type="submit" form="global-impact-form" class="btn btn-dark btn-sm">
            <i class="fas fa-save mr-1"></i>
            Save Settings
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form id="global-impact-form" wire:submit.prevent="save">
        <!-- Section Content -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-4">
                    <i class="fas fa-edit mr-2 text-primary"></i>
                    Section Content
                </h5>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label for="form.title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" wire:model="form.title" 
                                   class="form-control form-control-lg @error('form.title') is-invalid @enderror" 
                                   placeholder="Enter section title">
                            @error('form.title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <label for="form.subtitle" class="form-label fw-semibold">Subtitle <span class="text-danger">*</span></label>
                            <textarea wire:model="form.subtitle" 
                                      class="form-control @error('form.subtitle') is-invalid @enderror" 
                                      rows="3" placeholder="Enter section subtitle"></textarea>
                            @error('form.subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Statistics
                    </h5>
                    @if(count($form['stats']) < 6)
                        <button type="button" class="btn btn-outline-primary btn-sm" wire:click="addStat">
                            <i class="fas fa-plus mr-1"></i>
                            Add Statistic
                        </button>
                    @endif
                </div>

                <div class="row">
                    @foreach($form['stats'] as $index => $stat)
                        <div class="col-lg-6 mb-4">
                            <div class="border rounded-lg p-4 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 text-muted">Statistic {{ $index + 1 }}</h6>
                                    @if(count($form['stats']) > 1)
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                wire:click="removeStat({{ $index }})"
                                                title="Remove statistic">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-semibold small">Number <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="form.stats.{{ $index }}.number" 
                                                   class="form-control @error('form.stats.'.$index.'.number') is-invalid @enderror" 
                                                   placeholder="e.g., 500+">
                                            @error('form.stats.'.$index.'.number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-semibold small">Label <span class="text-danger">*</span></label>
                                            <input type="text" wire:model="form.stats.{{ $index }}.label" 
                                                   class="form-control @error('form.stats.'.$index.'.label') is-invalid @enderror" 
                                                   placeholder="e.g., Movies Published">
                                            @error('form.stats.'.$index.'.label')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-0">
                                    <label class="form-label fw-semibold small">Icon</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="form.stats.{{ $index }}.icon" 
                                               class="form-control @error('form.stats.'.$index.'.icon') is-invalid @enderror" 
                                               placeholder="Select an icon" readonly>
                                        <button type="button" class="btn btn-outline-secondary" 
                                                wire:click="openIconDropdown({{ $index }})"
                                                title="Select icon">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if($form['stats'][$index]['icon'])
                                            <button type="button" class="btn btn-outline-danger" 
                                                    wire:click="clearIcon({{ $index }})"
                                                    title="Clear icon">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                    @if($form['stats'][$index]['icon'])
                                        <div class="mt-2 d-flex align-items-center">
                                            <small class="text-muted me-2">Preview:</small>
                                            <i class="{{ $form['stats'][$index]['icon'] }} text-primary me-2"></i>
                                            <code class="small">{{ $form['stats'][$index]['icon'] }}</code>
                                        </div>
                                    @endif
                                    @error('form.stats.'.$index.'.icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>

    <!-- Icon Selection Modal -->
    @if($showIconDropdown)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white border-0">
                        <h5 class="modal-title mb-0">
                            <i class="fas fa-icons mr-2"></i>Select Icon for Statistic {{ $selectedStatIndex + 1 }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeIconDropdown"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" wire:model="iconSearch" 
                                       class="form-control border-start-0" 
                                       placeholder="Search icons by name or class...">
                            </div>
                        </div>
                        
                        <div class="icon-grid" style="max-height: 400px; overflow-y: auto;">
                            @foreach($this->getFilteredIcons() as $iconClass => $iconName)
                                <div class="icon-option" 
                                     wire:click="selectIcon('{{ $iconClass }}')"
                                     style="cursor: pointer; transition: all 0.2s; padding: 15px; border: 1px solid #e9ecef; margin-bottom: 8px; border-radius: 8px; background: #fff;">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-preview me-3">
                                            <i class="{{ $iconClass }} fa-lg text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold text-dark">{{ $iconName }}</div>
                                            <code class="small text-muted">{{ $iconClass }}</code>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if(empty($this->getFilteredIcons()))
                                <div class="text-center py-5">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No icons found</h6>
                                    <p class="text-muted small">Try searching with different keywords</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeIconDropdown">
                            <i class="fas fa-times mr-1"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .icon-option:hover {
            background-color: #f8f9fa !important;
            border-color: #007bff !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15) !important;
        }
        
        .icon-option {
            transition: all 0.2s ease;
        }

        .icon-option:hover .icon-preview i {
            transform: scale(1.1);
        }

        .icon-preview i {
            transition: transform 0.2s ease;
        }

        .form-control-lg {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .rounded-lg {
            border-radius: 0.75rem !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
</div>
