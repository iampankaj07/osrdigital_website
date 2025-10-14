<?php

namespace App\Livewire\Admin\News;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\News;
use App\Models\NewsCategory;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'published_at';
    public $sortDirection = 'desc';
    public $statusFilter = '';
    public $categoryFilter = '';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'title' => '',
        'slug' => '',
        'excerpt' => '',
        'content' => '',
        'featured_image' => '',
        'author_name' => '',
        'tags' => [],
        'status' => 'draft',
        'featured' => false,
        'category_id' => '',
        'published_at' => '',
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
        'sortField' => ['except' => 'published_at'],
        'sortDirection' => ['except' => 'desc'],
        'statusFilter' => ['except' => ''],
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

    public function updatingStatusFilter()
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
        $this->form['published_at'] = now()->format('Y-m-d\TH:i');
        $this->form['tags'] = [];
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $news = News::findOrFail($id);

        $this->form = [
            'title' => $news->title,
            'slug' => $news->slug,
            'excerpt' => $news->excerpt,
            'content' => $news->content,
            'featured_image' => $news->featured_image,
            'author_name' => $news->author_name,
            'tags' => $news->tags ?? [],
            'status' => $news->status,
            'featured' => $news->featured,
            'category_id' => $news->category_id,
            'published_at' => $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '',
        ];

        $this->resetUploadStates();

        // Load existing media selection if available
        if ($news->media_id) {
            $this->selectedMediaId = $news->media_id;
            $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($news->media_id);
            if ($media) {
                $this->selectedMediaUrl = $media->getFullUrl();
                $this->uploadMethod = 'media_library';
            }
        } else {
            // Default to filepond for existing news without media
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
            'form.excerpt' => 'nullable|string',
            'form.content' => 'required|string',
            'form.featured_image' => 'nullable|string|max:255',
            'form.author_name' => 'required|string|max:255',
            'form.tags' => 'nullable|array',
            'form.status' => 'required|in:draft,published',
            'form.featured' => 'boolean',
            'form.category_id' => 'nullable|exists:news_categories,id',
            'form.published_at' => 'nullable|date',
        ]);

        $user = Auth::user();
        $newsData = $this->form;

        // Handle media uploads
        if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
            $newsData['media_id'] = $this->selectedMediaId;
            $newsData['featured_image'] = null; // Clear featured_image field when using media library
        } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
            // Process FilePond uploads
            foreach ($this->filepondUploads as $upload) {
                $media = $user->addMedia($upload->getRealPath())
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $newsData['media_id'] = $media->id;
                $newsData['featured_image'] = null; // Clear featured_image field when using FilePond
                break; // Only take the first file for featured image
            }
        }

        if (empty($newsData['slug'])) {
            $newsData['slug'] = \Str::slug($newsData['title']);
        }
        if ($newsData['published_at']) {
            $newsData['published_at'] = \Carbon\Carbon::parse($newsData['published_at']);
        }

        News::create($newsData);

        $this->isCreating = false;
        $this->reset('form');
        $this->resetUploadStates();

        session()->flash('success', 'News article created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.slug' => 'nullable|string|max:255',
            'form.excerpt' => 'nullable|string',
            'form.content' => 'required|string',
            'form.featured_image' => 'nullable|string|max:255',
            'form.author_name' => 'required|string|max:255',
            'form.tags' => 'nullable|array',
            'form.status' => 'required|in:draft,published',
            'form.featured' => 'boolean',
            'form.category_id' => 'nullable|exists:news_categories,id',
            'form.published_at' => 'nullable|date',
        ]);

        $user = Auth::user();
        $news = News::findOrFail($this->editingId);
        $newsData = $this->form;

        // Handle media uploads
        if ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
            $newsData['media_id'] = $this->selectedMediaId;
            $newsData['featured_image'] = null; // Clear featured_image field when using media library
        } elseif ($this->uploadMethod === 'filepond' && count($this->filepondUploads) > 0) {
            // Process FilePond uploads
            foreach ($this->filepondUploads as $upload) {
                $media = $user->addMedia($upload->getRealPath())
                    ->usingName(pathinfo($upload->getClientOriginalName(), PATHINFO_FILENAME))
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('media-library');

                $newsData['media_id'] = $media->id;
                $newsData['featured_image'] = null; // Clear featured_image field when using FilePond
                break; // Only take the first file for featured image
            }
        }

        if (empty($newsData['slug'])) {
            $newsData['slug'] = \Str::slug($newsData['title']);
        }
        if ($newsData['published_at']) {
            $newsData['published_at'] = \Carbon\Carbon::parse($newsData['published_at']);
        }

        $news->update($newsData);

        $this->editingId = null;
        $this->reset('form');
        $this->resetUploadStates();

        session()->flash('success', 'News article updated successfully!');
    }

    public function delete($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        session()->flash('success', 'News article deleted successfully!');
    }

    public function toggleFeatured($id)
    {
        $news = News::findOrFail($id);
        $news->update(['featured' => !$news->featured]);

        session()->flash('success', 'News article featured status updated successfully!');
    }

    public function toggleStatus($id)
    {
        $news = News::findOrFail($id);
        $newStatus = $news->status === 'published' ? 'draft' : 'published';
        $news->update(['status' => $newStatus]);

        session()->flash('success', 'News article status updated successfully!');
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
        $news = News::with('category')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                      ->orWhere('author_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $categories = NewsCategory::orderBy('name')->get();

        return view('livewire.admin.news.index', compact('news', 'categories'))
            ->layout('admin.layout', ['title' => 'News']);
    }
}
