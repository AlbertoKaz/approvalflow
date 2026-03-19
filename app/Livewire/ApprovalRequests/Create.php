<?php

namespace App\Livewire\ApprovalRequests;

use App\Models\ApprovalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('New Request')]
class Create extends Component
{
    #[Validate('required|string|min:3|max:255')]
    public string $title = '';

    #[Validate('nullable|string|max:5000')]
    public string $description = '';

    public function save(): void
    {
        $validated = $this->validate();

        ApprovalRequest::create([
            'title' => $validated['title'],
            'description' => filled($validated['description']) ? $validated['description'] : null,
            'status' => ApprovalRequest::STATUS_PENDING,
            'created_by' => Auth::id(),
        ]);

        $this->reset(['title', 'description']);

        session()->flash('success', 'Request created successfully.');
    }

    public function render(): View
    {
        return view('livewire.approval-requests.create');
    }
}
