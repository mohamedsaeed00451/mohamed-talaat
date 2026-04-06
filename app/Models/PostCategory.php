<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
        'slug' => 'array',
    ];
}
