<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Traits\DispatchesAlertEvents;

class AlertTestPage extends Component
{
    use DispatchesAlertEvents;

    public function testSuccess()
    {
        $this->dispatchSuccessEvent('This is a success message!');
    }

    public function testError()
    {
        $this->dispatchErrorEvent('This is an error message!');
    }

    public function testWarning()
    {
        $this->dispatchWarningEvent('This is a warning message!');
    }

    public function testInfo()
    {
        $this->dispatchInfoEvent('This is an info message!');
    }

    public function testToast()
    {
        $this->dispatchToast('This is a custom toast message!', 'success', 'Custom Toast');
    }

    public function testFlashSuccess()
    {
        $this->flashSuccess('Flash success with both session and event!');
    }

    public function testFlashError()
    {
        $this->flashError('Flash error with both session and event!');
    }

    public function testDelete()
    {
        $this->dispatchDeleteEvent('Item has been successfully deleted!');
    }

    public function testFlashDelete()
    {
        $this->flashDelete('Item deleted with both session and toast!');
    }

    public function render()
    {
        return view('admin.alert-test');
    }
}
