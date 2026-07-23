<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Facades\DB;
use App\Traits\BelongsToOrganization;

#[Fillable(['subject', 'description', 'status', 'priority', 'category_id', 'customer_id', 'agent_id', 'resolved_at', 'organization_id'])]
class Ticket extends Model
{
    use BelongsToOrganization;
    protected static function booted(): void
    {
        static::saved(function (Ticket $ticket) {
            if (DB::connection()->getDriverName() === 'pgsql') {
                DB::statement(
                    "UPDATE tickets SET search_vector = to_tsvector('english', coalesce(subject, '') || ' ' || coalesce(description, '')) WHERE id = ?",
                    [$ticket->id]
                );
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function rating()
    {
        return $this->hasOne(TicketRating::class);
    }
}
