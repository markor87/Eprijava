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
        'volume_espb',
        'institution_name',
        'institution_location_id',
        'program_name',
        'title_id',
        'graduation_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function institutionLocation(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'institution_location_id');
    }

    public function academicTitle(): BelongsTo
    {
        return $this->belongsTo(AcademicTitle::class, 'title_id');
    }
}
