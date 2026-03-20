<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacancySource extends Model
{
    protected $table = 'vacancy_sources';

    protected $fillable = [
        'user_id',
        'source',
        'interested_in_other_jobs',
    ];

    protected $casts = [
        'interested_in_other_jobs' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
