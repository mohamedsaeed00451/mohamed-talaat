<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaultFile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'title' => 'array',
    ];

}
