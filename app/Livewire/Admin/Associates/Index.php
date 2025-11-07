<?php

namespace App\Livewire\Admin\Associates;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Associate;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\DispatchesAlertEvents;
use App\Livewire\Admin\Traits\WithDeleteConfirmation;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond, DispatchesAlertEvents, WithDeleteConfirmation;

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
        'logo' => '',
        'website' => '',
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
    public $uploadMethod = 'media_library'; // 'filepond' or 'media_library'

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
        $this->form['sort_order'] = Associate::max('sort_order') + 1;
        $this->showSlidePanel = true;
    }

    public function resetUploadStates()
    {
        $this->filepondUploads = [];
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->uploadMethod = 'media_library';
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $associate = Associate::findOrFail($id);

        $this->form = [
            'name' => $associate->name,
            'logo' => $associate->logo,
            'website' => $associate->website,
            'sort_order' => $associate->sort_order,
            'is_active' => $associate->is_active,
            'media_id' => $associate->media_id,
        ];

        $this->resetUploadStates();

        // Load existing media selection
        if ($associate->media_id) {
            $this->selectedMediaId = $associate->media_id;
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($associate->media_id);
            if ($media) {
                $this->selectedMediaUrl = $media->getFullUrl();
                $this->uploadMethod = 'media_library';
            }
        } else {
            // Default to filepond for existing associates without media
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
        $this->selectedMediaId = $data['mediaId'];
        $this->selectedMediaUrl = $data['mediaUrl'];
        $this->form['media_id'] = $data['mediaId'];
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
            'form.logo' => 'nullable|string|max:255',
            'form.website' => 'nullable|url|max:255',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        try {
            $user = Auth::user();
            $associateData = $this->form;

            // Handle logo upload based on method
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $associateData['media_id'] = $this->selectedMediaId;
                $associateData['logo'] = null; // Clear logo field when using media library
            } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
                // Process FilePond uploads
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $associateData['media_id'] = $media->id;
                    $associateData['logo'] = null;
                    break; // Only use first image
                }
            }

            Associate::create($associateData);

            $this->isCreating = false;
            $this->showSlidePanel = false;
            $this->reset('form');
            $this->resetUploadStates();

            $this->flashSuccess('Associate created successfully!');
        } catch (\Exception $e) {
            $this->flashError('Failed to create associate: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.logo' => 'nullable|string|max:255',
            'form.website' => 'nullable|url|max:255',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        try {
            $user = Auth::user();
            $associate = Associate::findOrFail($this->editingId);
            $associateData = $this->form;

            // Handle logo upload based on method
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $associateData['media_id'] = $this->selectedMediaId;
                $associateData['logo'] = null; // Clear logo field when using media library
            } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
                // Process FilePond uploads
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $associateData['media_id'] = $media->id;
                    $associateData['logo'] = null;
                    break; // Only use first image
                }
            }

            $associate->update($associateData);

            $this->editingId = null;
            $this->showSlidePanel = false;
            $this->reset('form');
            $this->resetUploadStates();

            $this->flashSuccess('Associate updated successfully!');
        } catch (\Exception $e) {
            $this->flashError('Failed to update associate: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        // legacy direct delete kept for backward compatibility; route through confirm system
        $this->performActualDelete($id);
    }

    // Renamed actual delete logic
    public function performActualDelete($id)
    {
        $associate = Associate::findOrFail($id);
        $associateName = $associate->name;
        $associate->delete();

        $this->dispatchDeleteEvent("Associate '{$associateName}' has been successfully deleted.");
    }

    public function toggleActive($id)
    {
        $associate = Associate::findOrFail($id);
        $associate->update(['is_active' => !$associate->is_active]);

        $this->dispatchSuccessEvent('Associate status updated successfully!');
    }

    public function render()
    {
        $associates = Associate::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('website', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.associates.index', compact('associates'));
    }
}
