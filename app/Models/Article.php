<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'slug' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_old' => 'boolean',
        'auto_publish' => 'boolean',
        'social_published' => 'boolean',
        'published_at' => 'datetime',
        'social_platforms' => 'array',
    ];

    public function type()
    {
        return $this->belongsTo(ArticleType::class, 'article_type_id');
    }
}
