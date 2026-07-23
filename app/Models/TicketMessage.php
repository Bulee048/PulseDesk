<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Traits\BelongsToOrganization;

#[Fillable(['ticket_id', 'sender_id', 'message', 'attachment_path', 'organization_id'])]
class TicketMessage extends Model
{
    use BelongsToOrganization;
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
