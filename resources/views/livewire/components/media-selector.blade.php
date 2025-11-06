<div>
    <style>
        .media-selector-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1060;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease-out;
        }

        .media-selector-modal {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            animation: slideInScale 0.3s ease-out;
            z-index: 1061;
        }

        .media-selector-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .media-selector-body {
            padding: 1rem 1.5rem;
            flex: 1;
            overflow-y: auto;
        }

        .media-selector-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
        }

        .media-item:hover {
            border-color: #007bff !important;
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }

        .media-item.selected {
            border-color: #007bff !important;
            border-width: 2px !important;
        }

        @keyframes slideInScale {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
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
    </style>

    @if($showModal)
        <!-- Media Selector Modal -->
        <div class="media-selector-backdrop" wire:click.self="closeModal" style="z-index: 1060;">
            <div class="media-selector-modal">
                <div class="media-selector-header">
                    <h5 class="mb-0">Select Media</h5>
                    <button type="button" class="btn btn-sm btn-link text-muted p-0" wire:click="closeModal" style="font-size: 1.5rem; line-height: 1;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="media-selector-body">
                    @if(count($mediaItems) > 0)
                        <div class="row g-2" style="max-height: 400px; overflow-y: auto;">
                            @foreach($mediaItems as $media)
                                <div class="col-4 col-md-3">
                                    <div class="card h-100 media-item"
                                         style="cursor: pointer; {{ $selectedMediaId == $media->id ? 'border-color: #007bff; border-width: 2px;' : '' }}"
                                         wire:click="selectMedia({{ $media->id }})">
                                        <div class="card-body p-2">
                                            @if(str_starts_with($media->mime_type, 'image/'))
                                                <img src="{{ $media->getFullUrl() }}"
                                                     alt="{{ $media->name }}"
                                                     class="img-fluid rounded"
                                                     style="width: 100%; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center"
                                                     style="height: 80px; background-color: #f8f9fa;">
                                                    <i class="fas fa-file text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="text-center mt-1">
                                                <small class="text-truncate d-block" title="{{ $media->name }}" style="font-size: 0.7rem;">
                                                    {{ Str::limit($media->name, 12) }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-images fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-2">No media files available</p>
                            <a href="{{ route('admin.media-library.index') }}" class="btn btn-primary btn-sm" target="_blank">
                                Upload Media
                            </a>
                        </div>
                    @endif
                </div>
                <div class="media-selector-footer">
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>