<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HigherEducation extends Model
{
    protected $table = 'higher_educations';

    protected $fillable = [
        'user_id',
        'study_type',
        'institution_name',
        'institution_location',
        'volume_espb_or_years',
        'program_name',
        'title_obtained',
        'graduation_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
