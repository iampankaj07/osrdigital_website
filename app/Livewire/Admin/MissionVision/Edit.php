<?php

namespace App\Livewire\Admin\MissionVision;

use Livewire\Component;

class Edit extends Component
{
    public function mount()
    {
        return redirect()->route('admin.mission-vision.index');
    }

    public function render()
    {
        return view('livewire.admin.mission-vision.edit');
    }
}
