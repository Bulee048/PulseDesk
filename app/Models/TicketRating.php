<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['ticket_id', 'rating', 'feedback'])]
class TicketRating extends Model
{
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
