<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use App\Models\Ticket;
use Livewire\Attributes\On;

class TicketDetail extends Component
{
    public Ticket $ticket;

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    #[On('ticket-status-updated')]
    public function refreshTicket()
    {
        $this->ticket->refresh();
    }

    public function render()
    {
        return view('livewire.customer.ticket-detail')->layout('layouts.app');
    }
}
