<?php

namespace App\Livewire\Admin\HeroSections;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HeroSection;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'title' => '',
        'subtitle' => '',
        'content' => '',
        'button_text' => '',
        'button_url' => '',
        'button_text_secondary' => '',
        'button_url_secondary' => '',
        'background_type' => 'color',
        'background_color' => '',
        'background_image' => '',
        'text_color' => '#ffffff',
        'is_active' => true,
        'sort_order' => 0,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
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

    public function delete($id)
    {
        $heroSection = HeroSection::findOrFail($id);
        $heroSection->delete();

        session()->flash('success', 'Hero section deleted successfully!');
    }

    public function toggleActive($id)
    {
        $heroSection = HeroSection::findOrFail($id);
        $heroSection->update(['is_active' => !$heroSection->is_active]);

        session()->flash('success', 'Hero section status updated successfully!');
    }

    public function create()
    {
        $this->isCreating = true;
        $this->editingId = null;
        $this->reset('form');
        $this->form['is_active'] = true;
        $this->form['background_type'] = 'color';
        $this->form['text_color'] = '#ffffff';
        $this->form['sort_order'] = HeroSection::max('sort_order') + 1;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $heroSection = HeroSection::findOrFail($id);

        $this->form = [
            'title' => $heroSection->title,
            'subtitle' => $heroSection->subtitle,
            'content' => $heroSection->content,
            'button_text' => $heroSection->button_text,
            'button_url' => $heroSection->button_url,
            'button_text_secondary' => $heroSection->button_text_secondary,
            'button_url_secondary' => $heroSection->button_url_secondary,
            'background_type' => $heroSection->background_type,
            'background_color' => $heroSection->background_color,
            'background_image' => $heroSection->background_image,
            'text_color' => $heroSection->text_color,
            'is_active' => $heroSection->is_active,
            'sort_order' => $heroSection->sort_order,
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
            'form.subtitle' => 'nullable|string|max:255',
            'form.content' => 'nullable|string',
            'form.button_text' => 'nullable|string|max:255',
            'form.button_url' => 'nullable|url|max:255',
            'form.button_text_secondary' => 'nullable|string|max:255',
            'form.button_url_secondary' => 'nullable|url|max:255',
            'form.background_type' => 'required|in:color,image',
            'form.background_color' => 'nullable|string|max:7',
            'form.background_image' => 'nullable|string|max:255',
            'form.text_color' => 'required|string|max:7',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        HeroSection::create($this->form);

        $this->isCreating = false;
        $this->reset('form');

        session()->flash('success', 'Hero section created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.subtitle' => 'nullable|string|max:255',
            'form.content' => 'nullable|string',
            'form.button_text' => 'nullable|string|max:255',
            'form.button_url' => 'nullable|url|max:255',
            'form.button_text_secondary' => 'nullable|string|max:255',
            'form.button_url_secondary' => 'nullable|url|max:255',
            'form.background_type' => 'required|in:color,image',
            'form.background_color' => 'nullable|string|max:7',
            'form.background_image' => 'nullable|string|max:255',
            'form.text_color' => 'required|string|max:7',
            'form.is_active' => 'boolean',
            'form.sort_order' => 'required|integer|min:0',
        ]);

        $heroSection = HeroSection::findOrFail($this->editingId);
        $heroSection->update($this->form);

        $this->editingId = null;
        $this->reset('form');

        session()->flash('success', 'Hero section updated successfully!');
    }

    public function render()
    {
        $heroSections = HeroSection::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('subtitle', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })

            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.hero-sections.index', compact('heroSections'));
    }
}
