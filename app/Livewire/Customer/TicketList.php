<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\Ticket;

class TicketList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Ticket::where('customer_id', Auth::id())
            ->with(['category', 'agent']);

        if (!empty($this->search)) {
            $query->whereRaw("search_vector @@ plainto_tsquery('english', ?)", [$this->search])
                  ->orderByRaw("ts_rank(search_vector, plainto_tsquery('english', ?)) DESC", [$this->search]);
        } else {
            $query->latest();
        }

        $tickets = $query->paginate(10);

        return view('livewire.customer.ticket-list', [
            'tickets' => $tickets
        ])->layout('layouts.app');
    }
}
