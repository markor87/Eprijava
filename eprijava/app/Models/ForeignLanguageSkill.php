<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForeignLanguageSkill extends Model
{
    protected $table = 'foreign_language_skills';

    protected $fillable = [
        'foreign_language_skill_set_id',
        'foreign_language_id',
        'level',
        'has_certificate',
        'year_of_examination',
        'exemption_requested',
    ];

    protected $casts = [
        'has_certificate'     => 'boolean',
        'exemption_requested' => 'boolean',
    ];

    public function foreignLanguageSkillSet(): BelongsTo
    {
        return $this->belongsTo(ForeignLanguageSkillSet::class);
    }

    public function foreignLanguage(): BelongsTo
    {
        return $this->belongsTo(ForeignLanguage::class);
    }
}
