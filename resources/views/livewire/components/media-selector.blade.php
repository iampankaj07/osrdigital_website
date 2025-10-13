<div>
    @if($showModal)
        <!-- Media Selector Modal -->
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);"
             wire:click.self="closeModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Media</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <style>
                        .media-item:hover {
                            border-color: #007bff !important;
                            transform: translateY(-2px);
                            transition: all 0.2s ease;
                        }
                        </style>
                        @if(count($mediaItems) > 0)
                            <div class="row">
                                @foreach($mediaItems as $media)
                                    <div class="col-md-2 col-sm-3 col-4 mb-3">
                                        <div class="card h-100 media-item"
                                             style="cursor: pointer; {{ $selectedMediaId == $media->id ? 'border-color: #007bff; border-width: 2px;' : '' }}"
                                             wire:click="selectMedia({{ $media->id }})">
                                            <div class="card-body p-1">
                                                @if(str_starts_with($media->mime_type, 'image/'))
                                                    <img src="{{ $media->getFullUrl() }}"
                                                         alt="{{ $media->name }}"
                                                         class="img-fluid rounded"
                                                         style="width: 100%; height: 100px; object-fit: cover;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center"
                                                         style="height: 100px; background-color: #f8f9fa;">
                                                        <i class="fas fa-file text-muted fa-2x"></i>
                                                    </div>
                                                @endif
                                                <div class="text-center mt-1">
                                                    <small class="text-truncate d-block" title="{{ $media->name }}">
                                                        {{ Str::limit($media->name, 15) }}
                                                    </small>
                                                    <small class="text-muted">{{ $media->human_readable_size }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No media files available</p>
                                <a href="{{ route('admin.media-library.index') }}" class="btn btn-primary" target="_blank">
                                    Upload Media
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
