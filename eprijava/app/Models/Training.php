<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Training extends Model
{
    protected $table = 'trainings';

    protected $fillable = [
        'training_set_id',
        'exam_type_id',
        'has_certificate',
        'issuing_authority',
        'exam_date',
    ];

    protected $casts = [
        'has_certificate' => 'boolean',
        'exam_date'       => 'date',
    ];

    public function trainingSet(): BelongsTo
    {
        return $this->belongsTo(TrainingSet::class);
    }

    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class);
    }
}
