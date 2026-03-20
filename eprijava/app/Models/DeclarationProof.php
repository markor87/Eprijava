<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeclarationProof extends Model
{
    protected $table = 'declaration_proofs';

    protected $fillable = [
        'declaration_id',
        'required_proof_id',
        'declaration_choice',
    ];

    public function declaration(): BelongsTo
    {
        return $this->belongsTo(Declaration::class);
    }

    public function requiredProof(): BelongsTo
    {
        return $this->belongsTo(RequiredProof::class);
    }
}
