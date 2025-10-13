<?php

namespace App\Livewire\Admin\Associates;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Associate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads, WithFilePond;

    public $name = '';
    public $description = '';
    public $type = 'production';
    public $website_url = '';
    public $logo;
    public $is_active = true;
    public $sort_order = 0;

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
            $associate = new Associate();
            $associate->name = $this->name;
            $associate->description = $this->description;
            $associate->type = $this->type;
            $associate->website_url = $this->website_url;
            $associate->is_active = $this->is_active;
            $associate->sort_order = $this->sort_order;

            // Handle logo upload based on method
            if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $associate->media_id = $this->selectedMediaId;
            } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
                // Process FilePond uploads
                foreach ($this->filepondUploads as $upload) {
                    $media = $user->addMedia($upload->getRealPath())
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $associate->media_id = $media->id;
                    break; // Only use first image
                }
            } elseif ($this->logo) {
                // Fallback to traditional upload
                $filename = 'associates/' . Str::uuid() . '.' . $this->logo->getClientOriginalExtension();
                $this->logo->storeAs('public', $filename);
                $associate->logo = $filename;
            }

            $associate->save();

            session()->flash('success', 'Associate created successfully!');
            return redirect()->route('admin.associates.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create associate: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.associates.create');
    }
}
