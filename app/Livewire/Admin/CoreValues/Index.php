<?php

namespace App\Livewire\Admin\CoreValues;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CoreValue;
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
    public $form = [
        'title' => '',
        'description' => '',
        'icon' => '',
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
        $this->form['sort_order'] = CoreValue::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $coreValue = CoreValue::findOrFail($id);

        $this->form = [
            'title' => $coreValue->title,
            'description' => $coreValue->description,
            'icon' => $coreValue->icon,
            'sort_order' => $coreValue->sort_order,
            'is_active' => $coreValue->is_active,
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
            'form.description' => 'required|string',
            'form.icon' => 'nullable|string|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        CoreValue::create($this->form);

        $this->isCreating = false;
        $this->reset('form');

        $this->flashSuccess('Core Value created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.icon' => 'nullable|string|max:255',
            'form.sort_order' => 'required|integer|min:0',
            'form.is_active' => 'boolean',
        ]);

        $coreValue = CoreValue::findOrFail($this->editingId);
        $coreValue->update($this->form);

        $this->editingId = null;
        $this->reset('form');

        $this->flashSuccess('Core Value updated successfully!');
    }

    public function delete($id)
    {
        $coreValue = CoreValue::findOrFail($id);
        $coreValueTitle = $coreValue->title;
        $coreValue->delete();

        $this->flashDelete("Core Value '{$coreValueTitle}' has been successfully deleted.");
    }

    public function toggleActive($id)
    {
        $coreValue = CoreValue::findOrFail($id);
        $coreValue->update(['is_active' => !$coreValue->is_active]);

        $status = $coreValue->is_active ? 'activated' : 'deactivated';
        $this->dispatchSuccessEvent("Core Value '{$coreValue->title}' has been {$status}.");
    }

    public function render()
    {
        $coreValues = CoreValue::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.core-values.index', compact('coreValues'))
            ->layout('admin.layout', ['title' => 'Core Values']);
    }
}
