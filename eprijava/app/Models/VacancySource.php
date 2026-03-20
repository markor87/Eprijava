<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacancySource extends Model
{
    protected $table = 'vacancy_sources';

    protected $fillable = [
        'user_id',
        'internet_presentation',
        'press',
        'referral',
        'nsz',
        'live',
        'interested_in_other_jobs',
    ];

    protected $casts = [
        'internet_presentation'    => 'array',
        'press'                    => 'array',
        'referral'                 => 'array',
        'nsz'                      => 'array',
        'live'                     => 'array',
        'interested_in_other_jobs' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
