<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForeignLanguageSkillSet extends Model
{
    protected $fillable = ['user_id', 'certificate_attachment'];

    protected $casts = [
        'certificate_attachment' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function foreignLanguageSkills(): HasMany
    {
        return $this->hasMany(ForeignLanguageSkill::class);
    }
}
