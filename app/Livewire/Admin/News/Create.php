<?php

namespace App\Livewire\Admin\News;

use Livewire\Component;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Traits\DispatchesAlertEvents;

class Create extends Component
{
    use DispatchesAlertEvents;
    // Form properties
    public $form = [
        'title' => '',
        'slug' => '',
        'excerpt' => '',
        'content' => '',
        'author_name' => '',
        'tags' => '',
        'status' => 'draft',
        'featured' => false,
        'category_id' => null,
        'published_at' => null,
    ];

    protected function rules()
    {
        return [
            'form.title' => 'required|string|max:255',
            'form.slug' => 'required|string|max:255|unique:news,slug',
            'form.excerpt' => 'nullable|string|max:500',
            'form.content' => 'required|string',
            'form.author_name' => 'required|string|max:255',
            'form.tags' => 'nullable|string',
            'form.status' => 'required|in:draft,published,archived',
            'form.featured' => 'boolean',
            'form.category_id' => 'nullable|exists:news_categories,id',
            'form.published_at' => 'nullable|date',
        ];
    }

    public function mount()
    {
        $this->form['author_name'] = Auth::user()->name ?? '';
        $this->form['published_at'] = now()->format('Y-m-d\TH:i');
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

            // Auto-generate slug if empty
            if (empty($newsData['slug'])) {
                $newsData['slug'] = Str::slug($newsData['title']);
            }

            News::create($newsData);

            // Dispatch event for create operation
            $this->dispatch('create');

            $this->resetForm();

            // Dispatch event to reset Quill editor
            $this->dispatch('formReset');

            $this->flashSuccess('News article created successfully.');

            // Redirect to news index using Livewire redirect
            $this->redirect(route('admin.news.index'));

        } catch (\Exception $e) {
            Log::error('News Creation Error: ' . $e->getMessage());
            $this->dispatchErrorEvent('Failed to create news article. Please try again.');
        }
    }

    private function resetForm()
    {
        $this->form = [
            'title' => '',
            'slug' => '',
            'excerpt' => '',
            'content' => '',
            'author_name' => Auth::user()->name ?? '',
            'tags' => '',
            'status' => 'draft',
            'featured' => false,
            'category_id' => null,
            'published_at' => now()->format('Y-m-d\TH:i'),
        ];

        // Dispatch event to reset Quill editor
        $this->dispatch('formReset');
    }

    public function render()
    {
        $categories = NewsCategory::active()->ordered()->get();
        return view('livewire.admin.news.create', compact('categories'));
    }
}

