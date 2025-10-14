<?php

namespace App\Livewire\Admin\NewsCategories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NewsCategory;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'name' => '',
        'slug' => '',
        'description' => '',
        'sort_order' => 0,
        'is_active' => true,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
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
        $this->form['sort_order'] = NewsCategory::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $category = NewsCategory::findOrFail($id);

        $this->form = [
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'sort_order' => $category->sort_order,
            'is_active' => $category->is_active,
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
            'form.name' => 'required|string|max:255',
            'form.slug' => 'nullable|string|max:255',
            'form.description' => 'nullable|string',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        NewsCategory::create($this->form);

        $this->isCreating = false;
        $this->reset('form');

        session()->flash('success', 'News Category created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.slug' => 'nullable|string|max:255',
            'form.description' => 'nullable|string',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        $category = NewsCategory::findOrFail($this->editingId);
        $category->update($this->form);

        $this->editingId = null;
        $this->reset('form');

        session()->flash('success', 'News Category updated successfully!');
    }

    public function delete($id)
    {
        $category = NewsCategory::findOrFail($id);
        $category->delete();

        session()->flash('success', 'News Category deleted successfully!');
    }

    public function toggleActive($id)
    {
        $category = NewsCategory::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);

        session()->flash('success', 'News Category status updated successfully!');
    }

    public function render()
    {
        $categories = NewsCategory::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.news-categories.index', compact('categories'));
    }
}
