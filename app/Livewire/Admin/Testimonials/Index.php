<?php

namespace App\Livewire\Admin\Testimonials;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;

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
        'role' => '',
        'company' => '',
        'content' => '',
        'project' => '',
        'avatar_url' => '',
        'is_featured' => false,
        'is_published' => true,
        'sort_order' => 0,
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
        $this->form['sort_order'] = Testimonial::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $testimonial = Testimonial::findOrFail($id);

        $this->form = [
            'name' => $testimonial->name,
            'role' => $testimonial->role,
            'company' => $testimonial->company,
            'content' => $testimonial->content,
            'project' => $testimonial->project,
            'avatar_url' => $testimonial->avatar_url,
            'is_featured' => $testimonial->is_featured,
            'is_published' => $testimonial->is_published,
            'sort_order' => $testimonial->sort_order,
        ];

        $this->resetUploadStates();

        // Load existing media selection if available
        if ($testimonial->media_id) {
            $this->selectedMediaId = $testimonial->media_id;
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($testimonial->media_id);
            if ($media) {
                $this->selectedMediaUrl = $media->getFullUrl();
                $this->uploadMethod = 'media_library';
            }
        } else {
            // Default to filepond for existing testimonials without media
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

    public function store()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.role' => 'nullable|string|max:255',
            'form.company' => 'nullable|string|max:255',
            'form.content' => 'required|string',
            'form.project' => 'nullable|string|max:255',
            'form.avatar_url' => 'nullable|string|max:255',
            'form.is_featured' => 'boolean',
            'form.is_published' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $testimonialData = $this->form;

        // Handle media uploads
        if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
            $testimonialData['media_id'] = $this->selectedMediaId;
            $testimonialData['avatar_url'] = null; // Clear avatar_url field when using media library
        } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
            // Process FilePond uploads
            foreach ($this->filepondUploads as $upload) {
                $media = $user->addMedia($upload->getRealPath())
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $testimonialData['media_id'] = $media->id;
                $testimonialData['avatar_url'] = null; // Clear avatar_url field when using FilePond
                break; // Only take the first file for avatar
            }
        }

        Testimonial::create($testimonialData);

        $this->isCreating = false;
        $this->reset('form');
        $this->resetUploadStates();

        session()->flash('success', 'Testimonial created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.role' => 'nullable|string|max:255',
            'form.company' => 'nullable|string|max:255',
            'form.content' => 'required|string',
            'form.project' => 'nullable|string|max:255',
            'form.avatar_url' => 'nullable|string|max:255',
            'form.is_featured' => 'boolean',
            'form.is_published' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $testimonial = Testimonial::findOrFail($this->editingId);
        $testimonialData = $this->form;

        // Handle media uploads
        if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
            $testimonialData['media_id'] = $this->selectedMediaId;
            $testimonialData['avatar_url'] = null; // Clear avatar_url field when using media library
        } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
            // Process FilePond uploads
            foreach ($this->filepondUploads as $upload) {
                $media = $user->addMedia($upload->getRealPath())
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $testimonialData['media_id'] = $media->id;
                $testimonialData['avatar_url'] = null; // Clear avatar_url field when using FilePond
                break; // Only take the first file for avatar
            }
        }

        $testimonial->update($testimonialData);

        $this->editingId = null;
        $this->reset('form');
        $this->resetUploadStates();

        session()->flash('success', 'Testimonial updated successfully!');
    }

    public function delete($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        session()->flash('success', 'Testimonial deleted successfully!');
    }

    public function toggleFeatured($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);

        session()->flash('success', 'Testimonial featured status updated successfully!');
    }

    public function togglePublished($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_published' => !$testimonial->is_published]);

        session()->flash('success', 'Testimonial published status updated successfully!');
    }

    public function resetUploadStates()
    {
        $this->filepondUploads = [];
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->uploadMethod = 'filepond';
    }

    public function validateUploadedFile($filename)
    {
        return true;
    }

    public function handleMediaSelection($data)
    {
        if (isset($data['id']) && isset($data['url'])) {
            $this->selectedMediaId = $data['id'];
            $this->selectedMediaUrl = $data['url'];
        }
    }

    public function render()
    {
        $testimonials = Testimonial::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%')
                      ->orWhere('company', 'like', '%' . $this->search . '%')
                      ->orWhere('project', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.testimonials.index', compact('testimonials'))
            ->layout('admin.layout', ['title' => 'Testimonials']);
    }
}
