@extends('admin.layout')

@section('title', 'Alert Test Page')

@section('content')
<div class="container-fluid">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Livewire Toaster Test Page</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Test Livewire Toaster Notifications</h3>
                </div>
                <div class="card-body">
                    <p class="mb-4">Test the different types of toast notifications that can be dispatched from Livewire components using Livewire Toaster:</p>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Basic Event Types</h5>
                            <div class="btn-group-vertical d-block mb-3">
                                <button wire:click="testSuccess" class="btn btn-success mb-2">
                                    <i class="fas fa-check"></i> Test Success Event
                                </button>
                                <button wire:click="testError" class="btn btn-danger mb-2">
                                    <i class="fas fa-times"></i> Test Error Event
                                </button>
                                <button wire:click="testWarning" class="btn btn-warning mb-2">
                                    <i class="fas fa-exclamation-triangle"></i> Test Warning Event
                                </button>
                                <button wire:click="testInfo" class="btn btn-info mb-2">
                                    <i class="fas fa-info"></i> Test Info Event
                                </button>
                                <button wire:click="testToast" class="btn btn-secondary mb-2">
                                    <i class="fas fa-comment"></i> Test Custom Toast
                                </button>
                                <button wire:click="testDelete" class="btn btn-dark mb-2">
                                    <i class="fas fa-trash"></i> Test Delete Event
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5>Flash + Event Combinations</h5>
                            <div class="btn-group-vertical d-block mb-3">
                                <button wire:click="testFlashSuccess" class="btn btn-outline-success mb-2">
                                    <i class="fas fa-check-double"></i> Flash Success (Session + Event)
                                </button>
                                <button wire:click="testFlashError" class="btn btn-outline-danger mb-2">
                                    <i class="fas fa-exclamation-circle"></i> Flash Error (Session + Event)
                                </button>
                                <button wire:click="testFlashDelete" class="btn btn-outline-dark mb-2">
                                    <i class="fas fa-trash-alt"></i> Flash Delete (Session + Event)
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle"></i> How it works:</h5>
                        <ul class="mb-0">
                            <li><strong>Event Dispatch:</strong> Livewire components use <code>$this->dispatch('show-toast-type', $data)</code></li>
                            <li><strong>Custom Toast Component:</strong> Custom Livewire component handles toast display and animations</li>
                            <li><strong>Multiple Types:</strong> Success, Warning, Error, Delete, and Info toast notifications</li>
                            <li><strong>Trait Helper:</strong> Use <code>DispatchesAlertEvents</code> trait for easy methods like <code>dispatchSuccessEvent()</code>, <code>dispatchDeleteEvent()</code></li>
                            <li><strong>Auto-dismiss:</strong> Toasts automatically disappear after configurable duration with progress bars</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Code Examples -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Usage Examples</h3>
                </div>
                <div class="card-body">
                    <h5>1. Using the Trait Methods (Recommended)</h5>
                    <pre class="bg-light p-3 rounded"><code class="php">
// In your Livewire component
use App\Traits\DispatchesAlertEvents;

class MyComponent extends Component
{
    use DispatchesAlertEvents;

    public function save()
    {
        // Your save logic here...

        // Dispatch success event
        $this->dispatchSuccessEvent('Data saved successfully!');

        // Or with custom title
        $this->dispatchSuccessEvent('Data saved!', 'Great!');

        // Flash + Event combination
        $this->flashSuccess('Saved to session and shows toast!');
    }
}
                    </code></pre>

                    <h5 class="mt-4">2. Manual Event Dispatching</h5>
                    <pre class="bg-light p-3 rounded"><code class="php">
// Manual dispatch in any Livewire component
$this->dispatch('success-event', [
    'title' => 'Success',
    'message' => 'Operation completed!',
    'type' => 'success'
]);

// Error event
$this->dispatch('error-event', [
    'title' => 'Error',
    'message' => 'Something went wrong!',
    'type' => 'error'
]);
                    </code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
