<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $guarded = [];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

}
