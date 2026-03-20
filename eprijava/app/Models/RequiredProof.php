<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequiredProof extends Model
{
    protected $table = 'required_proofs';

    protected $fillable = [
        'proof_description',
        'proof_type',
        'sort_order',
    ];

    public function declarationProofs(): HasMany
    {
        return $this->hasMany(DeclarationProof::class);
    }
}
