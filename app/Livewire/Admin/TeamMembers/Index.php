<?php

namespace App\Livewire\Admin\TeamMembers;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;
use App\Models\TeamMember;
use App\Traits\DispatchesAlertEvents;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Livewire\Admin\Traits\WithDeleteConfirmation;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond, WithDeleteConfirmation, DispatchesAlertEvents;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $showSlidePanel = false;
    public $isClosing = false;
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
        'media_id' => null,
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
        $this->showSlidePanel = true;
    }

    public function resetUploadStates()
    {
        $this->filepondUploads = [];
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->uploadMethod = 'filepond';
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
            'media_id' => $teamMember->media_id,
        ];

        $this->resetUploadStates();

        // Load existing media selection
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
        $this->showSlidePanel = true;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->reset('form');
        $this->resetUploadStates();
        $this->showSlidePanel = false;
    }

    public function closeSlidePanel()
    {
        $this->isClosing = true;
        $this->dispatch('close-panel-animation');
    }

    public function finishClosing()
    {
        $this->showSlidePanel = false;
        $this->isClosing = false;
        $this->reset('form');
        $this->resetUploadStates();
        $this->editingId = null;
        $this->isCreating = false;
    }

    public function validateUploadedFile($filename)
    {
        return true;
    }

    public function handleMediaSelection($data)
    {
        // Log the data structure for debugging
        Log::info('Media selection data received:', ['data' => $data]);

        // Handle case where data is an indexed array containing the media data
        if (is_array($data) && isset($data[0]) && is_array($data[0])) {
            $data = $data[0];
        }

        // Add defensive programming to handle missing keys
        if (isset($data['mediaId'])) {
            $this->selectedMediaId = $data['mediaId'];
            $this->form['media_id'] = $data['mediaId'];
            Log::info('Media ID set to:', ['mediaId' => $data['mediaId']]);
        } else {
            Log::warning('mediaId not found in data:', ['data' => $data]);
        }

        if (isset($data['mediaUrl'])) {
            $this->selectedMediaUrl = $data['mediaUrl'];
            Log::info('Media URL set to:', ['mediaUrl' => $data['mediaUrl']]);
        } else {
            Log::warning('mediaUrl not found in data:', ['data' => $data]);
        }
    }

    public function openMediaSelector()
    {
        $this->dispatch('openMediaSelector');
    }

    public function clearSelectedMedia()
    {
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->form['media_id'] = null;
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

        try {
            $user = Auth::user();
            $memberData = $this->form;

            // Handle avatar upload based on method
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $memberData['media_id'] = $this->selectedMediaId;
                $memberData['avatar'] = null; // Clear avatar field when using media library
            } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
                // Process FilePond uploads
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $memberData['media_id'] = $media->id;
                    $memberData['avatar'] = null; // Clear avatar field when using FilePond
                    break; // Only take the first file for avatar
                }
            }

            TeamMember::create($memberData);

            $this->isCreating = false;
            $this->showSlidePanel = false;
            $this->reset('form');
            $this->resetUploadStates();

            $this->flashSuccess('Team Member created successfully!');

        } catch (\Exception $e) {
            $this->dispatchErrorEvent('Error creating team member: ' . $e->getMessage());

        }
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

        try {
            $user = Auth::user();
            $teamMember = TeamMember::findOrFail($this->editingId);
            $memberData = $this->form;

            // Handle avatar update based on method
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $memberData['media_id'] = $this->selectedMediaId;
                $memberData['avatar'] = null;
            } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
                // Process FilePond uploads
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $memberData['media_id'] = $media->id;
                    $memberData['avatar'] = null;
                    break;
                }
            }

            $teamMember->update($memberData);

            $this->editingId = null;
            $this->showSlidePanel = false;
            $this->reset('form');
            $this->resetUploadStates();

            $this->flashSuccess('Team Member updated successfully!');

        } catch (\Exception $e) {
            $this->dispatchErrorEvent('Error updating team member: ' . $e->getMessage());

        }
    }

    public function delete($id)
    {
        // Route legacy direct delete through confirmation abstraction
        $this->performActualDelete($id);
    }

    /**
     * Actual deletion logic separated so trait can call performActualDelete()
     */
    public function performActualDelete($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $name = $teamMember->name;
        $teamMember->delete();
        $this->flashDelete("Team Member '{$name}' has been successfully deleted.");
    }

    public function toggleActive($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $teamMember->update(['is_active' => !$teamMember->is_active]);

        $this->dispatchSuccessEvent('Team Member status updated successfully!');
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
