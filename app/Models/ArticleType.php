<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
    ];

}
