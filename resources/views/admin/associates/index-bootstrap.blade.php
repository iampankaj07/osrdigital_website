@extends('admin.layout-bootstrap')

@section('title', 'Associates Management')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="card-title mb-1">Associates Management</h2>
                            <p class="text-muted mb-0">Manage our associates and partners</p>
                        </div>
                        <a href="{{ route('admin.associates.create') }}" class="btn btn-dark">
                            <i class="fas fa-plus me-2"></i>
                            Add New Associate
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Associates Table -->
    @if($associates->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">All Associates</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Logo</th>
                                        <th class="border-0">Name</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Sort Order</th>
                                        <th class="border-0 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($associates as $associate)
                                        <tr>
                                            <td>
                                                @if($associate->logo_url)
                                                    <img src="{{ $associate->logo_url }}" alt="{{ $associate->name }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-medium">{{ $associate->name }}</div>
                                                    @if($associate->description)
                                                        <small class="text-muted">{{ Str::limit($associate->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($associate->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $associate->sort_order }}</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.associates.show', $associate) }}" class="btn btn-outline-secondary btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.associates.edit', $associate) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" onclick="deleteAssociate({{ $associate->id }}, '{{ $associate->name }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($associates->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Showing {{ $associates->firstItem() }} to {{ $associates->lastItem() }} of {{ $associates->total() }} results
                                </div>
                                <div>
                                    {{ $associates->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Associates Found</h4>
                        <p class="text-muted mb-4">Get started by adding your first associate.</p>
                        <a href="{{ route('admin.associates.create') }}" class="btn btn-dark">
                            <i class="fas fa-plus me-2"></i>
                            Add New Associate
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Associate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-warning fa-2x me-3"></i>
                    <div>
                        <p class="mb-0">Are you sure you want to delete <strong id="associateName"></strong>?</p>
                        <small class="text-muted">This action cannot be undone.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteAssociate(id, name) {
    document.getElementById('associateName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/associates/${id}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush


