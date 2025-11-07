<?php
namespace App\Livewire\Admin\Traits;

trait WithDeleteConfirmation
{
    public $confirmingDeleteId = null;
    public $confirmingDeleteType = null; // optional context label

    /**
     * Initiate a delete confirmation.
     */
    public function confirmDelete($id, $type = null)
    {
        $this->confirmingDeleteId = $id;
        $this->confirmingDeleteType = $type;
    }

    /**
     * Cancel the confirmation state.
     */
    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
        $this->confirmingDeleteType = null;
    }

    /**
     * Wrapper to perform deletion using component-specific method.
     * Component must implement performActualDelete($id).
     */
    public function performDelete()
    {
        if ($this->confirmingDeleteId === null) {
            return;
        }

        if (method_exists($this, 'performActualDelete')) {
            $this->performActualDelete($this->confirmingDeleteId);
        } elseif (method_exists($this, 'delete')) {
            // Fallback to existing delete method name
            $this->delete($this->confirmingDeleteId);
        }

        $this->confirmingDeleteId = null;
        $this->confirmingDeleteType = null;
    }
}
