<?php

namespace App\Livewire\Admin\Testimonials;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Edit extends Component
{
    use WithFileUploads;

    public Testimonial $testimonial;
    public $author_name = '';
    public $author_title = '';
    public $content = '';
    public $avatar;
    public $is_active = true;
    public $sort_order = 0;
    public $old_avatar = '';

    protected $rules = [
        'author_name' => 'required|string|max:255',
        'author_title' => 'required|string|max:255',
        'content' => 'required|string',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'is_active' => 'boolean',
        'sort_order' => 'integer|min:0',
    ];

    public function mount(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
        $this->author_name = $testimonial->author_name;
        $this->author_title = $testimonial->author_title;
        $this->content = $testimonial->content;
        $this->is_active = $testimonial->is_active;
        $this->sort_order = $testimonial->sort_order;
        $this->old_avatar = $testimonial->avatar;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            $this->testimonial->author_name = $this->author_name;
            $this->testimonial->author_title = $this->author_title;
            $this->testimonial->content = $this->content;
            $this->testimonial->is_active = $this->is_active;
            $this->testimonial->sort_order = $this->sort_order;

            // Handle avatar upload
            if ($this->avatar) {
                // Delete old avatar if exists
                if ($this->old_avatar && Storage::disk('public')->exists($this->old_avatar)) {
                    Storage::disk('public')->delete($this->old_avatar);
                }
                
                $filename = 'testimonials/' . Str::uuid() . '.' . $this->avatar->getClientOriginalExtension();
                $this->avatar->storeAs('public', $filename);
                $this->testimonial->avatar = $filename;
            }

            $this->testimonial->save();

            session()->flash('success', 'Testimonial updated successfully!');
            return redirect()->route('admin.testimonials.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update testimonial: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.testimonials.edit')
            ->layout('admin.layout', ['title' => 'Edit Testimonial']);
    }
}
