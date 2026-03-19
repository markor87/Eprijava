<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Training extends Model
{
    protected $table = 'trainings';

    protected $fillable = [
        'user_id',
        'has_certificate',
        'exam_type',
        'issuing_authority',
        'exam_date',
    ];

    protected $casts = [
        'has_certificate' => 'boolean',
        'exam_date'       => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
