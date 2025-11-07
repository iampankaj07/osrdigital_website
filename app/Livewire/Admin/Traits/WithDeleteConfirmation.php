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

        try {
            if (method_exists($this, 'performActualDelete')) {
                $this->performActualDelete($this->confirmingDeleteId);
            } elseif (method_exists($this, 'delete')) {
                // Fallback to existing delete method name
                $this->delete($this->confirmingDeleteId);
            }
        } catch (\Exception $e) {
            // Error handling is done in performActualDelete or delete method
        } finally {
            // Always reset the confirming state to close modal
            $this->confirmingDeleteId = null;
            $this->confirmingDeleteType = null;
        }
    }
}
