<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class CustomToast extends Component
{
    public $toasts = [];

    protected $listeners = [
        'show-toast' => 'addToast',
        'show-success-toast' => 'addSuccessToast',
        'show-warning-toast' => 'addWarningToast',
        'show-error-toast' => 'addErrorToast',
        'show-delete-toast' => 'addDeleteToast',
    ];

    public function mount()
    {
        $this->toasts = [];
    }

    #[On('show-toast')]
    public function addToast($data)
    {
        $toast = [
            'id' => uniqid(),
            'type' => $data['type'] ?? 'success',
            'title' => $data['title'] ?? '',
            'message' => $data['message'] ?? '',
            'duration' => $data['duration'] ?? 4000,
            'timestamp' => now()->timestamp,
        ];

        $this->toasts[] = $toast;

        // Auto-remove after duration
        $this->dispatch('auto-remove-toast', [
            'id' => $toast['id'],
            'duration' => $toast['duration']
        ]);
    }

    #[On('show-success-toast')]
    public function addSuccessToast($data)
    {
        $this->addToast([
            'type' => 'success',
            'title' => $data['title'] ?? 'Success!',
            'message' => $data['message'] ?? '',
            'duration' => $data['duration'] ?? 4000,
        ]);
    }

    #[On('show-warning-toast')]
    public function addWarningToast($data)
    {
        $this->addToast([
            'type' => 'warning',
            'title' => $data['title'] ?? 'Warning!',
            'message' => $data['message'] ?? '',
            'duration' => $data['duration'] ?? 5000,
        ]);
    }

    #[On('show-error-toast')]
    public function addErrorToast($data)
    {
        $this->addToast([
            'type' => 'error',
            'title' => $data['title'] ?? 'Error!',
            'message' => $data['message'] ?? '',
            'duration' => $data['duration'] ?? 6000,
        ]);
    }

    #[On('show-delete-toast')]
    public function addDeleteToast($data)
    {
        $this->addToast([
            'type' => 'delete',
            'title' => $data['title'] ?? 'Deleted!',
            'message' => $data['message'] ?? '',
            'duration' => $data['duration'] ?? 4000,
        ]);
    }

    public function removeToast($toastId)
    {
        $this->toasts = collect($this->toasts)->reject(function ($toast) use ($toastId) {
            return $toast['id'] === $toastId;
        })->values()->all();
    }

    public function render()
    {
        return view('livewire.components.custom-toast');
    }
}
