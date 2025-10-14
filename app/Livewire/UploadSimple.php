<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UploadSimple extends Component
{
    use WithFileUploads;

    public $uploads = [];
    public bool $multiple = false;

    public function mount($multiple = false)
    {
        $this->multiple = $multiple;
    }

    public function updatedUploads()
    {
        if (empty($this->uploads)) {
            return;
        }

        $processedUploads = [];

        foreach ((array) $this->uploads as $upload) {
            if ($upload) {
                try {
                    // Add media to user using spatie/laravel-medialibrary
                    $user = Auth::user();
                    $media = $user->addMediaFromDisk($upload->getRealPath(), 'local')
                        ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                        ->usingFileName($upload->getClientOriginalName())
                        ->toMediaCollection('media-library');

                    $processedUploads[] = [
                        'id' => $media->id,
                        'url' => $media->getFullUrl(),
                        'name' => $media->name
                    ];
                } catch (\Exception $e) {
                    // Log error but continue processing other files
                    Log::error('File upload error: ' . $e->getMessage());
                }
            }
        }

        // Emit the processed uploads to parent component
        if (!empty($processedUploads)) {
            $this->dispatch('filepondUploadsProcessed', $processedUploads);
        }
    }

    public function validateUploadedFile($upload)
    {
        // Basic validation - can be extended as needed
        if (!$upload) {
            return false;
        }

        // Check if it's an image
        $mimeType = $upload->getMimeType ?? '';
        if (!str_starts_with($mimeType, 'image/')) {
            return false;
        }

        // Check file size (10MB max)
        $maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if ($upload->getSize() > $maxSize) {
            return false;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.upload-simple');
    }
}
