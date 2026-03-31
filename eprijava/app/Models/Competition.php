<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    protected $fillable = [
        'user_id',
        'government_body_id',
        'tip_konkursa',
        'datum_od',
        'datum_do',
    ];

    protected $casts = [
        'datum_od' => 'date',
        'datum_do' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function governmentBody(): BelongsTo
    {
        return $this->belongsTo(GovernmentBody::class);
    }

    public function jobPositions(): HasMany
    {
        return $this->hasMany(JobPosition::class);
    }
}
