<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Declaration extends Model
{
    protected $table = 'declarations';

    protected $fillable = [
        'user_id',
        'wants_functional_competency_exemption',
        'behavioral_competency_checked',
        'behavioral_competency_checked_body',
        'behavioral_competency_passed',
        'special_conditions_needed',
        'special_conditions_description',
        'national_minority_member',
        'employment_terminated_for_breach',
        'official_data_collection',
    ];

    protected $casts = [
        'wants_functional_competency_exemption' => 'boolean',
        'special_conditions_needed'             => 'boolean',
        'national_minority_member'              => 'boolean',
        'employment_terminated_for_breach'      => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function declarationProofs(): HasMany
    {
        return $this->hasMany(DeclarationProof::class);
    }
}
