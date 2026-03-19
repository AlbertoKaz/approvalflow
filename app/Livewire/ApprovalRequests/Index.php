<?php

namespace App\Livewire\ApprovalRequests;

use App\Models\ApprovalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Approval Requests')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'status', except: '')]
    public string $status = '';

    #[Url(as: 'search', except: '')]
    public string $search = '';

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function approve(int $requestId): void
    {
        $request = ApprovalRequest::findOrFail($requestId);

        $request->approve(Auth::id());

        session()->flash('success', 'Request approved successfully.');
    }

    public function reject(int $requestId): void
    {
        $request = ApprovalRequest::findOrFail($requestId);

        $request->reject(Auth::id());

        session()->flash('success', 'Request rejected successfully.');
    }


    public function render(): View
    {
        $requests = ApprovalRequest::query()
            ->with(['creator', 'approver', 'rejector'])
            ->when(
                $this->status !== '',
                fn ($query) => $query->where('status', $this->status)
            )
            ->when(
                filled($this->search),
                fn ($query) => $query->where('title', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(5);

        return view('livewire.approval-requests.index', [
            'requests' => $requests,
            'statuses' => ApprovalRequest::statuses(),
        ]);
    }
}
