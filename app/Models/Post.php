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
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_old' => 'boolean',
        'auto_publish' => 'boolean',
        'social_published' => 'boolean',
        'published_at' => 'datetime',
        'social_platforms' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}
