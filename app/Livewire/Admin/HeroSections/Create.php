<?php

namespace App\Livewire\Admin\HeroSections;

use Livewire\Component;
use App\Models\HeroSection;

class Create extends Component
{
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
        'page' => 'required|string|in:home,about,partners,team,news,portfolio,contact,business|unique:hero_sections,page',
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            HeroSection::create([
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

            session()->flash('success', 'Hero section created successfully!');
            return redirect()->route('admin.hero-sections.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create hero section: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $pages = HeroSection::getAvailablePages();
        
        return view('livewire.admin.hero-sections.create', compact('pages'))
            ->layout('admin.layout', ['title' => 'Create Hero Section']);
    }
}
