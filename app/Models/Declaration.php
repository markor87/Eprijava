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
        'employment_terminated_for_breach',
        'official_data_collection',
    ];

    protected $casts = [
        'wants_functional_competency_exemption' => 'integer',
        'special_conditions_needed'             => 'integer',
        'employment_terminated_for_breach'      => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function declarationProofs(): HasMany
    {
        return $this->hasMany(DeclarationProof::class);
    }

    public function declarationMinorities(): HasMany
    {
        return $this->hasMany(DeclarationMinority::class);
    }
}
