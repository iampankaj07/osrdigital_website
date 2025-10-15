<?php

namespace App\Livewire\Admin\HeroSections;

use Livewire\Component;
use App\Models\HeroSection;

class Edit extends Component
{
    public HeroSection $heroSection;
    public $page = '';
    public $title = '';
    public $subtitle = '';
    public $content = '';
    public $button_text = '';
    public $button_link = '';
    public $button_text_secondary = '';
    public $button_link_secondary = '';
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'page' => 'required|string|in:home,about,partners,team,news,portfolio,contact|unique:hero_sections,page,' . 'heroSection.id',
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:500',
        'content' => 'required|string',
        'button_text' => 'nullable|string|max:100',
        'button_link' => 'nullable|string|max:255',
        'button_text_secondary' => 'nullable|string|max:100',
        'button_link_secondary' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'sort_order' => 'integer|min:0',
    ];

    public function mount(HeroSection $heroSection)
    {
        $this->heroSection = $heroSection;
        $this->page = $heroSection->page;
        $this->title = $heroSection->title;
        $this->subtitle = $heroSection->subtitle;
        $this->content = $heroSection->content;
        $this->button_text = $heroSection->button_text;
        $this->button_link = $heroSection->button_link;
        $this->button_text_secondary = $heroSection->button_text_secondary;
        $this->button_link_secondary = $heroSection->button_link_secondary;
        $this->is_active = $heroSection->is_active;
        $this->sort_order = $heroSection->sort_order;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            $this->heroSection->update([
                'page' => $this->page,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'content' => $this->content,
                'button_text' => $this->button_text,
                'button_link' => $this->button_link,
                'button_text_secondary' => $this->button_text_secondary,
                'button_link_secondary' => $this->button_link_secondary,
                'is_active' => $this->is_active,
                'sort_order' => $this->sort_order,
            ]);

            session()->flash('success', 'Hero section updated successfully!');
            $this->redirect(route('admin.hero-sections.index'));

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update hero section: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $pages = HeroSection::getAvailablePages();
        
        return view('livewire.admin.hero-sections.edit', compact('pages'))
            ->layout('admin.layout', ['title' => 'Edit Hero Section']);
    }
}
