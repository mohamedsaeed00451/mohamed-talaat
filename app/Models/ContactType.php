<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
    ];
}
