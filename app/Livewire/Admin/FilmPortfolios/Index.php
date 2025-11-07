<?php

namespace App\Livewire\Admin\FilmPortfolios;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FilmPortfolio;
use App\Models\FilmCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Livewire\Admin\Traits\WithDeleteConfirmation;
use App\Traits\DispatchesAlertEvents;

class Index extends Component
{
    use WithPagination, WithDeleteConfirmation, DispatchesAlertEvents;

    // Form properties
    public $form = [
        'title' => '',
        'slug' => '',
        'description' => '',
        'genre' => '',
        'year' => null,
        'duration' => '',
        'rating' => null,
        'link' => '',
        'category_id' => null,
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
    public $categoryFilter = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Media handling
    public $selectedMediaId = null;
    public $selectedMediaUrl = null;

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
            'form.link' => 'nullable|url|max:500',
            'form.category_id' => 'nullable|exists:film_categories,id',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_featured' => 'boolean',
            'form.is_published' => 'boolean',
            'form.media_id' => 'nullable|exists:media,id',
        ];
    }

    protected function messages()
    {
        return [
            'form.title.required' => 'The film title is required.',
            'form.title.string' => 'The film title must be a valid text.',
            'form.title.max' => 'The film title may not be greater than 255 characters.',
            'form.slug.string' => 'The slug must be a valid text.',
            'form.slug.max' => 'The slug may not be greater than 255 characters.',
            'form.slug.unique' => 'This slug is already taken.',
            'form.description.string' => 'The description must be a valid text.',
            'form.genre.string' => 'The genre must be a valid text.',
            'form.genre.max' => 'The genre may not be greater than 100 characters.',
            'form.year.integer' => 'The year must be a valid number.',
            'form.year.min' => 'The year must be at least 1900.',
            'form.year.max' => 'The year may not be greater than ' . (date('Y') + 5) . '.',
            'form.duration.string' => 'The duration must be a valid text.',
            'form.duration.max' => 'The duration may not be greater than 50 characters.',
            'form.rating.numeric' => 'The rating must be a valid number.',
            'form.rating.min' => 'The rating must be at least 0.',
            'form.rating.max' => 'The rating may not be greater than 10.',
            'form.link.url' => 'The link must be a valid URL.',
            'form.link.max' => 'The link may not be greater than 500 characters.',
            'form.category_id.exists' => 'The selected category is invalid.',
            'form.sort_order.required' => 'The sort order is required.',
            'form.sort_order.integer' => 'The sort order must be a valid number.',
            'form.sort_order.min' => 'The sort order must be at least 0.',
            'form.is_featured.boolean' => 'The featured status must be true or false.',
            'form.is_published.boolean' => 'The published status must be true or false.',
            'form.media_id.exists' => 'The selected media is invalid.',
        ];
    }

    protected function attributes()
    {
        return [
            'form.title' => 'film title',
            'form.slug' => 'slug',
            'form.description' => 'description',
            'form.genre' => 'genre',
            'form.year' => 'year',
            'form.duration' => 'duration',
            'form.rating' => 'rating',
            'form.link' => 'link',
            'form.category_id' => 'category',
            'form.sort_order' => 'sort order',
            'form.is_featured' => 'featured status',
            'form.is_published' => 'published status',
            'form.media_id' => 'media',
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
        $this->showSlidePanel = true;
    }

    public function store()
    {
        $this->validate();

        try {
            $filmData = $this->form;

            // Handle media attachment
            if ($this->selectedMediaId) {
                $filmData['media_id'] = $this->selectedMediaId;
            }

            FilmPortfolio::create($filmData);

            // Dispatch create event
            $this->dispatch('create');

            $this->resetForm();
            $this->isCreating = false;
            $this->showSlidePanel = false;

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
                'link' => $film->link,
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
            $this->showSlidePanel = true;

            // Form populated with film data

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
            if ($this->selectedMediaId) {
                $filmData['media_id'] = $this->selectedMediaId;
            }

            $film->update($filmData);

            // Dispatch update event
            $this->dispatch('update');

            $this->resetForm();
            $this->editingId = null;
            $this->showSlidePanel = false;

            session()->flash('success', 'Film portfolio updated successfully.');

        } catch (\Exception $e) {
            Log::error('Film Portfolio Update Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to update film portfolio. Please try again.');

        }
    }

    public function delete($filmId)
    {
        // Legacy direct delete kept for backward compatibility; route through confirm system
        $this->performActualDelete($filmId);
    }

    // Renamed actual delete logic
    public function performActualDelete($filmId)
    {
        try {
            $film = FilmPortfolio::findOrFail($filmId);
            $filmTitle = $film->title;
            $film->delete();

            $this->flashDelete("Film portfolio '{$filmTitle}' has been successfully deleted.");

        } catch (\Exception $e) {
            Log::error('Film Portfolio Delete Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to delete film portfolio. Please try again.');

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
            'link' => '',
            'category_id' => null,
            'sort_order' => FilmPortfolio::max('sort_order') + 1 ?? 0,
            'is_featured' => false,
            'is_published' => false,
            'media_id' => null,
        ];

        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;

        // Form has been reset
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
