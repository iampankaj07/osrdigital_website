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
    
    // Property to force refresh after upload
    public $refreshKey = 0;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function deleteMedia($mediaId)
    {
        try {
            $media = Media::find($mediaId);
            if ($media) {
                $media->delete();
                // Increment refresh key to force component re-render
                $this->refreshKey++;
                $this->dispatch('mediaDeleted');
            }
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        // Get all media items from media-library collection
        // This includes files uploaded from:
        // - Media Library page itself
        // - Hero Slider (FilePond uploads)
        // - Other components (Associates, TeamMembers, TrustedPartners, etc.)
        // - Any other source that saves to 'media-library' collection
        $mediaItems = Media::where('collection_name', 'media-library')
            ->orderBy('created_at', 'desc')
            ->get();
            
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

    public function validateUploadedFile($filename)
    {
        // Validation logic for uploaded files - only jpg, png, gif, webp
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        return true;
    }

    public function updatedUploads()
    {
        // Uploads property updated
    }

    public function uploadFiles()
    {
        try {
            $user = Auth::user();
            $uploadedCount = 0;

            foreach ($this->uploads as $upload) {
                if (!$upload) {
                    continue;
                }

                // Validate file exists and is readable
                $filePath = $upload->getRealPath();
                if (!file_exists($filePath) || !is_readable($filePath)) {
                    throw new \Exception('Uploaded file is not accessible');
                }

                // Add media to user using spatie/laravel-medialibrary
                // Use addMedia with the temporary file path from Livewire
                $media = $user->addMedia($filePath)
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $uploadedCount++;
            }

            // Clear uploaded files
            $this->uploads = [];

            $this->uploadSuccess = true;
            $this->errorMessage = '';

            // Increment refresh key to force component re-render
            $this->refreshKey++;

            // Dispatch event to refresh media grid (for JavaScript listeners)
            $this->dispatch('mediaUploaded');

            // Reset success message after delay
            $this->dispatch('resetSuccessMessage');

        } catch (\Exception $e) {
            $this->errorMessage = 'Upload failed: ' . $e->getMessage();
        }
    }
}
