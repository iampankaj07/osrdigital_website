<?php

namespace App\Traits;

trait DispatchesAlertEvents
{
    /**
     * Dispatch a success toast notification
     */
    protected function dispatchSuccessEvent(string $message, string $title = 'Success!')
    {
        $this->dispatch('show-success-toast', [
            'title' => $title,
            'message' => $message,
            'duration' => 4000
        ]);
    }

    /**
     * Dispatch an error toast notification
     */
    protected function dispatchErrorEvent(string $message, string $title = 'Error!')
    {
        $this->dispatch('show-error-toast', [
            'title' => $title,
            'message' => $message,
            'duration' => 6000
        ]);
    }

    /**
     * Dispatch an info toast notification
     */
    protected function dispatchInfoEvent(string $message, string $title = 'Info')
    {
        $this->dispatch('show-toast', [
            'type' => 'info',
            'title' => $title,
            'message' => $message,
            'duration' => 4000
        ]);
    }

    /**
     * Dispatch a warning toast notification
     */
    protected function dispatchWarningEvent(string $message, string $title = 'Warning!')
    {
        $this->dispatch('show-warning-toast', [
            'title' => $title,
            'message' => $message,
            'duration' => 5000
        ]);
    }

    /**
     * Dispatch a delete toast notification
     */
    protected function dispatchDeleteEvent(string $message, string $title = 'Deleted!')
    {
        $this->dispatch('show-delete-toast', [
            'title' => $title,
            'message' => $message,
            'duration' => 4000
        ]);
    }

    /**
     * Dispatch a generic toast notification
     */
    protected function dispatchToast(string $message, string $type = 'success', ?string $title = null)
    {
        $eventName = match($type) {
            'success' => 'show-success-toast',
            'error' => 'show-error-toast',
            'warning' => 'show-warning-toast',
            'delete' => 'show-delete-toast',
            default => 'show-toast',
        };

        $duration = match($type) {
            'success' => 4000,
            'error' => 6000,
            'warning' => 5000,
            'delete' => 4000,
            default => 4000,
        };

        $this->dispatch($eventName, [
            'type' => $type,
            'title' => $title ?: ucfirst($type),
            'message' => $message,
            'duration' => $duration
        ]);
    }

    /**
     * Dispatch success with both session flash and toast notification
     */
    protected function flashSuccess(string $message, string $title = 'Success!')
    {
        session()->flash('success', $message);
        $this->dispatchSuccessEvent($message, $title);
    }

    /**
     * Dispatch error with both session flash and toast notification
     */
    protected function flashError(string $message, string $title = 'Error!')
    {
        session()->flash('error', $message);
        $this->dispatchErrorEvent($message, $title);
    }

    /**
     * Dispatch warning with both session flash and toast notification
     */
    protected function flashWarning(string $message, string $title = 'Warning!')
    {
        session()->flash('warning', $message);
        $this->dispatchWarningEvent($message, $title);
    }

    /**
     * Dispatch delete notification
     */
    protected function flashDelete(string $message, string $title = 'Deleted!')
    {
        session()->flash('success', $message);
        $this->dispatchDeleteEvent($message, $title);
    }

    /**
     * Dispatch a confirmation dialog event (requires custom implementation)
     */
    protected function dispatchConfirmation(string $message, string $confirmMethod, array $parameters = [], string $title = 'Are you sure?')
    {
        $this->dispatch('confirmation-event', [
            'title' => $title,
            'message' => $message,
            'confirmMethod' => $confirmMethod,
            'parameters' => $parameters,
            'type' => 'warning'
        ]);
    }
}
