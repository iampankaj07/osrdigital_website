<?php

namespace App\Livewire\Admin\Associates;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Associate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    use WithFileUploads, WithFilePond;

    public Associate $associate;
    public $name = '';
    public $description = '';
    public $type = 'production';
    public $website_url = '';
    public $logo;
    public $is_active = true;
    public $sort_order = 0;
    public $old_logo = '';

    // FilePond uploads
    public $filepondUploads = [];

    // Media library selection
    public $selectedMediaId = null;
    public $selectedMediaUrl = null;

    // Upload method preference
    public $uploadMethod = 'filepond'; // 'filepond' or 'media_library'

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|string|in:production,distribution,technology,other',
        'website_url' => 'nullable|url',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'is_active' => 'boolean',
        'sort_order' => 'integer|min:0',
        'uploadMethod' => 'required|in:filepond,media_library',
    ];

    protected $listeners = [
        'mediaSelected' => 'handleMediaSelection',
    ];

    public function mount(Associate $associate)
    {
        $this->associate = $associate;
        $this->name = $associate->name;
        $this->description = $associate->description;
        $this->type = $associate->type;
        $this->website_url = $associate->website_url;
        $this->is_active = $associate->is_active;
        $this->sort_order = $associate->sort_order;
        $this->old_logo = $associate->logo;

        // Load existing media selection
        if ($associate->media_id) {
            $this->selectedMediaId = $associate->media_id;
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($associate->media_id);
            if ($media) {
                $this->selectedMediaUrl = $media->getFullUrl();
            }
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function validateUploadedFile($filename)
    {
        return true;
    }

    public function handleMediaSelection($data)
    {
        $this->selectedMediaId = $data['mediaId'];
        $this->selectedMediaUrl = $data['mediaUrl'];
    }

    public function openMediaSelector()
    {
        $this->dispatch('openMediaSelector');
    }

    public function clearSelectedMedia()
    {
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
    }

    public function save()
    {
        $this->validate();

        try {
            $user = Auth::user();
            $this->associate->name = $this->name;
            $this->associate->description = $this->description;
            $this->associate->type = $this->type;
            $this->associate->website_url = $this->website_url;
            $this->associate->is_active = $this->is_active;
            $this->associate->sort_order = $this->sort_order;

            // Handle logo upload based on method
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $this->associate->media_id = $this->selectedMediaId;
                // Clear old logo field since we're using media library
                $this->associate->logo = null;
            } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
                // Process FilePond uploads
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $this->associate->media_id = $media->id;
                    $this->associate->logo = null; // Clear old logo field
                    break; // Only use first image
                }
            } elseif ($this->logo) {
                // Fallback to traditional upload
                // Delete old logo if exists
                if ($this->old_logo && Storage::disk('public')->exists($this->old_logo)) {
                    Storage::disk('public')->delete($this->old_logo);
                }

                $filename = 'associates/' . Str::uuid() . '.' . $this->logo->getClientOriginalExtension();
                $this->logo->storeAs('public', $filename);
                $this->associate->logo = $filename;
                $this->associate->media_id = null; // Clear media ID since using direct upload
            }

            $this->associate->save();

            session()->flash('success', 'Associate updated successfully!');
            $this->redirect(route('admin.associates.index'));

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update associate: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.associates.edit');
    }
}
