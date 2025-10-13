<?php

namespace App\Livewire\Admin\HeroSections;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HeroSection;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $page_filter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'page' => '',
        'title' => '',
        'subtitle' => '',
        'content' => '',
        'button_text' => '',
        'button_url' => '',
        'button_text_secondary' => '',
        'button_url_secondary' => '',
        'background_image' => '',
        'is_active' => true,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'page_filter' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPageFilter()
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
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isCreating = false;
        $heroSection = HeroSection::findOrFail($id);
        
        $this->form = [
            'page' => $heroSection->page,
            'title' => $heroSection->title,
            'subtitle' => $heroSection->subtitle,
            'content' => $heroSection->content,
            'button_text' => $heroSection->button_text,
            'button_url' => $heroSection->button_url,
            'button_text_secondary' => $heroSection->button_text_secondary,
            'button_url_secondary' => $heroSection->button_url_secondary,
            'background_image' => $heroSection->background_image,
            'is_active' => $heroSection->is_active,
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
            'form.page' => 'required|string|max:255',
            'form.title' => 'required|string|max:255',
            'form.subtitle' => 'nullable|string|max:255',
            'form.content' => 'nullable|string',
            'form.button_text' => 'nullable|string|max:255',
            'form.button_url' => 'nullable|url|max:255',
            'form.button_text_secondary' => 'nullable|string|max:255',
            'form.button_url_secondary' => 'nullable|url|max:255',
            'form.background_image' => 'nullable|string|max:255',
            'form.is_active' => 'boolean',
        ]);

        HeroSection::create($this->form);
        
        $this->isCreating = false;
        $this->reset('form');
        
        session()->flash('success', 'Hero section created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.page' => 'required|string|max:255',
            'form.title' => 'required|string|max:255',
            'form.subtitle' => 'nullable|string|max:255',
            'form.content' => 'nullable|string',
            'form.button_text' => 'nullable|string|max:255',
            'form.button_url' => 'nullable|url|max:255',
            'form.button_text_secondary' => 'nullable|string|max:255',
            'form.button_url_secondary' => 'nullable|url|max:255',
            'form.background_image' => 'nullable|string|max:255',
            'form.is_active' => 'boolean',
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
            ->when($this->page_filter, function ($query) {
                $query->where('page', $this->page_filter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $pages = HeroSection::getAvailablePages();

        return view('livewire.admin.hero-sections.index', compact('heroSections', 'pages'))
            ->layout('admin.layout', ['title' => 'Hero Sections']);
    }
}
