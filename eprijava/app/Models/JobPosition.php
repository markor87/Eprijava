<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPosition extends Model
{
    protected $table = 'job_positions';

    protected $fillable = [
        'competition_id',
        'government_body_id',
        'position_name',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function governmentBody(): BelongsTo
    {
        return $this->belongsTo(GovernmentBody::class);
    }
}
