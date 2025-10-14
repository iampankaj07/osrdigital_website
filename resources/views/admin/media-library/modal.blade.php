<!-- Media Library Modal -->
<div class="modal fade" id="mediaLibraryModal" tabindex="-1" aria-labelledby="mediaLibraryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaLibraryModalLabel">
                    <i class="fas fa-folder-open mr-2"></i>
                    Media Library
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div id="mediaLibraryContainer">
                    <!-- Loading state -->
                    <div class="text-center py-4" id="mediaLibraryLoading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading media library...</p>
                    </div>

                    <!-- Media grid will be loaded here -->
                    <div id="mediaLibraryContent" style="display: none;">
                        <div class="row" id="mediaLibraryGrid">
                            <!-- Media items will be populated here -->
                        </div>
                    </div>

                    <!-- Empty state -->
                    <div id="mediaLibraryEmpty" class="text-center py-4" style="display: none;">
                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No media files found</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="selectMediaButton" disabled>
                    <i class="fas fa-check mr-1"></i>
                    Select Media
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.media-item {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    border-radius: 8px;
    overflow: hidden;
}

.media-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.media-item.selected {
    border-color: #007bff;
    background-color: #e3f2fd;
}

.media-item img {
    transition: transform 0.3s ease;
}

.media-item:hover img {
    transform: scale(1.05);
}

.media-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 10px;
}

.media-item:hover .media-overlay {
    opacity: 1;
}

.media-info {
    color: white;
    text-align: center;
    font-size: 0.8rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedMediaId = null;
    let selectedMediaUrl = null;

    // Initialize modal
    const modalElement = document.getElementById('mediaLibraryModal');
    if (modalElement && typeof bootstrap !== 'undefined') {
        window.mediaLibraryModal = new bootstrap.Modal(modalElement);
    } else if (modalElement && typeof $ !== 'undefined') {
        // Fallback to jQuery if Bootstrap 5 is not available
        window.mediaLibraryModal = {
            show: () => $('#mediaLibraryModal').modal('show'),
            hide: () => $('#mediaLibraryModal').modal('hide')
        };
    }

    // Load media library content when modal is shown
    if (modalElement) {
        modalElement.addEventListener('show.bs.modal', function() {
            loadMediaLibrary();
        });

        // Reset selection when modal is hidden
        modalElement.addEventListener('hidden.bs.modal', function() {
            resetSelection();
        });
    }

    // jQuery fallback for older Bootstrap versions
    $('#mediaLibraryModal').on('show.bs.modal', function() {
        loadMediaLibrary();
    }).on('hidden.bs.modal', function() {
        resetSelection();
    });

    function loadMediaLibrary() {
        const loading = document.getElementById('mediaLibraryLoading');
        const content = document.getElementById('mediaLibraryContent');
        const empty = document.getElementById('mediaLibraryEmpty');
        const grid = document.getElementById('mediaLibraryGrid');

        if (loading) loading.style.display = 'block';
        if (content) content.style.display = 'none';
        if (empty) empty.style.display = 'none';

        // Fetch media from the API
        fetch('/admin/media-library/api')
            .then(response => response.json())
            .then(data => {
                if (loading) loading.style.display = 'none';

                if (data.media && data.media.length > 0) {
                    renderMediaGrid(data.media, grid);
                    if (content) content.style.display = 'block';
                } else {
                    if (empty) empty.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error loading media library:', error);
                if (loading) loading.style.display = 'none';
                if (empty) empty.style.display = 'block';
            });
    }

    function renderMediaGrid(mediaItems, grid) {
        if (!grid) return;

        grid.innerHTML = '';

        mediaItems.forEach(item => {
            const mediaElement = createMediaElement(item);
            grid.appendChild(mediaElement);
        });
    }

    function createMediaElement(item) {
        const col = document.createElement('div');
        col.className = 'col-md-3 col-sm-4 col-6 mb-3';

        col.innerHTML = `
            <div class="media-item p-2" data-id="${item.id}" data-url="${item.original_url}" onclick="selectMedia(${item.id}, '${item.original_url}')">
                <div class="position-relative" style="height: 120px; overflow: hidden; border-radius: 6px;">
                    <img src="${item.original_url}" alt="${item.name || 'Media'}" class="w-100 h-100" style="object-fit: cover;">
                    <div class="media-overlay">
                        <div class="media-info">
                            <div class="font-weight-bold">${item.name || 'Untitled'}</div>
                            <div>${formatFileSize(item.size || 0)}</div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        return col;
    }

    window.selectMedia = function(id, url) {
        // Remove previous selection
        document.querySelectorAll('.media-item').forEach(item => {
            item.classList.remove('selected');
        });

        // Add selection to clicked item
        const mediaItem = document.querySelector(`[data-id="${id}"]`);
        if (mediaItem) {
            mediaItem.classList.add('selected');
        }

        selectedMediaId = id;
        selectedMediaUrl = url;

        // Enable select button
        const selectButton = document.getElementById('selectMediaButton');
        if (selectButton) {
            selectButton.disabled = false;
        }
    };

    function resetSelection() {
        selectedMediaId = null;
        selectedMediaUrl = null;

        // Remove all selections
        document.querySelectorAll('.media-item').forEach(item => {
            item.classList.remove('selected');
        });

        // Disable select button
        const selectButton = document.getElementById('selectMediaButton');
        if (selectButton) {
            selectButton.disabled = true;
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Handle select button click
    document.getElementById('selectMediaButton').addEventListener('click', function() {
        if (selectedMediaId && selectedMediaUrl) {
            // Dispatch custom event with selected media
            const event = new CustomEvent('media-selected', {
                detail: {
                    id: selectedMediaId,
                    url: selectedMediaUrl
                }
            });
            window.dispatchEvent(event);

            // Also hide the modal
            if (typeof window.mediaLibraryModal !== 'undefined') {
                window.mediaLibraryModal.hide();
            }
        }
    });
});
</script>
@endpush
