<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketList extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, open, in_progress, resolved

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Ticket::with(['customer', 'category']);

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        if (!empty($this->search)) {
            $query->whereRaw("search_vector @@ plainto_tsquery('english', ?)", [$this->search])
                  ->orderByRaw("ts_rank(search_vector, plainto_tsquery('english', ?)) DESC", [$this->search]);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $tickets = $query->paginate(15);

        return view('livewire.agent.ticket-list', [
            'tickets' => $tickets
        ])->layout('layouts.app');
    }
}
