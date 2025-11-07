<?php

namespace App\Livewire\Admin\News;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\News;
use App\Models\NewsCategory;
use Spatie\LivewireFilepond\WithFilePond;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\DispatchesAlertEvents;
use App\Livewire\Admin\Traits\WithDeleteConfirmation;

class Index extends Component
{
    use WithPagination, WithFileUploads, WithFilePond, DispatchesAlertEvents, WithDeleteConfirmation;

    // Form properties
    public $form = [
        'title' => '',
        'slug' => '',
        'excerpt' => '',
        'content' => '',
        'featured_image' => '',
        'media_id' => null,
        'author_name' => '',
        'tags' => '',
        'status' => 'draft',
        'featured' => false,
        'category_id' => null,
        'published_at' => null,
    ];

    // Component state
    public $isCreating = false;
    public $editingId = null;
    public $showSlidePanel = false;
    public $isClosing = false;

    // Search and filtering
    public $search = '';
    public $statusFilter = '';
    public $categoryFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Media handling
    public $uploadMethod = 'media_library';
    public $selectedMediaId = null;
    public $selectedMediaUrl = null;
    public $filepondUploads = [];
    public $imageUploadMethod = 'library'; // 'upload' or 'library'
    public $featuredImageFile = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $listeners = [
        'mediaSelected' => 'handleMediaSelection',
    ];

    protected function rules()
    {
        $rules = [
            'form.title' => 'required|string|max:255',
            'form.slug' => 'required|string|max:255|unique:news,slug',
            'form.excerpt' => 'nullable|string|max:500',
            'form.content' => 'required|string',
            'form.featured_image' => 'nullable|url',
            'form.author_name' => 'required|string|max:255',
            'form.tags' => 'nullable|string',
            'form.status' => 'required|in:draft,published,archived',
            'form.featured' => 'boolean',
            'form.category_id' => 'nullable|exists:news_categories,id',
            'form.published_at' => 'nullable|date',
            'form.media_id' => 'nullable|exists:media,id',
        ];

        if ($this->editingId) {
            $rules['form.slug'] = 'required|string|max:255|unique:news,slug,' . $this->editingId;
        }

        return $rules;
    }

    public function mount()
    {
        $this->form['author_name'] = Auth::user()->name ?? '';
        $this->form['published_at'] = now()->format('Y-m-d\TH:i');
    }

    public function updated($property)
    {
        if (str_starts_with($property, 'form.')) {
            if ($property === 'form.title' && empty($this->form['slug'])) {
                $this->form['slug'] = Str::slug($this->form['title']);
            }
            $this->validateOnly($property);
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->form['author_name'] = Auth::user()->name ?? '';
        $this->form['published_at'] = now()->format('Y-m-d\TH:i');
        $this->isCreating = true;
        $this->editingId = null;
        $this->showSlidePanel = true;
        $this->dispatch('slidePanelOpened');
    }

    public function store()
    {
        $this->validate();

        try {
            $newsData = $this->form;

            // Convert tags string to array
            if (!empty($newsData['tags'])) {
                $newsData['tags'] = array_map('trim', explode(',', $newsData['tags']));
            } else {
                $newsData['tags'] = [];
            }

            // Handle media attachment
            if ($this->uploadMethod === 'filepond' && !empty($this->filepondUploads)) {
                $upload = $this->filepondUploads[0] ?? null;
                if ($upload) {
                    $newsData['media_id'] = $upload['id'] ?? null;
                }
            } elseif ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $newsData['media_id'] = $this->selectedMediaId;
            }

            // Auto-generate slug if empty
            if (empty($newsData['slug'])) {
                $newsData['slug'] = Str::slug($newsData['title']);
            }

            News::create($newsData);

            $this->resetForm();
            $this->isCreating = false;
            $this->showSlidePanel = false;

            $this->dispatchSuccessEvent('News article created successfully!');

        } catch (\Exception $e) {
            Log::error('News Creation Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to create news article. Please try again.');
        }
    }

