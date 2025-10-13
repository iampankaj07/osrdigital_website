<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaSelector extends Component
{
    public $showModal = false;
    public $selectedMediaId = null;
    public $selectedMediaUrl = null;
    public $acceptedTypes = 'image/*';

    protected $listeners = [
        'openMediaSelector' => 'openModal',
        'selectMedia' => 'selectMedia'
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function selectMedia($mediaId)
    {
        $media = Media::find($mediaId);
        if ($media) {
            $this->selectedMediaId = $mediaId;
            $this->selectedMediaUrl = $media->getFullUrl();

            // Emit event to parent component
            $this->dispatch('mediaSelected', [
                'mediaId' => $mediaId,
                'mediaUrl' => $media->getFullUrl(),
                'mediaName' => $media->name
            ]);

            $this->closeModal();
        }
    }

    public function render()
    {
        $mediaItems = Media::where('collection_name', 'media-library')
            ->when($this->acceptedTypes === 'image/*', function ($query) {
                $query->where('mime_type', 'like', 'image/%');
            })
            ->latest()
            ->get();

        return view('livewire.components.media-selector', [
            'mediaItems' => $mediaItems
        ]);
    }
}
