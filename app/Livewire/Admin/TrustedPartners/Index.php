<?php

namespace App\Livewire\Admin\TrustedPartners;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TrustedPartner;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        'description' => '',
        'logo' => '',
        'website_url' => '',
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
        $this->form['sort_order'] = TrustedPartner::max('sort_order') + 1;
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
        $trustedPartner = TrustedPartner::findOrFail($id);

        $this->form = [
            'name' => $trustedPartner->name,
            'description' => $trustedPartner->description,
            'logo' => $trustedPartner->logo,
            'website_url' => $trustedPartner->website_url,
            'sort_order' => $trustedPartner->sort_order,
            'is_active' => $trustedPartner->is_active,
            'media_id' => $trustedPartner->media_id,
        ];

        $this->resetUploadStates();

        // Load existing media selection
        if ($trustedPartner->media_id) {
            $this->selectedMediaId = $trustedPartner->media_id;
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($trustedPartner->media_id);
            if ($media) {
                $this->selectedMediaUrl = $media->getFullUrl();
                $this->uploadMethod = 'media_library';
            }
        } else {
            // Default to filepond for existing partners without media
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
            'form.description' => 'required|string',
            'form.logo' => 'nullable|string|max:255',
            'form.website_url' => 'nullable|url|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        try {
            $user = Auth::user();
            $partnerData = $this->form;

            // Handle logo upload based on method
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $partnerData['media_id'] = $this->selectedMediaId;
                $partnerData['logo'] = null; // Clear logo field when using media library
            } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
                // Process FilePond uploads
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $partnerData['media_id'] = $media->id;
                    $partnerData['logo'] = null; // Clear logo field when using FilePond
                    break; // Only take the first file for logo
                }
            }

            TrustedPartner::create($partnerData);

            $this->isCreating = false;
            $this->reset('form');
            $this->resetUploadStates();

            session()->flash('success', 'Trusted Partner created successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating trusted partner: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.logo' => 'nullable|string|max:255',
            'form.website_url' => 'nullable|url|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        try {
            $user = Auth::user();
            $trustedPartner = TrustedPartner::findOrFail($this->editingId);
            $partnerData = $this->form;

            // Handle logo update based on method
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $partnerData['media_id'] = $this->selectedMediaId;
                $partnerData['logo'] = null;
            } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
                // Process FilePond uploads
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $partnerData['media_id'] = $media->id;
                    $partnerData['logo'] = null;
                    break;
                }
            }

            $trustedPartner->update($partnerData);

            $this->editingId = null;
            $this->reset('form');
            $this->resetUploadStates();

            session()->flash('success', 'Trusted Partner updated successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating trusted partner: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $trustedPartner = TrustedPartner::findOrFail($id);
        $trustedPartner->delete();

        session()->flash('success', 'Trusted Partner deleted successfully!');
    }

    public function toggleActive($id)
    {
        $trustedPartner = TrustedPartner::findOrFail($id);
        $trustedPartner->update(['is_active' => !$trustedPartner->is_active]);

        session()->flash('success', 'Trusted Partner status updated successfully!');
    }

    public function render()
    {
        $trustedPartners = TrustedPartner::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.trusted-partners.index', compact('trustedPartners'));
    }
}
