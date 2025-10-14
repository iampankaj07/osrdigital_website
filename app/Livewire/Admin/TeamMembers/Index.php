<?php

namespace App\Livewire\Admin\TeamMembers;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TeamMember;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'name' => '',
        'position' => '',
        'department' => '',
        'avatar' => '',
        'linkedin' => '',
        'twitter' => '',
        'email' => '',
        'sort_order' => 0,
        'is_active' => true,
    ];

    // FilePond uploads
    public $filepondUploads = [];

    // Media library selection
    public $selectedMediaId = null;
    public $selectedMediaUrl = null;

    // Upload method preference
    public $uploadMethod = 'filepond'; // 'filepond' or 'media_library'

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
    ];

    protected $listeners = [
        'mediaSelected' => 'handleMediaSelection',
        'fileUploaded' => 'handleFileUploaded',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->isCreating = true;
        $this->editingId = null;
        $this->reset('form');
        $this->resetUploadStates();
        $this->form['sort_order'] = TeamMember::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $teamMember = TeamMember::findOrFail($id);

        $this->form = [
            'name' => $teamMember->name,
            'position' => $teamMember->position,
            'department' => $teamMember->department,
            'avatar' => $teamMember->avatar,
            'linkedin' => $teamMember->linkedin,
            'twitter' => $teamMember->twitter,
            'email' => $teamMember->email,
            'sort_order' => $teamMember->sort_order,
            'is_active' => $teamMember->is_active,
        ];

        $this->resetUploadStates();

        // Load existing media selection if available
        if ($teamMember->media_id) {
            $this->selectedMediaId = $teamMember->media_id;
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($teamMember->media_id);
            if ($media) {
                $this->selectedMediaUrl = $media->getFullUrl();
                $this->uploadMethod = 'media_library';
            }
        } else {
            // Default to filepond for existing members without media
            $this->uploadMethod = 'filepond';
        }
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->reset('form');
        $this->resetUploadStates();
    }

    public function store()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.position' => 'required|string|max:255',
            'form.department' => 'nullable|string|max:255',
            'form.avatar' => 'nullable|string|max:255',
            'form.linkedin' => 'nullable|url|max:255',
            'form.twitter' => 'nullable|url|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        $teamMemberData = $this->form;

        // Create team member first
        $teamMember = TeamMember::create($teamMemberData);

        // Handle media uploads after team member creation
        if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
            $teamMember->update(['media_id' => $this->selectedMediaId]);
        } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
            // Process FilePond uploads using Spatie Media Library
            $user = Auth::user();
            foreach ($this->filepondUploads as $upload) {
                $media = $user->addMedia($upload->getRealPath())
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $teamMember->update(['media_id' => $media->id]);
                break; // Only take the first file for avatar
            }
        }

        $this->isCreating = false;
        $this->reset('form');
        $this->resetUploadStates();

        session()->flash('success', 'Team Member created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.position' => 'required|string|max:255',
            'form.department' => 'nullable|string|max:255',
            'form.avatar' => 'nullable|string|max:255',
            'form.linkedin' => 'nullable|url|max:255',
            'form.twitter' => 'nullable|url|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        if (!$this->editingId) {
            session()->flash('error', 'No team member selected for editing.');
            return;
        }

        $teamMember = TeamMember::findOrFail($this->editingId);
        $teamMemberData = $this->form;

        // Update team member first
        $teamMember->update($teamMemberData);

        // Handle media uploads after team member update
        try {
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $teamMember->update(['media_id' => $this->selectedMediaId]);
            } elseif ($this->uploadMethod === 'filepond' && is_array($this->filepondUploads) && count($this->filepondUploads) > 0) {
                // Process FilePond uploads using Spatie Media Library (same as TrustedPartners)
                $user = Auth::user();
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $teamMember->update(['media_id' => $media->id]);
                    break; // Only take the first file for avatar
                }
            }
        } catch (\Exception $e) {
            Log::error('Media upload error in team member update: ' . $e->getMessage());
            session()->flash('error', 'Error uploading file: ' . $e->getMessage());
            return;
        }

        $this->editingId = null;
        $this->reset('form');
        $this->resetUploadStates();

        // Dispatch an event to refresh the component
        $this->dispatch('teamMemberUpdated');

        session()->flash('success', 'Team Member updated successfully!');
    }

    public function deleteTeamMember($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $teamMember->delete(); // This calls Eloquent's delete method, not our method

        session()->flash('success', 'Team Member deleted successfully!');
    }

    public function toggleActive($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $teamMember->update(['is_active' => !$teamMember->is_active]);

        session()->flash('success', 'Team Member status updated successfully!');
    }

    public function resetUploadStates()
    {
        // Clear FilePond uploads
        $this->filepondUploads = [];

        // Clear media library selection
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;

        // Reset to default upload method
        $this->uploadMethod = 'filepond';

        // Dispatch event to reset FilePond components
        $this->dispatch('reset-filepond');
    }

    // Method to handle FilePond file removal
    public function updatedFilepondUploads()
    {
        // This method is called when filepondUploads is updated
        // Can be used for additional processing if needed
    }

    // Debug method to check component state
    public function debugState()
    {
        Log::info('TeamMembers Component Debug State', [
            'editingId' => $this->editingId,
            'isCreating' => $this->isCreating,
            'form' => $this->form,
            'uploadMethod' => $this->uploadMethod,
            'filepondUploads_count' => is_array($this->filepondUploads) ? count($this->filepondUploads) : 0,
            'selectedMediaId' => $this->selectedMediaId,
            'selectedMediaUrl' => $this->selectedMediaUrl,
        ]);
    }    public function validateUploadedFile($filename)
    {
        return true;
    }

    public function handleMediaSelection($data)
    {
        if (isset($data['id']) && isset($data['url'])) {
            $this->selectedMediaId = $data['id'];
            $this->selectedMediaUrl = $data['url'];

            // Update upload method to media_library when media is selected
            $this->uploadMethod = 'media_library';
        }
    }

    public function clearSelectedMedia()
    {
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
    }

    public function handleFileUploaded()
    {
        // This method can be called when FilePond finishes uploading
        // The component will automatically refresh when filepondUploads changes
    }

    public function render()
    {
        $teamMembers = TeamMember::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('position', 'like', '%' . $this->search . '%')
                      ->orWhere('department', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.team-members.index', compact('teamMembers'));
    }
}
