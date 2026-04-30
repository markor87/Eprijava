<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkExperience extends Model
{
    protected $table = 'work_experiences';

    protected $fillable = [
        'user_id',
        'period_from',
        'period_to',
        'employer_name',
        'job_title',
        'job_description',
        'employment_basis',
        'required_education',
    ];

    protected $casts = [
        'period_from'       => 'date',
        'period_to'         => 'date',
        'required_education' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
