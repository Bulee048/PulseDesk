<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Traits\BelongsToOrganization;

#[Fillable(['ticket_id', 'rating', 'feedback', 'organization_id'])]
class TicketRating extends Model
{
    use BelongsToOrganization;
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
