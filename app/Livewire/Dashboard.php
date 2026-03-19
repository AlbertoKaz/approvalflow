<?php

namespace App\Livewire;

use App\Models\ApprovalRequest;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render(): View
    {
        return view('livewire.dashboard', [
            'totalRequests' => ApprovalRequest::count(),
            'pendingRequests' => ApprovalRequest::pending()->count(),
            'approvedRequests' => ApprovalRequest::approved()->count(),
            'rejectedRequests' => ApprovalRequest::rejected()->count(),
            'latestRequests' => ApprovalRequest::query()
                ->with('creator')
                ->latest()
                ->take(8)
                ->get(),
        ]);
    }
}
