<?php

namespace App\Livewire\Admin\MissionVision;

use Livewire\Component;

class Create extends Component
{
    public function mount()
    {
        $this->redirect(route('admin.mission-vision.index'));
    }

    public function render()
    {
        return view('livewire.admin.mission-vision.create');
    }
}
