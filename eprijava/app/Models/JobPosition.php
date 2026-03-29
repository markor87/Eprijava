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
        'sequence_number',
        'organizational_unit',
        'org_unit_path',
        'sector',
        'employment_type',
        'work_location_id',
        'educational_scientific_field_id',
        'scientific_professional_field_id',
        'title_id',
        'qualification_level',
        'executor_count',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function governmentBody(): BelongsTo
    {
        return $this->belongsTo(GovernmentBody::class);
    }

    public function workLocation(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'work_location_id');
    }
}
