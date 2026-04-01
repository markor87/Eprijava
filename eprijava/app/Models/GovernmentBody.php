<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernmentBody extends Model
{
    protected $table = 'government_bodies';

    protected $fillable = [
        'name',
        'government_body_code',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function konkursi(): HasMany
    {
        return $this->hasMany(Competition::class);
    }
}
