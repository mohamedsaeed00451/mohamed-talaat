<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
        'slug' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(ArticleType::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ArticleType::class, 'parent_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

}
