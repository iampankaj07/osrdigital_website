<?php

namespace App\Livewire\Admin\MediaLibrary;

use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Spatie\LivewireFilepond\WithFilePond;

class Index extends Component
{
    use WithFileUploads, WithFilePond;

    public $uploadedFiles = [];
    public $uploadSuccess = false;
    public $errorMessage = '';

    // FilePond properties
    public $uploads = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function deleteMedia($mediaId)
    {
        try {
            $media = Media::find($mediaId);
            if ($media) {
                $media->delete();
                $this->dispatch('mediaDeleted');
            }
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        $mediaItems = Media::where('collection_name', 'media-library')->latest()->get();
        return view('livewire.admin.media-library.index', [
            'mediaItems' => $mediaItems,
        ]);
    }

    public function refreshMedia()
    {
        // This method can be called to refresh the component
        $this->uploadSuccess = false;
        $this->errorMessage = '';

        // Clear any cached data
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        // Initialize component state
        $this->uploadSuccess = false;
        $this->errorMessage = '';
    }

    public function testConnection()
    {
        $this->errorMessage = 'Test connection successful at ' . now()->format('H:i:s');
    }

    public function validateUploadedFile($filename)
    {
        // Validation logic for uploaded files
        // Return true if valid, false if invalid
        \Log::info('Validating uploaded file: ' . $filename);
        return true;
    }
    
    public function updatedUploads()
    {
        \Log::info('Uploads updated. Count: ' . count($this->uploads));
        foreach ($this->uploads as $index => $upload) {
            \Log::info("Upload {$index}: " . ($upload ? $upload->getClientOriginalName() : 'null'));
        }
    }

    public function uploadFiles()
    {
        try {
            $user = Auth::user();
            $uploadedCount = 0;

            foreach ($this->uploads as $upload) {
                // Add media to user using spatie/laravel-medialibrary
                $media = $user->addMedia($upload->getRealPath())
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $uploadedCount++;
            }

            // Clear uploaded files
            $this->uploads = [];

            $this->uploadSuccess = true;
            $this->errorMessage = '';

            // Reset success message after delay
            $this->dispatch('resetSuccessMessage');

        } catch (\Exception $e) {
            $this->errorMessage = 'Upload failed: ' . $e->getMessage();
        }
    }
}
