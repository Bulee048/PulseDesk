<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'price_cents', 'agent_limit', 'ticket_limit_per_month', 'stripe_price_id'])]
class Plan extends Model
{
    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
}
