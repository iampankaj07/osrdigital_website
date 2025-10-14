<?php

namespace App\Livewire\Admin\FilmPortfolios;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\FilmPortfolio;
use App\Models\FilmCategory;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond;

    // Form properties
    public $form = [
        'title' => '',
        'slug' => '',
        'description' => '',
        'genre' => '',
        'year' => null,
        'duration' => '',
        'rating' => null,
        'category_id' => null,
        'sort_order' => 0,
        'is_featured' => false,
        'is_published' => false,
        'media_id' => null,
    ];

    // Component state
    public $isCreating = false;
    public $editingId = null;

    // Search and filtering
    public $search = '';
    public $categoryFilter = '';
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
        'categoryFilter' => ['except' => ''],
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
            'form.slug' => 'nullable|string|max:255|unique:film_portfolios,slug,' . $this->editingId,
            'form.description' => 'nullable|string',
            'form.genre' => 'nullable|string|max:100',
            'form.year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'form.duration' => 'nullable|string|max:50',
            'form.rating' => 'nullable|numeric|min:0|max:10',
            'form.category_id' => 'nullable|exists:film_categories,id',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_featured' => 'boolean',
            'form.is_published' => 'boolean',
            'form.media_id' => 'nullable|exists:media,id',
        ];
    }

    public function mount()
    {
        $this->form['sort_order'] = FilmPortfolio::max('sort_order') + 1 ?? 0;
    }

    public function updated($property)
    {
        if ($property === 'form.title') {
            $this->form['slug'] = Str::slug($this->form['title']);
        }

        if (str_starts_with($property, 'form.')) {
            $this->validateOnly($property);
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->form['sort_order'] = FilmPortfolio::max('sort_order') + 1 ?? 0;
        $this->isCreating = true;
        $this->editingId = null;
    }

    public function store()
    {
        $this->validate();

        try {
            $filmData = $this->form;

            // Handle media attachment
            if ($this->uploadMethod === 'filepond' && !empty($this->filepondUploads)) {
                $upload = $this->filepondUploads[0] ?? null;
                if ($upload) {
                    $filmData['media_id'] = $upload['id'] ?? null;
                }
            } elseif ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $filmData['media_id'] = $this->selectedMediaId;
            }

            FilmPortfolio::create($filmData);

            $this->resetForm();
            $this->isCreating = false;

            session()->flash('success', 'Film portfolio created successfully.');

        } catch (\Exception $e) {
            Log::error('Film Portfolio Creation Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to create film portfolio. Please try again.');
        }
    }

    public function edit($filmId)
    {
        try {
            $film = FilmPortfolio::findOrFail($filmId);

            $this->form = [
                'title' => $film->title,
                'slug' => $film->slug,
                'description' => $film->description,
                'genre' => $film->genre,
                'year' => $film->year,
                'duration' => $film->duration,
                'rating' => $film->rating,
                'category_id' => $film->category_id,
                'sort_order' => $film->sort_order,
                'is_featured' => $film->is_featured,
                'is_published' => $film->is_published,
                'media_id' => $film->media_id,
            ];

            // Set media selection state
            if ($film->media_id) {
                $this->selectedMediaId = $film->media_id;
                $this->selectedMediaUrl = $film->featured_image_url;
            }

            $this->editingId = $filmId;
            $this->isCreating = false;

        } catch (\Exception $e) {
            Log::error('Film Portfolio Edit Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to load film portfolio data.');
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $film = FilmPortfolio::findOrFail($this->editingId);
            $filmData = $this->form;

            // Handle media attachment
            if ($this->uploadMethod === 'filepond' && !empty($this->filepondUploads)) {
                $upload = $this->filepondUploads[0] ?? null;
                if ($upload) {
                    $filmData['media_id'] = $upload['id'] ?? null;
                }
            } elseif ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $filmData['media_id'] = $this->selectedMediaId;
            }

            $film->update($filmData);

            $this->resetForm();
            $this->editingId = null;

            session()->flash('success', 'Film portfolio updated successfully.');

        } catch (\Exception $e) {
            Log::error('Film Portfolio Update Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to update film portfolio. Please try again.');
        }
    }

    public function delete($filmId)
    {
        try {
            $film = FilmPortfolio::findOrFail($filmId);
            $film->delete();

            session()->flash('success', 'Film portfolio deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Film Portfolio Delete Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete film portfolio.');
        }
    }

    public function cancelEdit()
    {
        $this->resetForm();
        $this->editingId = null;
        $this->isCreating = false;
    }

    public function toggleFeatured($filmId)
    {
        try {
            $film = FilmPortfolio::findOrFail($filmId);
            $film->update(['is_featured' => !$film->is_featured]);

            $message = $film->is_featured ? 'Film marked as featured.' : 'Film removed from featured.';
            session()->flash('success', $message);

        } catch (\Exception $e) {
            Log::error('Film Portfolio Toggle Featured Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to update featured status.');
        }
    }

    public function togglePublished($filmId)
    {
        try {
            $film = FilmPortfolio::findOrFail($filmId);
            $film->update(['is_published' => !$film->is_published]);

            $message = $film->is_published ? 'Film published successfully.' : 'Film unpublished successfully.';
            session()->flash('success', $message);

        } catch (\Exception $e) {
            Log::error('Film Portfolio Toggle Published Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to update publication status.');
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
            Log::info('Film Portfolio - Media selection received:', ['data' => $data]);
            
            // Handle case where data is an indexed array containing the media data
            if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                $data = $data[0];
            }

            // Add defensive programming to handle missing keys
            if (isset($data['mediaId'])) {
                $this->selectedMediaId = $data['mediaId'];
                $this->form['media_id'] = $data['mediaId'];
                Log::info('Film Portfolio - Media ID set to:', ['mediaId' => $data['mediaId']]);
            } else {
                Log::warning('Film Portfolio - mediaId not found in data:', ['data' => $data]);
            }

            if (isset($data['mediaUrl'])) {
                $this->selectedMediaUrl = $data['mediaUrl'];
                Log::info('Film Portfolio - Media URL set to:', ['mediaUrl' => $data['mediaUrl']]);
            } else {
                Log::warning('Film Portfolio - mediaUrl not found in data:', ['data' => $data]);
            }
            
            Log::info('Film Portfolio - Media selection completed', [
                'media_id' => $this->selectedMediaId,
                'url' => $this->selectedMediaUrl
            ]);
            
        } catch (\Exception $e) {
            Log::error('Film Portfolio - Media selection error: ' . $e->getMessage());
            session()->flash('error', 'Failed to select media. Please try again.');
        }
    }    public function clearSelectedMedia()
    {
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->form['media_id'] = null;
    }

    private function resetForm()
    {
        $this->form = [
            'title' => '',
            'slug' => '',
            'description' => '',
            'genre' => '',
            'year' => null,
            'duration' => '',
            'rating' => null,
            'category_id' => null,
            'sort_order' => FilmPortfolio::max('sort_order') + 1 ?? 0,
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
        $query = FilmPortfolio::query()->with(['category', 'media']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('genre', 'like', '%' . $this->search . '%');
            });
        }

        // Apply category filter
        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $films = $query->paginate($this->perPage);
        $categories = FilmCategory::orderBy('name')->get();

        return view('livewire.admin.film-portfolios.index', compact('films', 'categories'));
    }
}
