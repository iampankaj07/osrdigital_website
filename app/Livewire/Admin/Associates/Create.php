<?php

namespace App\Livewire\Admin\Associates;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Associate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $description = '';
    public $type = 'production';
    public $website_url = '';
    public $logo;
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|string|in:production,distribution,technology,other',
        'website_url' => 'nullable|url',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $associate = new Associate();
            $associate->name = $this->name;
            $associate->description = $this->description;
            $associate->type = $this->type;
            $associate->website_url = $this->website_url;
            $associate->is_active = $this->is_active;
            $associate->sort_order = $this->sort_order;

            // Handle logo upload
            if ($this->logo) {
                $filename = 'associates/' . Str::uuid() . '.' . $this->logo->getClientOriginalExtension();
                $this->logo->storeAs('public', $filename);
                $associate->logo = $filename;
            }

            $associate->save();

            session()->flash('success', 'Associate created successfully!');
            return redirect()->route('admin.associates.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create associate: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.associates.create')
            ->layout('admin.layout', ['title' => 'Create Associate']);
    }
}
