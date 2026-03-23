<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'national_id',
        'citizenship',
        'place_of_birth',
        'address_street',
        'address_postal_code',
        'address_city',
        'delivery_street',
        'delivery_postal_code',
        'delivery_city',
        'other_delivery_methods',
        'phone',
        'email',
        'alternative_delivery',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
