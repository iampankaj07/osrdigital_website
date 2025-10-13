<?php

namespace App\Livewire\Admin\HomeHeroSection;

use App\Models\HeroSection;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'sort_order';
    public $sortDirection = 'asc';
    
    // Form properties
    public $isCreating = false;
    public $editingId = null;
    public $form = [
        'title' => '',
        'subtitle' => '',
        'content' => '',
        'button_text' => '',
        'button_url' => '',
        'button_text_secondary' => '',
        'button_url_secondary' => '',
        'background_type' => 'color',
        'background_color' => '#007bff',
        'background_image' => null,
        'text_color' => '#ffffff',
        'sort_order' => 0,
        'is_active' => true
    ];
    
    public $backgroundImage;
    public $showImageUpload = false;

    protected $rules = [
        'form.title' => 'required|string|max:255',
        'form.subtitle' => 'nullable|string',
        'form.content' => 'nullable|string',
        'form.button_text' => 'nullable|string|max:255',
        'form.button_url' => 'nullable|url',
        'form.button_text_secondary' => 'nullable|string|max:255',
        'form.button_url_secondary' => 'nullable|url',
        'form.background_type' => 'required|in:color,image',
        'form.background_color' => 'nullable|string',
        'form.text_color' => 'required|string',
        'form.sort_order' => 'required|integer|min:0',
        'form.is_active' => 'boolean',
        'backgroundImage' => 'nullable|image|max:2048'
    ];

    public function render()
    {
        $heroSections = HeroSection::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.home-hero-section.index', compact('heroSections'));
    }

    public function create()
    {
        $this->resetForm();
        $this->isCreating = true;
        $this->editingId = null;
    }

    public function edit($id)
    {
        $heroSection = HeroSection::findOrFail($id);
        $this->form = $heroSection->toArray();
        $this->editingId = $id;
        $this->isCreating = false;
    }

    public function store()
    {
        $this->validate();

        if ($this->backgroundImage) {
            $this->form['background_image'] = $this->backgroundImage->store('hero-sections', 'public');
        }

        HeroSection::create($this->form);

        $this->resetForm();
        $this->isCreating = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Hero section created successfully!');
    }

    public function update()
    {
        $this->validate();

        $heroSection = HeroSection::findOrFail($this->editingId);

        if ($this->backgroundImage) {
            // Delete old image if exists
            if ($heroSection->background_image) {
                Storage::disk('public')->delete($heroSection->background_image);
            }
            $this->form['background_image'] = $this->backgroundImage->store('hero-sections', 'public');
        }

        $heroSection->update($this->form);

        $this->resetForm();
        $this->editingId = null;
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Hero section updated successfully!');
    }

    public function delete($id)
    {
        $heroSection = HeroSection::findOrFail($id);
        
        // Delete background image if exists
        if ($heroSection->background_image) {
            Storage::disk('public')->delete($heroSection->background_image);
        }
        
        $heroSection->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Hero section deleted successfully!');
    }

    public function toggleActive($id)
    {
        $heroSection = HeroSection::findOrFail($id);
        $heroSection->update(['is_active' => !$heroSection->is_active);
        $this->dispatch('toast', ['type' => 'info', 'message' => 'Hero section status updated!');
    }

    public function cancelEdit()
    {
        $this->resetForm();
        $this->isCreating = false;
        $this->editingId = null;
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

    public function toggleImageUpload()
    {
        $this->showImageUpload = !$this->showImageUpload;
    }

    private function resetForm()
    {
        $this->form = [
            'title' => '',
            'subtitle' => '',
            'content' => '',
            'button_text' => '',
            'button_url' => '',
            'button_text_secondary' => '',
            'button_url_secondary' => '',
            'background_type' => 'color',
            'background_color' => '#007bff',
            'background_image' => null,
            'text_color' => '#ffffff',
            'sort_order' => 0,
            'is_active' => true
        ];
        $this->backgroundImage = null;
        $this->showImageUpload = false;
    }
}
