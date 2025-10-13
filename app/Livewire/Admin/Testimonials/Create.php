<?php

namespace App\Livewire\Admin\Testimonials;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $author_name = '';
    public $author_title = '';
    public $content = '';
    public $avatar;
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'author_name' => 'required|string|max:255',
        'author_title' => 'required|string|max:255',
        'content' => 'required|string',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $testimonial = new Testimonial();
            $testimonial->author_name = $this->author_name;
            $testimonial->author_title = $this->author_title;
            $testimonial->content = $this->content;
            $testimonial->is_active = $this->is_active;
            $testimonial->sort_order = $this->sort_order;

            // Handle avatar upload
            if ($this->avatar) {
                $filename = 'testimonials/' . Str::uuid() . '.' . $this->avatar->getClientOriginalExtension();
                $this->avatar->storeAs('public', $filename);
                $testimonial->avatar = $filename;
            }

            $testimonial->save();

            session()->flash('success', 'Testimonial created successfully!');
            return redirect()->route('admin.testimonials.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create testimonial: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.testimonials.create')
            ->layout('admin.layout', ['title' => 'Create Testimonial']);
    }
}
