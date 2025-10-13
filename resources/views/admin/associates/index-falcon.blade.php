@extends('admin.layout-falcon')

@section('title', 'Associates Management')

@section('content')
<div class="row">
    <!-- Header Card -->
    <div class="col-12 mb-4">
        <div class="falcon-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="card-title mb-1">Associates Management</h2>
                        <p class="text-muted mb-0">Manage our associates and partners</p>
                    </div>
                    <a href="{{ route('admin.associates.create') }}" class="btn btn-falcon-primary">
                        <i class="fas fa-plus me-2"></i>
                        Add New Associate
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="falcon-card">
            <div class="card-body text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-handshake text-primary fa-lg"></i>
                </div>
                <h3 class="mb-1">{{ $associates->total() }}</h3>
                <p class="text-muted mb-0">Total Associates</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="falcon-card">
            <div class="card-body text-center">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-check-circle text-success fa-lg"></i>
                </div>
                <h3 class="mb-1">{{ $associates->where('is_active', true)->count() }}</h3>
                <p class="text-muted mb-0">Active</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="falcon-card">
            <div class="card-body text-center">
                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-clock text-warning fa-lg"></i>
                </div>
                <h3 class="mb-1">{{ $associates->where('is_active', false)->count() }}</h3>
                <p class="text-muted mb-0">Inactive</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="falcon-card">
            <div class="card-body text-center">
                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-star text-info fa-lg"></i>
                </div>
                <h3 class="mb-1">{{ $associates->where('sort_order', '<=', 5)->count() }}</h3>
                <p class="text-muted mb-0">Featured</p>
            </div>
        </div>
    </div>

    <!-- Associates Table -->
    <div class="col-12">
        <div class="falcon-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">All Associates</h5>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search associates..." id="searchInput">
                        </div>
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-secondary btn-sm" onclick="exportData()">
                                <i class="fas fa-download me-1"></i>
                                Export
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="refreshTable()">
                                <i class="fas fa-sync-alt me-1"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if($associates->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="associatesTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                        </div>
                                    </th>
                                    <th class="border-0">Logo</th>
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Sort Order</th>
                                    <th class="border-0">Created</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($associates as $associate)
                                    <tr data-associate-id="{{ $associate->id }}">
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input row-checkbox" type="checkbox" value="{{ $associate->id }}">
                                            </div>
                                        </td>
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
                                                <span class="badge badge-falcon-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge badge-falcon-secondary">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-falcon-primary">{{ $associate->sort_order }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $associate->created_at->format('M d, Y') }}</small>
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
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Associates Found</h4>
                        <p class="text-muted mb-4">Get started by adding your first associate.</p>
                        <a href="{{ route('admin.associates.create') }}" class="btn btn-falcon-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add New Associate
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Delete Associate
                </h5>
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
                <button type="button" class="btn btn-falcon-secondary" data-bs-dismiss="modal">Cancel</button>
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

<!-- Bulk Actions Modal -->
<div class="modal fade" id="bulkActionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>What would you like to do with the selected associates?</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-falcon-primary" onclick="bulkActivate()">
                        <i class="fas fa-check-circle me-2"></i>
                        Activate Selected
                    </button>
                    <button class="btn btn-falcon-secondary" onclick="bulkDeactivate()">
                        <i class="fas fa-times-circle me-2"></i>
                        Deactivate Selected
                    </button>
                    <button class="btn btn-danger" onclick="bulkDelete()">
                        <i class="fas fa-trash me-2"></i>
                        Delete Selected
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Table Enhancements */
.falcon-table .table tbody tr {
    transition: all 0.2s ease;
}

.falcon-table .table tbody tr:hover {
    background-color: rgba(44, 123, 229, 0.05);
}

.falcon-table .table tbody tr.selected {
    background-color: rgba(44, 123, 229, 0.1);
}

/* Badge Enhancements */
.badge-falcon-primary {
    background-color: var(--falcon-primary);
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: var(--falcon-border-radius);
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-falcon-success {
    background-color: var(--falcon-success);
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: var(--falcon-border-radius);
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-falcon-secondary {
    background-color: var(--falcon-secondary);
    color: #fff;
    padding: 0.375rem 0.75rem;
    border-radius: var(--falcon-border-radius);
    font-size: 0.75rem;
    font-weight: 500;
}

/* Search Input */
.input-group .form-control:focus {
    border-color: var(--falcon-primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
}

/* Loading States */
.table-loading {
    position: relative;
}

.table-loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

/* Animations */
.fade-in {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.slide-in {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from { transform: translateX(-100%); }
    to { transform: translateX(0); }
}
</style>
@endpush

@push('scripts')
<script>
// Table functionality
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkActionsBtn = document.getElementById('bulkActionsBtn');
    
    if (checkedBoxes.length > 0) {
        if (bulkActionsBtn) {
            bulkActionsBtn.style.display = 'inline-block';
            bulkActionsBtn.innerHTML = `<i class="fas fa-tasks me-1"></i>Bulk Actions (${checkedBoxes.length})`;
        }
    } else {
        if (bulkActionsBtn) {
            bulkActionsBtn.style.display = 'none';
        }
    }
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#associatesTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Delete functionality
function deleteAssociate(id, name) {
    document.getElementById('associateName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/associates/${id}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Bulk actions
function bulkActivate() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length > 0) {
        // Implement bulk activate logic
        console.log('Bulk activate triggered');
    }
}

function bulkDeactivate() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length > 0) {
        // Implement bulk deactivate logic
        console.log('Bulk deactivate triggered');
    }
}

function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length > 0) {
        if (confirm(`Are you sure you want to delete ${checkedBoxes.length} selected associates?`)) {
            // Implement bulk delete logic
            console.log('Bulk delete triggered');
        }
    }
}

// Export functionality
function exportData() {
    // Implement export logic
    console.log('Export triggered');
}

// Refresh functionality
function refreshTable() {
    window.location.reload();
}

// Add loading animation to cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.falcon-card');
    cards.forEach(card => {
        card.classList.add('fade-in');
    });
    
    // Add event listeners to checkboxes
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
});

// Auto-hide alerts
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


