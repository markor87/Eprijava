<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HighSchoolEducation extends Model
{
    protected $table = 'high_school_educations';

    protected $fillable = [
        'user_id',
        'institution_name',
        'institution_location',
        'duration',
        'direction',
        'occupation',
        'graduation_year',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
