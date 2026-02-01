<?php

namespace App\Livewire\Admin\Messages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

    public $form = [
        'name' => '',
        'email' => '',
        'subject' => '',
        'body' => '',
        'status' => 'new',
    ];

    public $isCreating = false;
    public $editingId = null;
    public $showSlidePanel = false;
    public $isClosing = false;

    public $search = '';
    public $perPage = 15;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected function rules()
    {
        return [
            'form.name' => 'nullable|string|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.subject' => 'nullable|string|max:255',
            'form.body' => 'nullable|string',
            'form.status' => 'required|in:new,read,archived',
        ];
    }

    public function mount($create = false, $editId = null)
    {
        if ($create) {
            $this->create();
        }

        if ($editId) {
            $this->edit($editId);
        }
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function create()
    {
        $this->resetForm();
        $this->isCreating = true;
        $this->editingId = null;
        $this->showSlidePanel = true;
        $this->dispatch('slidePanelOpened');
    }

    public function store()
    {
        $this->validate();

        try {
            Message::create($this->form);

            $this->resetForm();
            $this->isCreating = false;
            $this->showSlidePanel = false;

            session()->flash('success', 'Message created successfully.');
        } catch (\Exception $e) {
            Log::error('Message store error: ' . $e->getMessage());
            session()->flash('error', 'Failed to create message.');
        }
    }

    public function edit($id)
    {
        try {
            $message = Message::findOrFail($id);
            $this->form = [
                'name' => $message->name,
                'email' => $message->email,
                'subject' => $message->subject,
                'body' => $message->body,
                'status' => $message->status,
            ];

            $this->editingId = $id;
            $this->isCreating = false;
            $this->showSlidePanel = true;
            $this->dispatch('slidePanelOpened');
        } catch (\Exception $e) {
            Log::error('Message edit error: ' . $e->getMessage());
            session()->flash('error', 'Message not found.');
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $message = Message::findOrFail($this->editingId);
            $message->update($this->form);

            $this->resetForm();
            $this->editingId = null;
            $this->showSlidePanel = false;

            session()->flash('success', 'Message updated successfully.');
        } catch (\Exception $e) {
            Log::error('Message update error: ' . $e->getMessage());
            session()->flash('error', 'Failed to update message.');
        }
    }

    public function delete($id)
    {
        try {
            $message = Message::findOrFail($id);
            $title = Str::limit($message->subject ?? $message->body, 40);
            $message->delete();

            session()->flash('success', "Message '{$title}' deleted.");
        } catch (\Exception $e) {
            Log::error('Message delete error: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete message.');
        }
    }

    public function changeStatus($id, $status)
    {
        try {
            $message = Message::findOrFail($id);
            $message->update(['status' => $status]);
            session()->flash('success', 'Status updated.');
        } catch (\Exception $e) {
            Log::error('Message status change error: ' . $e->getMessage());
            session()->flash('error', 'Failed to update status.');
        }
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

    private function resetForm()
    {
        $this->form = [
            'name' => '',
            'email' => '',
            'subject' => '',
            'body' => '',
            'status' => 'new',
        ];
        $this->isCreating = false;
        $this->editingId = null;
        $this->showSlidePanel = false;
    }

    public function render()
    {
        $query = Message::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('subject', 'like', "%{$this->search}%")
                    ->orWhere('body', 'like', "%{$this->search}%");
            });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $messages = $query->paginate($this->perPage);

        return view('livewire.admin.messages.index', compact('messages'));
    }
}
