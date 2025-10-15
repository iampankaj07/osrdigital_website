<?php

namespace App\Livewire\Admin\News;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\News;
use App\Models\NewsCategory;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Traits\DispatchesAlertEvents;

class Edit extends Component
{
    use WithFileUploads, WithFilePond, DispatchesAlertEvents;

    public $newsId;
    public $news;

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

    // Media handling
    public $uploadMethod = 'media_library';
    public $selectedMediaId = null;
    public $selectedMediaUrl = null;
    public $filepondUploads = [];

    protected $listeners = [
        'mediaSelected' => 'handleMediaSelection',
    ];

    protected function rules()
    {
        return [
            'form.title' => 'required|string|max:255',
            'form.slug' => 'required|string|max:255|unique:news,slug,' . $this->newsId,
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
    }

    public function mount($newsId)
    {
        $this->newsId = $newsId;
        $this->loadNews();
    }

    public function loadNews()
    {
        try {
            $this->news = News::findOrFail($this->newsId);

            $this->form = [
                'title' => $this->news->title,
                'slug' => $this->news->slug,
                'excerpt' => $this->news->excerpt,
                'content' => $this->news->content,
                'featured_image' => $this->news->featured_image,
                'media_id' => $this->news->media_id,
                'author_name' => $this->news->author_name,
                'tags' => is_array($this->news->tags) ? implode(', ', $this->news->tags) : $this->news->tags,
                'status' => $this->news->status,
                'featured' => $this->news->featured,
                'category_id' => $this->news->category_id,
                'published_at' => $this->news->published_at ? $this->news->published_at->format('Y-m-d\TH:i') : null,
            ];

            // Set media selection state
            if ($this->news->media_id) {
                $this->selectedMediaId = $this->news->media_id;
                $this->selectedMediaUrl = $this->news->featured_image_url;
            }

            // Dispatch event to populate Quill editor
            $this->dispatch('editFormPopulated', [
                'content' => $this->news->content
            ]);

            Log::info('Edit form populated with content length: ' . strlen($this->news->content ?? ''));

        } catch (\Exception $e) {
            Log::error('News Edit Load Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to load news article data.');
            return redirect()->route('admin.news.index');
        }
    }

    public function updated($property)
    {
        if (str_starts_with($property, 'form.')) {
            // Don't auto-validate content changes to prevent interference with editor
            if ($property !== 'form.content') {
                if ($property === 'form.title' && empty($this->form['slug'])) {
                    $this->form['slug'] = Str::slug($this->form['title']);
                }
                $this->validateOnly($property);
            }
        }
    }

    public function update()
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

            $this->news->update($newsData);

            // Ensure the form content is synced with the updated data
            $this->form['content'] = $this->news->fresh()->content;

            // Dispatch event to refresh Quill editor content without destroying it
            $this->dispatch('refreshEditorContent', [
                'content' => $this->form['content']
            ]);

            $this->flashSuccess('News article updated successfully.');

        } catch (\Exception $e) {
            Log::error('News Update Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to update news article. Please try again.');
        }
    }

    public function openMediaSelector()
    {
        $this->dispatch('openMediaSelector');
    }

    public function handleMediaSelection($data)
    {
        try {
            Log::info('News Edit - Media selection received:', ['data' => $data]);

            // Handle case where data is an indexed array containing the media data
            if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                $data = $data[0];
            }

            // Add defensive programming to handle missing keys
            if (isset($data['mediaId'])) {
                $this->selectedMediaId = $data['mediaId'];
                $this->form['media_id'] = $data['mediaId'];
                Log::info('News Edit - Media ID set to:', ['mediaId' => $data['mediaId']]);
            } else {
                Log::warning('News Edit - mediaId not found in data:', ['data' => $data]);
            }

            if (isset($data['mediaUrl'])) {
                $this->selectedMediaUrl = $data['mediaUrl'];
                Log::info('News Edit - Media URL set to:', ['mediaUrl' => $data['mediaUrl']]);
            } else {
                Log::warning('News Edit - mediaUrl not found in data:', ['data' => $data]);
            }

            Log::info('News Edit - Media selection completed', [
                'media_id' => $this->selectedMediaId,
                'url' => $this->selectedMediaUrl
            ]);

        } catch (\Exception $e) {
            Log::error('News Edit - Media selection error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to select media. Please try again.');
        }
    }

    public function clearSelectedMedia()
    {
        $this->selectedMediaId = null;
        $this->selectedMediaUrl = null;
        $this->form['media_id'] = null;
    }

    public function refreshContent()
    {
        // Method to manually refresh content in the editor
        $this->dispatch('editFormPopulated', [
            'content' => $this->form['content']
        ]);

        Log::info('Content refreshed manually. Content length: ' . strlen($this->form['content'] ?? ''));
    }

    public function render()
    {
        $categories = NewsCategory::active()->ordered()->get();
        return view('livewire.admin.news.edit', compact('categories'));
    }
}

