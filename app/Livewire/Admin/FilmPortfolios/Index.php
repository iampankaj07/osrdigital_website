<?php

namespace App\Livewire\Admin\FilmPortfolios;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\FilmPortfolio;
use App\Models\FilmCategory;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';
    public $categoryFilter = '';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'title' => '',
        'slug' => '',
        'description' => '',
        'genre' => '',
        'year' => '',
        'image_url' => '',
        'featured_image' => '',
        'video_url' => '',
        'rating' => '',
        'duration' => '',
        'category_id' => '',
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
        'categoryFilter' => ['except' => ''],
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

    public function updatingCategoryFilter()
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
        $this->form['sort_order'] = FilmPortfolio::max('sort_order') + 1;
        $this->form['year'] = date('Y');
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $film = FilmPortfolio::findOrFail($id);

        $this->form = [
            'title' => $film->title,
            'slug' => $film->slug,
            'description' => $film->description,
            'genre' => $film->genre,
            'year' => $film->year,
            'image_url' => $film->image_url,
            'featured_image' => $film->featured_image,
            'video_url' => $film->video_url,
            'rating' => $film->rating,
            'duration' => $film->duration,
            'category_id' => $film->category_id,
            'is_featured' => $film->is_featured,
            'is_published' => $film->is_published,
            'sort_order' => $film->sort_order,
        ];

        $this->resetUploadStates();

        // Load existing media selection if available
        if ($film->media_id) {
            $this->selectedMediaId = $film->media_id;
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($film->media_id);
            if ($media) {
                $this->selectedMediaUrl = $media->getFullUrl();
                $this->uploadMethod = 'media_library';
            }
        } else {
            // Default to filepond for existing films without media
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
            'form.title' => 'required|string|max:255',
            'form.slug' => 'nullable|string|max:255',
            'form.description' => 'required|string',
            'form.genre' => 'nullable|string|max:255',
            'form.year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'form.image_url' => 'nullable|string|max:255',
            'form.featured_image' => 'nullable|string|max:255',
            'form.video_url' => 'nullable|url|max:255',
            'form.rating' => 'nullable|numeric|min:0|max:10',
            'form.duration' => 'nullable|string|max:50',
            'form.category_id' => 'nullable|exists:film_categories,id',
            'form.is_featured' => 'boolean',
            'form.is_published' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $filmData = $this->form;

        // Handle media uploads
        if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
            $filmData['media_id'] = $this->selectedMediaId;
            $filmData['featured_image'] = null; // Clear featured_image field when using media library
            $filmData['image_url'] = null; // Clear image_url field when using media library
        } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
            // Process FilePond uploads
            foreach ($this->filepondUploads as $upload) {
                $media = $user->addMedia($upload->getRealPath())
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $filmData['media_id'] = $media->id;
                $filmData['featured_image'] = null; // Clear featured_image field when using FilePond
                $filmData['image_url'] = null; // Clear image_url field when using FilePond
                break; // Only take the first file for featured image
            }
        }

        FilmPortfolio::create($filmData);

        $this->isCreating = false;
        $this->reset('form');
        $this->resetUploadStates();

        session()->flash('success', 'Film Portfolio created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.slug' => 'nullable|string|max:255',
            'form.description' => 'required|string',
            'form.genre' => 'nullable|string|max:255',
            'form.year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'form.image_url' => 'nullable|string|max:255',
            'form.featured_image' => 'nullable|string|max:255',
            'form.video_url' => 'nullable|url|max:255',
            'form.rating' => 'nullable|numeric|min:0|max:10',
            'form.duration' => 'nullable|string|max:50',
            'form.category_id' => 'nullable|exists:film_categories,id',
            'form.is_featured' => 'boolean',
            'form.is_published' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $film = FilmPortfolio::findOrFail($this->editingId);
        $filmData = $this->form;

        // Handle media uploads
        if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
            $filmData['media_id'] = $this->selectedMediaId;
            $filmData['featured_image'] = null; // Clear featured_image field when using media library
            $filmData['image_url'] = null; // Clear image_url field when using media library
        } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
            // Process FilePond uploads
            foreach ($this->filepondUploads as $upload) {
                $media = $user->addMedia($upload->getRealPath())
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $filmData['media_id'] = $media->id;
                $filmData['featured_image'] = null; // Clear featured_image field when using FilePond
                $filmData['image_url'] = null; // Clear image_url field when using FilePond
                break; // Only take the first file for featured image
            }
        }

        $film->update($filmData);

        $this->editingId = null;
        $this->reset('form');
        $this->resetUploadStates();

        session()->flash('success', 'Film Portfolio updated successfully!');
    }

    public function delete($id)
    {
        $film = FilmPortfolio::findOrFail($id);
        $film->delete();

        session()->flash('success', 'Film Portfolio deleted successfully!');
    }

    public function toggleFeatured($id)
    {
        $film = FilmPortfolio::findOrFail($id);
        $film->update(['is_featured' => !$film->is_featured]);

        session()->flash('success', 'Film Portfolio featured status updated successfully!');
    }

    public function togglePublished($id)
    {
        $film = FilmPortfolio::findOrFail($id);
        $film->update(['is_published' => !$film->is_published]);

        session()->flash('success', 'Film Portfolio published status updated successfully!');
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
        $films = FilmPortfolio::with('category')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('genre', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $categories = FilmCategory::orderBy('name')->get();

        return view('livewire.admin.film-portfolios.index', compact('films', 'categories'))
            ->layout('admin.layout', ['title' => 'Film Portfolios']);
    }
}
