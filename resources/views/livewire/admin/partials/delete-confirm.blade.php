@if($confirmingDeleteId)
    <!-- Modal Backdrop -->
    <div class="modal-backdrop fade show" style="display: block; z-index: 1040;"></div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade show d-block" tabindex="-1" role="dialog" style="display: block; z-index: 1050;" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" aria-label="Close" wire:click="cancelDelete" style="cursor: pointer;"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-3 text-gray-700">Are you sure you want to delete this @if($confirmingDeleteType) <strong>{{ $confirmingDeleteType }}</strong> @else item @endif? This action cannot be undone.</p>
                    <div class="alert alert-warning small mb-0" role="alert">
                        <i class="fas fa-info-circle mr-1"></i>
                        All associated data referencing this @if($confirmingDeleteType) {{ $confirmingDeleteType }} @else item @endif may become unavailable.
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" wire:click="cancelDelete">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" wire:click="performDelete">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

