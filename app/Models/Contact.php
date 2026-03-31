<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $guarded = [];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }
}
