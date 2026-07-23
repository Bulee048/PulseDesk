<?php

namespace App\Livewire\Ticket;

use Livewire\Component;

use App\Models\Ticket;
use App\Models\TicketRating;

class Rating extends Component
{
    public Ticket $ticket;
    public $rating = 5;
    public $feedback = '';

    public function submitRating()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        TicketRating::create([
            'ticket_id' => $this->ticket->id,
            'rating' => $this->rating,
            'feedback' => $this->feedback,
        ]);

        $this->ticket->refresh();
        session()->flash('status', 'Thank you for your feedback!');
    }

    public function render()
    {
        return view('livewire.ticket.rating');
    }
}
