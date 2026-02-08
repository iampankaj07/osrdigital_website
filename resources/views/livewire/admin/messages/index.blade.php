<div>
    <style>
        /* Slide Panel Styles (simple) */
        .slide-panel-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 1040; }
        .slide-panel { position: fixed; top: 0; right: 0; bottom: 0; width: 720px; max-width: 100%; background: #fff; z-index: 1050; overflow-y: auto; }
        .slide-panel-header { padding: 1rem; border-bottom: 1px solid #e9ecef; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; background:#fff; }
        .slide-panel-body { padding:1rem; }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1 font-weight-normal">Messages</h1>
            <p class="text-muted small mb-0">View and manage messages from visitors</p>
        </div>
        <button wire:click="create" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>New Message</button>
    </div>

    <!-- Filters -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body py-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label class="small text-muted mb-1">Search</label>
                    <input type="text" wire:model.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search by name, email, subject...">
                </div>
                <div class="col-md-2">
                    <label class="small text-muted mb-1">Per Page</label>
                    <select wire:model="perPage" class="form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="small text-muted mb-1">&nbsp;</label>
                    <button wire:click="$refresh" class="btn btn-outline-secondary btn-sm w-100"><i class="fas fa-sync-alt"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('name')" style="cursor:pointer">Name</th>
                            <th wire:click="sortBy('email')" style="cursor:pointer">Email</th>
                            <th wire:click="sortBy('subject')" style="cursor:pointer">Subject</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr>
                                <td>{{ $message->name ?? '—' }}</td>
                                <td>{{ $message->email ?? '—' }}</td>
                                <td class="text-truncate" style="max-width:350px">{{ Str::limit($message->subject ?? $message->body, 80) }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $message->status === 'new' ? 'info' : ($message->status === 'read' ? 'success' : 'secondary') }}">{{ ucfirst($message->status) }}</span>
                                </td>
                                <td class="text-right">
                                    <button wire:click="edit({{ $message->id }})" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button>
                                    <div class="btn-group btn-group-sm ml-1" role="group">
                                        <button wire:click="changeStatus({{ $message->id }}, 'read')" class="btn btn-sm btn-outline-success">Mark Read</button>
                                        <button wire:click="changeStatus({{ $message->id }}, 'archived')" class="btn btn-sm btn-outline-warning">Archive</button>
                                    </div>
                                    <button wire:click="delete({{ $message->id }})" class="btn btn-sm btn-outline-danger ml-1"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">No messages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
                <div class="text-muted small">Showing {{ $messages->firstItem() ?? 0 }} to {{ $messages->lastItem() ?? 0 }} of {{ $messages->total() }} messages</div>
                <div>{{ $messages->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Slide Panel for create/edit/view -->
    @if($showSlidePanel)
        <div class="slide-panel-backdrop" wire:click="closeSlidePanel"></div>
        <div class="slide-panel">
            <div class="slide-panel-header">
                <h5 class="mb-0">@if($isCreating) Create Message @else View / Edit Message @endif</h5>
                <button type="button" wire:click="closeSlidePanel" class="btn btn-sm btn-link p-0"><i class="fas fa-times"></i></button>
            </div>
            <div class="slide-panel-body">
                <form wire:submit.prevent="{{ $isCreating ? 'store' : 'update' }}">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" wire:model="form.name" class="form-control @error('form.name') is-invalid @enderror">
                        @error('form.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" wire:model="form.email" class="form-control @error('form.email') is-invalid @enderror">
                        @error('form.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" wire:model="form.subject" class="form-control @error('form.subject') is-invalid @enderror">
                        @error('form.subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea rows="7" wire:model="form.body" class="form-control @error('form.body') is-invalid @enderror"></textarea>
                        @error('form.body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select wire:model="form.status" class="form-control">
                            <option value="new">New</option>
                            <option value="read">Read</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" wire:click="closeSlidePanel" class="btn btn-outline-secondary btn-sm mr-2">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">{{ $isCreating ? 'Create' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @script
    <script>
        $wire.on('close-panel-animation', () => {
            setTimeout(() => {
                $wire.finishClosing();
            }, 300);
        });

        Livewire.hook('morph.updated', ({ el, component }) => {
            const panel = el.querySelector('.slide-panel');
            if (panel && !panel.dataset.closingHandled) {
                panel.dataset.closingHandled = 'true';
                setTimeout(() => {
                    $wire.finishClosing();
                }, 300);
            }
        });
    </script>
    @endscript
</div>