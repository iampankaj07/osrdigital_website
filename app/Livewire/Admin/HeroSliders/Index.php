<?php

namespace App\Livewire\Admin\HeroSliders;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;
use App\Models\HeroSlider;
use Illuminate\Support\Facades\Log;
use App\Traits\DispatchesAlertEvents;
use App\Livewire\Admin\Traits\WithDeleteConfirmation;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond, DispatchesAlertEvents, WithDeleteConfirmation;

    // Form properties
    public $form = [
        'title' => '',
        'subtitle' => '',
        'description' => '',
        'media_id' => null,
        'button_text' => '',
        'button_url' => '',
        'button_text_secondary' => '',
        'button_url_secondary' => '',
        'is_active' => true,
        'sort_order' => 0,
    ];

    // Component state
    public $isCreating = false;
    public $editingId = null;
    public $showSlidePanel = false;
    public $isClosing = false;

    // Search and filtering
    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Media handling
    public $uploadMethod = 'filepond';
    public $selectedMediaId = null;
    public $selectedMediaUrl = null;
    public $filepondUploads = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'sortField' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
    ];

    protected $listeners = [
        'mediaSelected' => 'handleMediaSelection',
    ];

    protected function rules()
    {
        return [
            'form.title' => 'required|string|max:255',
            'form.subtitle' => 'nullable|string|max:255',
            'form.description' => 'nullable|string|max:1000',
            'form.button_text' => 'nullable|string|max:100',
            'form.button_url' => 'nullable|url|max:255',
            'form.button_text_secondary' => 'nullable|string|max:100',
            'form.button_url_secondary' => 'nullable|url|max:255',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
            'form.media_id' => 'nullable|exists:media,id',
            'filepondUploads.*' => 'nullable|image|max:10240', // 10MB max
        ];
    }

    public function mount()
    {
        $this->form['sort_order'] = HeroSlider::max('sort_order') + 1 ?? 1;
    }

    public function updated($property)
    {
        if (str_starts_with($property, 'form.')) {
            $this->validateOnly($property);
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->form['sort_order'] = HeroSlider::max('sort_order') + 1 ?? 1;
        $this->isCreating = true;
        $this->editingId = null;
        $this->showSlidePanel = true;
    }

    public function store()
    {
        $this->validate();

        try {
            $sliderData = $this->form;

            // Handle media attachment
            if ($this->uploadMethod === 'filepond' && !empty($this->filepondUploads)) {
                // Create slider first
                $slider = HeroSlider::create($sliderData);

                // Handle FilePond file upload
                $uploadedFile = is_array($this->filepondUploads) ? $this->filepondUploads[0] : $this->filepondUploads;

                if ($uploadedFile) {
                    try {
                        // Store the file and create media record
                        $media = $slider->addMedia($uploadedFile)
                            ->usingName(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME))
                            ->toMediaCollection('media-library');

                        // Update slider with media_id
                        $slider->update(['media_id' => $media->id]);

                        Log::info('Hero Slider - FilePond upload successful', [
                            'slider_id' => $slider->id,
                            'media_id' => $media->id
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Hero Slider - FilePond upload error: ' . $e->getMessage());
                        // Continue without failing the slider creation
                    }
                }

                $this->resetForm();
                $this->isCreating = false;
                $this->showSlidePanel = false;
                $this->flashSuccess('Hero slide created successfully.');
                return;

            } elseif ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $sliderData['media_id'] = $this->selectedMediaId;
            }

            HeroSlider::create($sliderData);

            $this->resetForm();
            $this->isCreating = false;
            $this->showSlidePanel = false;

            $this->flashSuccess('Hero slide created successfully.');

        } catch (\Exception $e) {
            Log::error('Hero Slider Creation Error: ' . $e->getMessage());
            $this->flashError('Failed to create hero slide. Please try again.');

        }
    }

    public function edit($sliderId)
    {
        try {
            $slider = HeroSlider::findOrFail($sliderId);

            $this->form = [
                'title' => $slider->title,
                'subtitle' => $slider->subtitle,
                'description' => $slider->description,
                'media_id' => $slider->media_id,
                'button_text' => $slider->button_text,
                'button_url' => $slider->button_url,
                'button_text_secondary' => $slider->button_text_secondary,
                'button_url_secondary' => $slider->button_url_secondary,
                'is_active' => $slider->is_active,
                'sort_order' => $slider->sort_order,
            ];

            // Set media selection state
            if ($slider->media_id) {
                $this->selectedMediaId = $slider->media_id;
                $this->selectedMediaUrl = $slider->image_url;
            }

            $this->editingId = $sliderId;
            $this->isCreating = false;
            $this->showSlidePanel = true;

        } catch (\Exception $e) {
            Log::error('Hero Slider Edit Error: ' . $e->getMessage());
            $this->flashError('Failed to load hero slide data.');

        }
    }

    public function update()
    {
        $this->validate();

        try {
            $slider = HeroSlider::findOrFail($this->editingId);
            $sliderData = $this->form;

            // Handle media attachment
            if ($this->uploadMethod === 'filepond' && !empty($this->filepondUploads)) {
                // Handle FilePond file upload
                $uploadedFile = is_array($this->filepondUploads) ? $this->filepondUploads[0] : $this->filepondUploads;

                if ($uploadedFile) {
                    try {
                        // Store the file and create media record
                        $media = $slider->addMedia($uploadedFile)
                            ->usingName(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME))
                            ->toMediaCollection('media-library');

                        // Update slider with new media_id
                        $sliderData['media_id'] = $media->id;

                        Log::info('Hero Slider - FilePond update successful', [
                            'slider_id' => $slider->id,
                            'media_id' => $media->id
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Hero Slider - FilePond update error: ' . $e->getMessage());
                        // Continue without failing the slider update
                    }
                }
            } elseif ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $sliderData['media_id'] = $this->selectedMediaId;
            }

            $slider->update($sliderData);

            $this->resetForm();
            $this->editingId = null;
            $this->showSlidePanel = false;

            $this->flashSuccess('Hero slide updated successfully.');

        } catch (\Exception $e) {
            Log::error('Hero Slider Update Error: ' . $e->getMessage());
            $this->flashError('Failed to update hero slide. Please try again.');

        }
    }

    public function delete($sliderId)
    {
        // Legacy direct delete kept for backward compatibility; route through confirm system
        $this->performActualDelete($sliderId);
    }

    // Renamed actual delete logic
    public function performActualDelete($sliderId)
    {
        try {
            $slider = HeroSlider::findOrFail($sliderId);
            $sliderTitle = $slider->title ?? 'Hero slide';
            $slider->delete();

            $this->flashDelete("Hero slide '{$sliderTitle}' has been successfully deleted.");

        } catch (\Exception $e) {
            Log::error('Hero Slider Delete Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to delete hero slide. Please try again.');
        }
    }

    public function cancelEdit()
    {
        $this->resetForm();
        $this->editingId = null;
        $this->isCreating = false;
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
        $this->resetForm();
        $this->editingId = null;
        $this->isCreating = false;
    }

    public function toggleActive($sliderId)
    {
        try {
            $slider = HeroSlider::findOrFail($sliderId);
            $slider->update(['is_active' => !$slider->is_active]);

            $message = $slider->is_active ? 'Hero slide activated.' : 'Hero slide deactivated.';
            $this->flashSuccess($message);

        } catch (\Exception $e) {
            Log::error('Hero Slider Toggle Active Error: ' . $e->getMessage());
            $this->flashError('Failed to update slide status.');

        }
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

    public function openMediaSelector()
    {
        $this->dispatch('openMediaSelector');
    }

    public function handleMediaSelection($data)
    {
        try {
            Log::info('Hero Slider - Media selection received:', ['data' => $data]);

            // Handle case where data is an indexed array containing the media data
            if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                $data = $data[0];
            }

            // Add defensive programming to handle missing keys
            if (isset($data['mediaId'])) {
                $this->selectedMediaId = $data['mediaId'];
                $this->form['media_id'] = $data['mediaId'];
                Log::info('Hero Slider - Media ID set to:', ['mediaId' => $data['mediaId']]);
            } else {
                Log::warning('Hero Slider - mediaId not found in data:', ['data' => $data]);
            }

            if (isset($data['mediaUrl'])) {
                $this->selectedMediaUrl = $data['mediaUrl'];
                Log::info('Hero Slider - Media URL set to:', ['mediaUrl' => $data['mediaUrl']]);
            } else {
                Log::warning('Hero Slider - mediaUrl not found in data:', ['data' => $data]);
            }

            Log::info('Hero Slider - Media selection completed', [
                'media_id' => $this->selectedMediaId,
                'url' => $this->selectedMediaUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Hero Slider - Media selection error: ' . $e->getMessage());
            $this->flashError('Failed to select media. Please try again.');

        }
    }

    public function clearSelectedMedia()
    {
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->form['media_id'] = null;
    }

    public function updatedUploadMethod($value)
    {
        // Clear uploads when switching methods
        if ($value === 'media_library') {
            $this->filepondUploads = [];
        } else {
            $this->clearSelectedMedia();
        }
    }

    private function resetForm()
    {
        $this->form = [
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'media_id' => null,
            'button_text' => '',
            'button_url' => '',
            'button_text_secondary' => '',
            'button_url_secondary' => '',
            'is_active' => true,
            'sort_order' => HeroSlider::max('sort_order') + 1 ?? 1,
        ];

        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->filepondUploads = [];
        $this->uploadMethod = 'filepond';
    }

    public function render()
    {
        $query = HeroSlider::query()->with(['mediaRecord', 'media']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('subtitle', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $heroSliders = $query->paginate($this->perPage);

        return view('livewire.admin.hero-sliders.index', compact('heroSliders'));
    }

    public function performDelete()
    {
        try {
            $sliderId = $this->confirmingDeleteId;
            $slider = HeroSlider::findOrFail($sliderId);
            $sliderTitle = $slider->title;
            $slider->delete();

            $this->dispatchDeleteEvent("Hero slider '{$sliderTitle}' has been successfully deleted.");

        } catch (\Exception $e) {
            Log::error('Hero Slider Delete Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to delete hero slider. Please try again.');
        }
    }
}
