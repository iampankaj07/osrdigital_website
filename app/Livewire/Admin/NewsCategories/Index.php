<?php

namespace App\Livewire\Admin\NewsCategories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NewsCategory;
use App\Traits\DispatchesAlertEvents;

class Index extends Component
{
    use WithPagination, DispatchesAlertEvents;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $showSlidePanel = false;
    public $isClosing = false;
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

    public function updated($property)
    {
        if ($property === 'form.name') {
            $this->form['slug'] = \Illuminate\Support\Str::slug($this->form['name']);
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

    public function create()
    {
        $this->isCreating = true;
        $this->editingId = null;
        $this->reset('form');
        $this->form['sort_order'] = NewsCategory::max('sort_order') + 1;
        $this->showSlidePanel = true;
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
        $this->showSlidePanel = true;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->reset('form');
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
        $this->reset('form');
        $this->editingId = null;
        $this->isCreating = false;
    }

    public function store()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.slug' => 'nullable|string|max:255',
            'form.description' => 'nullable|string',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ], [
            'form.name.required' => 'The category name is required.',
            'form.name.string' => 'The category name must be a valid text.',
            'form.name.max' => 'The category name may not be greater than 255 characters.',
            'form.slug.string' => 'The slug must be a valid text.',
            'form.slug.max' => 'The slug may not be greater than 255 characters.',
            'form.description.string' => 'The description must be a valid text.',
            'form.sort_order.required' => 'The sort order is required.',
            'form.sort_order.integer' => 'The sort order must be a valid number.',
            'form.sort_order.min' => 'The sort order must be at least 0.',
            'form.is_active.boolean' => 'The active status must be true or false.',
        ], [
            'form.name' => 'category name',
            'form.slug' => 'slug',
            'form.description' => 'description',
            'form.sort_order' => 'sort order',
            'form.is_active' => 'active status',
        ]);

        NewsCategory::create($this->form);

        $this->isCreating = false;
        $this->showSlidePanel = false;
        $this->reset('form');

        $this->flashSuccess('News Category created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.slug' => 'nullable|string|max:255',
            'form.description' => 'nullable|string',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ], [
            'form.name.required' => 'The category name is required.',
            'form.name.string' => 'The category name must be a valid text.',
            'form.name.max' => 'The category name may not be greater than 255 characters.',
            'form.slug.string' => 'The slug must be a valid text.',
            'form.slug.max' => 'The slug may not be greater than 255 characters.',
            'form.description.string' => 'The description must be a valid text.',
            'form.sort_order.required' => 'The sort order is required.',
            'form.sort_order.integer' => 'The sort order must be a valid number.',
            'form.sort_order.min' => 'The sort order must be at least 0.',
            'form.is_active.boolean' => 'The active status must be true or false.',
        ], [
            'form.name' => 'category name',
            'form.slug' => 'slug',
            'form.description' => 'description',
            'form.sort_order' => 'sort order',
            'form.is_active' => 'active status',
        ]);

        $category = NewsCategory::findOrFail($this->editingId);
        $category->update($this->form);

        $this->editingId = null;
        $this->showSlidePanel = false;
        $this->reset('form');

        $this->flashSuccess('News Category updated successfully!');
    }

    public function delete($id)
    {
        $category = NewsCategory::findOrFail($id);
        $category->delete();

        $this->flashDelete('News Category has been successfully deleted.');
    }

    public function toggleActive($id)
    {
        $category = NewsCategory::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);

        $this->dispatchSuccessEvent('News Category status updated successfully!');
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
