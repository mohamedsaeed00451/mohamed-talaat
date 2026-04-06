<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'description' => 'array',
        'strategic_brief' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}
