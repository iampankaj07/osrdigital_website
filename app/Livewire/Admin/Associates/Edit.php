<?php

namespace App\Livewire\Admin\Associates;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Associate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Edit extends Component
{
    use WithFileUploads;

    public Associate $associate;
    public $name = '';
    public $description = '';
    public $type = 'production';
    public $website_url = '';
    public $logo;
    public $is_active = true;
    public $sort_order = 0;
    public $old_logo = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|string|in:production,distribution,technology,other',
        'website_url' => 'nullable|url',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'is_active' => 'boolean',
        'sort_order' => 'integer|min:0',
    ];

    public function mount(Associate $associate)
    {
        $this->associate = $associate;
        $this->name = $associate->name;
        $this->description = $associate->description;
        $this->type = $associate->type;
        $this->website_url = $associate->website_url;
        $this->is_active = $associate->is_active;
        $this->sort_order = $associate->sort_order;
        $this->old_logo = $associate->logo;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            $this->associate->name = $this->name;
            $this->associate->description = $this->description;
            $this->associate->type = $this->type;
            $this->associate->website_url = $this->website_url;
            $this->associate->is_active = $this->is_active;
            $this->associate->sort_order = $this->sort_order;

            // Handle logo upload
            if ($this->logo) {
                // Delete old logo if exists
                if ($this->old_logo && Storage::disk('public')->exists($this->old_logo)) {
                    Storage::disk('public')->delete($this->old_logo);
                }
                
                $filename = 'associates/' . Str::uuid() . '.' . $this->logo->getClientOriginalExtension();
                $this->logo->storeAs('public', $filename);
                $this->associate->logo = $filename;
            }

            $this->associate->save();

            session()->flash('success', 'Associate updated successfully!');
            return redirect()->route('admin.associates.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update associate: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.associates.edit')
            ->layout('admin.layout', ['title' => 'Edit Associate']);
    }
}
