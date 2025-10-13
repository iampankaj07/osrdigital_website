<?php

namespace App\Livewire\Admin\News;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\News;
use App\Models\NewsCategory;

class Index extends Component
{
    use WithPagination;

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

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'published_at'],
        'sortDirection' => ['except' => 'desc'],
        'statusFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
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
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->reset('form');
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

        $newsData = $this->form;
        if (empty($newsData['slug'])) {
            $newsData['slug'] = \Str::slug($newsData['title']);
        }
        if ($newsData['published_at']) {
            $newsData['published_at'] = \Carbon\Carbon::parse($newsData['published_at']);
        }

        News::create($newsData);
        
        $this->isCreating = false;
        $this->reset('form');
        
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

        $news = News::findOrFail($this->editingId);
        $newsData = $this->form;
        if (empty($newsData['slug'])) {
            $newsData['slug'] = \Str::slug($newsData['title']);
        }
        if ($newsData['published_at']) {
            $newsData['published_at'] = \Carbon\Carbon::parse($newsData['published_at']);
        }

        $news->update($newsData);
        
        $this->editingId = null;
        $this->reset('form');
        
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
