<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdditionalTraining extends Model
{
    protected $table = 'additional_trainings';

    protected $fillable = [
        'user_id',
        'training_name',
        'institution_name',
        'location_or_level',
        'year',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
