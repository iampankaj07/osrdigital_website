<?php

namespace App\Livewire\Admin\LegalPages;

use Livewire\Component;
use App\Models\LegalPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    public $selectedPageType = 'privacy_policy';
    public $editingId = null;

    // Form properties
    public $form = [
        'title' => '',
        'slug' => '',
        'content' => '',
        'excerpt' => '',
        'meta_title' => '',
        'meta_description' => '',
        'is_published' => true,
    ];

    protected function rules()
    {
        return [
            'form.title' => 'required|string|max:255',
            'form.slug' => 'required|string|max:255',
            'form.content' => 'required|string',
            'form.excerpt' => 'nullable|string|max:500',
            'form.meta_title' => 'nullable|string|max:255',
            'form.meta_description' => 'nullable|string|max:500',
            'form.is_published' => 'boolean',
        ];
    }

    public function mount()
    {
        $this->loadPage();
    }

    public function updatedSelectedPageType()
    {
        $this->loadPage();
    }

    public function updated($property)
    {
        if (str_starts_with($property, 'form.')) {
            // Don't auto-validate content changes to prevent interference with editor
            if ($property !== 'form.content') {
                $this->validateOnly($property);
            }
        }
    }

    public function loadPage()
    {
        $page = LegalPage::where('page_type', $this->selectedPageType)->first();

        if ($page) {
            $this->editingId = $page->id;
            $this->form = [
                'title' => $page->title,
                'slug' => $page->slug,
                'content' => $page->content,
                'excerpt' => $page->excerpt,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'is_published' => $page->is_published,
            ];
        } else {
            // Create new page with default content
            $this->editingId = null;
            $defaultContent = LegalPage::getDefaultContent($this->selectedPageType);
            $pageTypeName = LegalPage::PAGE_TYPES[$this->selectedPageType];

            $this->form = [
                'title' => $pageTypeName,
                'slug' => str_replace('_', '-', $this->selectedPageType),
                'content' => $defaultContent,
                'excerpt' => "Our {$pageTypeName} explains our policies and practices.",
                'meta_title' => "{$pageTypeName} | OSR",
                'meta_description' => "Read our {$pageTypeName} to understand our policies.",
                'is_published' => true,
            ];
        }

        // Dispatch event to populate Quill editor
        $this->dispatch('legalPageContentLoaded', [
            'content' => $this->form['content']
        ]);
    }

    public function save()
    {
        $this->validate();

        try {
            $pageData = $this->form;
            $pageData['page_type'] = $this->selectedPageType;
            $pageData['updated_by'] = Auth::user()->name ?? 'Admin';

            if ($this->editingId) {
                $page = LegalPage::findOrFail($this->editingId);
                $page->update($pageData);
                $message = 'Legal page updated successfully.';
            } else {
                LegalPage::create($pageData);
                $message = 'Legal page created successfully.';
            }

            session()->flash('success', $message);

            // Reload the page
            $this->loadPage();

        } catch (\Exception $e) {
            Log::error('Legal Page Save Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to save legal page. Please try again.');
        }
    }

    public function preview()
    {
        if ($this->editingId) {
            $page = LegalPage::findOrFail($this->editingId);
            return redirect()->route('legal.show', $page->slug);
        }
    }

    public function resetToDefault()
    {
        $defaultContent = LegalPage::getDefaultContent($this->selectedPageType);
        $this->form['content'] = $defaultContent;

        // Dispatch event to update Quill editor
        $this->dispatch('legalPageContentLoaded', [
            'content' => $this->form['content']
        ]);

        session()->flash('info', 'Content has been reset to default. Remember to save your changes.');
    }

    public function render()
    {
        $pages = LegalPage::all()->keyBy('page_type');

        return view('livewire.admin.legal-pages.index', [
            'pages' => $pages,
            'pageTypes' => LegalPage::PAGE_TYPES,
        ]);
    }
}
