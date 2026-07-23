<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Traits\BelongsToOrganization;

#[Fillable(['name', 'organization_id'])]
class Category extends Model
{
    use BelongsToOrganization;
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
