<?php

namespace App\Livewire\Admin\Testimonials;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;
use App\Models\Testimonial;
use App\Traits\DispatchesAlertEvents;
use App\Livewire\Admin\Traits\WithDeleteConfirmation;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond, DispatchesAlertEvents, WithDeleteConfirmation;

    // Form properties
    public $form = [
        'name' => '',
        'role' => '',
        'company' => '',
        'content' => '',
        'project' => '',
        'avatar_url' => '',
        'sort_order' => 0,
        'is_featured' => false,
        'is_published' => false,
        'media_id' => null,
    ];

    // Component state
    public $isCreating = false;
    public $editingId = null;
    public $showSlidePanel = false;
    public $isClosing = false;

    // Search and filtering
    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Media handling
    public $uploadMethod = 'media_library';
    public $selectedMediaId = null;
    public $selectedMediaUrl = null;
    public $filepondUploads = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
    ];

    protected $listeners = [
        'mediaSelected' => 'handleMediaSelection',
    ];

    protected function rules()
    {
        return [
            'form.name' => 'required|string|max:255',
            'form.role' => 'nullable|string|max:255',
            'form.company' => 'nullable|string|max:255',
            'form.content' => 'required|string',
            'form.project' => 'nullable|string|max:255',
            'form.avatar_url' => 'nullable|url',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_featured' => 'boolean',
            'form.is_published' => 'boolean',
            'form.media_id' => 'nullable|exists:media,id',
        ];
    }

    public function mount()
    {
        $this->form['sort_order'] = Testimonial::max('sort_order') + 1 ?? 0;
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
        $this->form['sort_order'] = Testimonial::max('sort_order') + 1 ?? 0;
        $this->isCreating = true;
        $this->editingId = null;
        $this->showSlidePanel = true;
    }

    public function store()
    {
        $this->validate();

        try {
            $testimonialData = $this->form;

            // Handle media attachment
            if ($this->uploadMethod === 'filepond' && !empty($this->filepondUploads)) {
                $upload = $this->filepondUploads[0] ?? null;
                if ($upload) {
                    $testimonialData['media_id'] = $upload['id'] ?? null;
                }
            } elseif ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $testimonialData['media_id'] = $this->selectedMediaId;
            }

            Testimonial::create($testimonialData);

            $this->resetForm();
            $this->isCreating = false;
            $this->showSlidePanel = false;

            $this->flashSuccess('Testimonial created successfully.');

        } catch (\Exception $e) {
            Log::error('Testimonial Creation Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to create testimonial. Please try again.');

        }
    }

    public function edit($testimonialId)
    {
        try {
            $testimonial = Testimonial::findOrFail($testimonialId);

            $this->form = [
                'name' => $testimonial->name,
                'role' => $testimonial->role,
                'company' => $testimonial->company,
                'content' => $testimonial->content,
                'project' => $testimonial->project,
                'avatar_url' => $testimonial->avatar_url,
                'sort_order' => $testimonial->sort_order,
                'is_featured' => $testimonial->is_featured,
                'is_published' => $testimonial->is_published,
                'media_id' => $testimonial->media_id,
            ];

            // Set media selection state
            if ($testimonial->media_id) {
                $this->selectedMediaId = $testimonial->media_id;
                $this->selectedMediaUrl = $testimonial->avatar_url;
            }

            $this->editingId = $testimonialId;
            $this->isCreating = false;
            $this->showSlidePanel = true;

        } catch (\Exception $e) {
            Log::error('Testimonial Edit Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to load testimonial data.');

        }
    }

    public function update()
    {
        $this->validate();

        try {
            $testimonial = Testimonial::findOrFail($this->editingId);
            $testimonialData = $this->form;

            // Handle media attachment
            if ($this->uploadMethod === 'filepond' && !empty($this->filepondUploads)) {
                $upload = $this->filepondUploads[0] ?? null;
                if ($upload) {
                    $testimonialData['media_id'] = $upload['id'] ?? null;
                }
            } elseif ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $testimonialData['media_id'] = $this->selectedMediaId;
            }

            $testimonial->update($testimonialData);

            $this->resetForm();
            $this->editingId = null;
            $this->showSlidePanel = false;

            $this->flashSuccess('Testimonial updated successfully.');

        } catch (\Exception $e) {
            Log::error('Testimonial Update Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to update testimonial. Please try again.');

        }
    }

    public function delete($testimonialId)
    {
        // Legacy direct delete kept for backward compatibility; route through confirm system
        $this->performActualDelete($testimonialId);
    }

    // Renamed actual delete logic
    public function performActualDelete($testimonialId)
    {
        try {
            $testimonial = Testimonial::findOrFail($testimonialId);
            $testimonialName = $testimonial->name;
            $testimonial->delete();

            $this->flashDelete("Testimonial '{$testimonialName}' has been successfully deleted.");

        } catch (\Exception $e) {
            Log::error('Testimonial Delete Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to delete testimonial. Please try again.');

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

    public function toggleFeatured($testimonialId)
    {
        try {
            $testimonial = Testimonial::findOrFail($testimonialId);
            $testimonial->update(['is_featured' => !$testimonial->is_featured]);

            $message = $testimonial->is_featured ? 'Testimonial marked as featured.' : 'Testimonial removed from featured.';
            $this->dispatchSuccessEvent($message);

        } catch (\Exception $e) {
            Log::error('Testimonial Toggle Featured Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to update featured status.');

        }
    }

    public function togglePublished($testimonialId)
    {
        try {
            $testimonial = Testimonial::findOrFail($testimonialId);
            $testimonial->update(['is_published' => !$testimonial->is_published]);

            $message = $testimonial->is_published ? 'Testimonial published successfully.' : 'Testimonial unpublished successfully.';
            $this->dispatchSuccessEvent($message);

        } catch (\Exception $e) {
            Log::error('Testimonial Toggle Published Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to update publication status.');

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
            Log::info('Testimonial - Media selection received:', ['data' => $data]);

            // Handle case where data is an indexed array containing the media data
            if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                $data = $data[0];
            }

            // Add defensive programming to handle missing keys
            if (isset($data['mediaId'])) {
                $this->selectedMediaId = $data['mediaId'];
                $this->form['media_id'] = $data['mediaId'];
                Log::info('Testimonial - Media ID set to:', ['mediaId' => $data['mediaId']]);
            } else {
                Log::warning('Testimonial - mediaId not found in data:', ['data' => $data]);
            }

            if (isset($data['mediaUrl'])) {
                $this->selectedMediaUrl = $data['mediaUrl'];
                Log::info('Testimonial - Media URL set to:', ['mediaUrl' => $data['mediaUrl']]);
            } else {
                Log::warning('Testimonial - mediaUrl not found in data:', ['data' => $data]);
            }

            Log::info('Testimonial - Media selection completed', [
                'media_id' => $this->selectedMediaId,
                'url' => $this->selectedMediaUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Testimonial - Media selection error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to select media. Please try again.');

        }
    }

    public function clearSelectedMedia()
    {
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->form['media_id'] = null;
    }

    private function resetForm()
    {
        $this->form = [
            'name' => '',
            'role' => '',
            'company' => '',
            'content' => '',
            'project' => '',
            'avatar_url' => '',
            'sort_order' => Testimonial::max('sort_order') + 1 ?? 0,
            'is_featured' => false,
            'is_published' => false,
            'media_id' => null,
        ];

        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->filepondUploads = [];
        $this->uploadMethod = 'media_library';
    }

    public function render()
    {
        $query = Testimonial::query()->with('media');

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('company', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%')
                  ->orWhere('project', 'like', '%' . $this->search . '%');
            });
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $testimonials = $query->paginate($this->perPage);

        return view('livewire.admin.testimonials.index', compact('testimonials'));
    }
}
