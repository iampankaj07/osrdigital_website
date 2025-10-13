<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AdminSettings;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'key';
    public $sortDirection = 'asc';
    public $groupFilter = '';
    
    // Inline editing properties
    public $editingId = null;
    public $isCreating = false;
    public $form = [
        'key' => '',
        'value' => '',
        'type' => 'string',
        'group' => 'general',
        'description' => '',
        'is_public' => false,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'key'],
        'sortDirection' => ['except' => 'asc'],
        'groupFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingGroupFilter()
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
        $setting = AdminSettings::findOrFail($id);
        
        $this->form = [
            'key' => $setting->key,
            'value' => is_array($setting->value) ? json_encode($setting->value) : $setting->value,
            'type' => $setting->type,
            'group' => $setting->group,
            'description' => $setting->description,
            'is_public' => $setting->is_public,
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
            'form.key' => 'required|string|max:255|unique:admin_settings,key',
            'form.value' => 'required|string',
            'form.type' => 'required|in:string,number,boolean,json,text',
            'form.group' => 'required|string|max:255',
            'form.description' => 'nullable|string',
            'form.is_public' => 'boolean',
        ]);

        $value = $this->form['value'];
        if ($this->form['type'] === 'json') {
            $value = json_decode($value, true);
        } elseif ($this->form['type'] === 'number') {
            $value = (float) $value;
        } elseif ($this->form['type'] === 'boolean') {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        AdminSettings::create([
            'key' => $this->form['key'],
            'value' => $value,
            'type' => $this->form['type'],
            'group' => $this->form['group'],
            'description' => $this->form['description'],
            'is_public' => $this->form['is_public'],
        ]);
        
        $this->isCreating = false;
        $this->reset('form');
        
        session()->flash('success', 'Setting created successfully!');
    }

    public function update()
    {
        $this->validate([
            'form.key' => 'required|string|max:255|unique:admin_settings,key,' . $this->editingId,
            'form.value' => 'required|string',
            'form.type' => 'required|in:string,number,boolean,json,text',
            'form.group' => 'required|string|max:255',
            'form.description' => 'nullable|string',
            'form.is_public' => 'boolean',
        ]);

        $setting = AdminSettings::findOrFail($this->editingId);
        
        $value = $this->form['value'];
        if ($this->form['type'] === 'json') {
            $value = json_decode($value, true);
        } elseif ($this->form['type'] === 'number') {
            $value = (float) $value;
        } elseif ($this->form['type'] === 'boolean') {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        $setting->update([
            'key' => $this->form['key'],
            'value' => $value,
            'type' => $this->form['type'],
            'group' => $this->form['group'],
            'description' => $this->form['description'],
            'is_public' => $this->form['is_public'],
        ]);
        
        $this->editingId = null;
        $this->reset('form');
        
        session()->flash('success', 'Setting updated successfully!');
    }

    public function delete($id)
    {
        $setting = AdminSettings::findOrFail($id);
        $setting->delete();
        
        session()->flash('success', 'Setting deleted successfully!');
    }

    public function togglePublic($id)
    {
        $setting = AdminSettings::findOrFail($id);
        $setting->update(['is_public' => !$setting->is_public]);
        
        session()->flash('success', 'Setting public status updated successfully!');
    }

    public function render()
    {
        $settings = AdminSettings::query()
            ->when($this->search, function ($query) {
                $query->where('key', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('group', 'like', '%' . $this->search . '%');
            })
            ->when($this->groupFilter, function ($query) {
                $query->where('group', $this->groupFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $groups = AdminSettings::distinct()->pluck('group')->filter();

        return view('livewire.admin.settings.index', compact('settings', 'groups'))
            ->layout('admin.layout', ['title' => 'Settings']);
    }
}
