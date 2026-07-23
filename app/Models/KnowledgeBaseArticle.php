<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToOrganization;

class KnowledgeBaseArticle extends Model
{
    use BelongsToOrganization;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'body',
        'published',
        'view_count',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
