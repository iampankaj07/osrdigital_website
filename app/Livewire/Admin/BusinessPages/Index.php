<?php

namespace App\Livewire\Admin\BusinessPages;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\BusinessPage;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'title' => '',
        'subtitle' => '',
        'description' => '',
        'meta_title' => '',
        'meta_description' => '',
        'hero_image' => '',
        'hero_video' => '',
        'content_sections' => [],
        'features' => [],
        'statistics' => [],
        'call_to_action' => [],
        'is_active' => true,
        'sort_order' => 0,
    ];

    public $newSection = [
        'type' => 'text',
        'title' => '',
        'content' => '',
        'image' => '',
    ];

    public $newFeature = [
        'title' => '',
        'description' => '',
        'icon' => '',
        'image' => '',
    ];

    public $newStatistic = [
        'label' => '',
        'value' => '',
        'suffix' => '',
        'icon' => '',
    ];

    public $heroImageUpload;
    public $uploadedImages = [];

    protected $rules = [
        'form.title' => 'required|string|max:255',
        'form.subtitle' => 'nullable|string|max:255',
        'form.description' => 'nullable|string',
        'form.meta_title' => 'nullable|string|max:255',
        'form.meta_description' => 'nullable|string|max:500',
        'form.hero_image' => 'nullable|string',
        'form.hero_video' => 'nullable|url',
        'form.is_active' => 'boolean',
        'form.sort_order' => 'integer|min:0',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function startCreating()
    {
        $this->isCreating = true;
        $this->editingId = null;
        $this->resetForm();
        $this->form['sort_order'] = BusinessPage::max('sort_order') + 1;
    }

    public function startEditing($id)
    {
        $businessPage = BusinessPage::findOrFail($id);
        $this->editingId = $id;
        $this->isCreating = false;

        $this->form = [
            'title' => $businessPage->title,
            'subtitle' => $businessPage->subtitle,
            'description' => $businessPage->description,
            'meta_title' => $businessPage->meta_title,
            'meta_description' => $businessPage->meta_description,
            'hero_image' => $businessPage->hero_image,
            'hero_video' => $businessPage->hero_video,
            'content_sections' => $businessPage->content_sections ?? [],
            'features' => $businessPage->features ?? [],
            'statistics' => $businessPage->statistics ?? [],
            'call_to_action' => $businessPage->call_to_action ?? [],
            'is_active' => $businessPage->is_active,
            'sort_order' => $businessPage->sort_order,
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->isCreating) {
                BusinessPage::create($this->form);
                session()->flash('message', 'Business page created successfully!');
            } else {
                $businessPage = BusinessPage::findOrFail($this->editingId);
                $businessPage->update($this->form);
                session()->flash('message', 'Business page updated successfully!');
            }

            $this->cancelEditing();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving business page: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $businessPage = BusinessPage::findOrFail($id);
            $businessPage->delete();
            session()->flash('message', 'Business page deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting business page: ' . $e->getMessage());
        }
    }

    public function cancelEditing()
    {
        $this->editingId = null;
        $this->isCreating = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'meta_title' => '',
            'meta_description' => '',
            'hero_image' => '',
            'hero_video' => '',
            'content_sections' => [],
            'features' => [],
            'statistics' => [],
            'call_to_action' => [],
            'is_active' => true,
            'sort_order' => 0,
        ];
        $this->resetValidation();
    }

    // Content Sections Management
    public function addContentSection()
    {
        $this->validate([
            'newSection.title' => 'required|string|max:255',
            'newSection.content' => 'required|string',
        ]);

        $this->form['content_sections'][] = array_merge($this->newSection, [
            'id' => Str::uuid()->toString(),
        ]);

        $this->newSection = [
            'type' => 'text',
            'title' => '',
            'content' => '',
            'image' => '',
        ];
    }

    public function removeContentSection($index)
    {
        unset($this->form['content_sections'][$index]);
        $this->form['content_sections'] = array_values($this->form['content_sections']);
    }

    // Features Management
    public function addFeature()
    {
        $this->validate([
            'newFeature.title' => 'required|string|max:255',
            'newFeature.description' => 'required|string',
        ]);

        $this->form['features'][] = array_merge($this->newFeature, [
            'id' => Str::uuid()->toString(),
        ]);

        $this->newFeature = [
            'title' => '',
            'description' => '',
            'icon' => '',
            'image' => '',
        ];
    }

    public function removeFeature($index)
    {
        unset($this->form['features'][$index]);
        $this->form['features'] = array_values($this->form['features']);
    }

    // Statistics Management
    public function addStatistic()
    {
        $this->validate([
            'newStatistic.label' => 'required|string|max:255',
            'newStatistic.value' => 'required|string|max:255',
        ]);

        $this->form['statistics'][] = array_merge($this->newStatistic, [
            'id' => Str::uuid()->toString(),
        ]);

        $this->newStatistic = [
            'label' => '',
            'value' => '',
            'suffix' => '',
            'icon' => '',
        ];
    }

    public function removeStatistic($index)
    {
        unset($this->form['statistics'][$index]);
        $this->form['statistics'] = array_values($this->form['statistics']);
    }

    public function updatedHeroImageUpload()
    {
        $this->validate([
            'heroImageUpload' => 'image|max:2048', // 2MB Max
        ]);

        $path = $this->heroImageUpload->store('business', 'public');
        $this->form['hero_image'] = $path;
    }

    public function render()
    {
        $businessPages = BusinessPage::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('subtitle', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.business-pages.index', [
            'businessPages' => $businessPages,
        ]);
    }
}