    public function edit($newsId)
    {
        try {
            $news = News::findOrFail($newsId);

            $this->form = [
                'title' => $news->title,
                'slug' => $news->slug,
                'excerpt' => $news->excerpt,
                'content' => $news->content,
                'featured_image' => $news->featured_image,
                'media_id' => $news->media_id,
                'author_name' => $news->author_name,
                'tags' => is_array($news->tags) ? implode(', ', $news->tags) : $news->tags,
                'status' => $news->status,
                'featured' => $news->featured,
                'category_id' => $news->category_id,
                'published_at' => $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : null,
            ];

            // Set media selection state
            if ($news->media_id) {
                $this->selectedMediaId = $news->media_id;
                $this->selectedMediaUrl = $news->featured_image_url;
            }

            $this->editingId = $newsId;
            $this->isCreating = false;
            $this->showSlidePanel = true;
            $this->dispatch('slidePanelOpened');

            // Dispatch event to populate Quill editor after a short delay to ensure panel is rendered
            $this->dispatch('editFormPopulated', [
                'content' => $news->content ?? ''
            ]);

        } catch (\Exception $e) {
            Log::error('News Edit Error: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $news = News::findOrFail($this->editingId);
            $newsData = $this->form;

            // Convert tags string to array
            if (!empty($newsData['tags'])) {
                $newsData['tags'] = array_map('trim', explode(',', $newsData['tags']));
            } else {
                $newsData['tags'] = [];
            }

            // Handle media attachment
            if ($this->uploadMethod === 'filepond' && !empty($this->filepondUploads)) {
                $upload = $this->filepondUploads[0] ?? null;
                if ($upload) {
                    $newsData['media_id'] = $upload['id'] ?? null;
                }
            } elseif ($this->uploadMethod === 'media_library' && $this->selectedMediaId) {
                $newsData['media_id'] = $this->selectedMediaId;
            }

            $news->update($newsData);

            $this->resetForm();
            $this->editingId = null;
            $this->showSlidePanel = false;

            $this->dispatchSuccessEvent('News article updated successfully!');

        } catch (\Exception $e) {
            Log::error('News Update Error: ' . $e->getMessage());
        }
    }

    public function delete($newsId)
    {
        // Legacy direct delete kept for backward compatibility; route through confirm system
        $this->performActualDelete($newsId);
    }

    // Renamed actual delete logic
    public function performActualDelete($newsId)
    {
        try {
            $news = News::findOrFail($newsId);
            $newsTitle = $news->title;
            $news->delete();

            $this->dispatchDeleteEvent("News article '{$newsTitle}' has been successfully deleted.");

        } catch (\Exception $e) {
            Log::error('News Delete Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to delete news article. Please try again.');
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

    public function toggleFeatured($newsId)
    {
        try {
            $news = News::findOrFail($newsId);
            $news->update(['featured' => !$news->featured]);

            $message = $news->featured ? 'News marked as featured.' : 'News removed from featured.';

        } catch (\Exception $e) {
            Log::error('News Toggle Featured Error: ' . $e->getMessage());
        }
    }

    public function changeStatus($newsId, $status)
    {
        try {
            $news = News::findOrFail($newsId);
            $news->update(['status' => $status]);

            $message = ucfirst($status) . ' status applied successfully.';

        } catch (\Exception $e) {
            Log::error('News Change Status Error: ' . $e->getMessage());
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
            Log::info('News - Media selection received:', ['data' => $data]);

            // Handle case where data is an indexed array containing the media data
            if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                $data = $data[0];
            }

            // Add defensive programming to handle missing keys
            if (isset($data['mediaId'])) {
                $this->selectedMediaId = $data['mediaId'];
                $this->form['media_id'] = $data['mediaId'];
                Log::info('News - Media ID set to:', ['mediaId' => $data['mediaId']]);
            } else {
                Log::warning('News - mediaId not found in data:', ['data' => $data]);
            }

            if (isset($data['mediaUrl'])) {
                $this->selectedMediaUrl = $data['mediaUrl'];
                Log::info('News - Media URL set to:', ['mediaUrl' => $data['mediaUrl']]);
            } else {
                Log::warning('News - mediaUrl not found in data:', ['data' => $data]);
            }

            Log::info('News - Media selection completed', [
                'media_id' => $this->selectedMediaId,
                'url' => $this->selectedMediaUrl
            ]);

        } catch (\Exception $e) {
            Log::error('News - Media selection error: ' . $e->getMessage());
        }
    }

    public function clearSelectedMedia()
    {
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->form['media_id'] = null;
        $this->featuredImageFile = [];
        $this->imageUploadMethod = 'library';
    }

    private function resetForm()
    {
        $this->form = [
            'title' => '',
            'slug' => '',
            'excerpt' => '',
            'content' => '',
            'featured_image' => '',
            'media_id' => null,
            'author_name' => Auth::user()->name ?? '',
            'tags' => '',
            'status' => 'draft',
            'featured' => false,
            'category_id' => null,
            'published_at' => now()->format('Y-m-d\TH:i'),
        ];

        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->filepondUploads = [];
        $this->uploadMethod = 'media_library';

        // Dispatch event to reset Quill editors
        $this->dispatch('formReset');
    }

    public function render()
    {
        $query = News::query()->with(['media', 'category']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%')
                  ->orWhere('author_name', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Apply category filter
        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $news = $query->paginate($this->perPage);
        $categories = NewsCategory::active()->ordered()->get();

        return view('livewire.admin.news.index', compact('news', 'categories'));
    }

    public function setFeaturedImageFromUpload()
    {
        if (!empty($this->featuredImageFile)) {
            try {
                // The file is already uploaded via FilePond, we just need to set it
                // This is similar to how the media library handles uploads
                $this->selectedMediaUrl = $this->featuredImageFile[0] ?? null;

                if ($this->selectedMediaUrl) {
                    // FilePond provides a temporary path, we can use it directly
                    $this->imageUploadMethod = 'library'; // Switch to preview
                    $this->featuredImageFile = [];
                }
            } catch (\Exception $e) {
                Log::error('Failed to set featured image from upload: ' . $e->getMessage());
                $this->dispatchErrorEvent('Failed to upload featured image. Please try again.');
            }
        }
    }
}
