<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeclarationMinority extends Model
{
    protected $table = 'declaration_minorities';

    protected $fillable = [
        'declaration_id',
        'national_minority_id',
        'choice',
    ];

    public function declaration(): BelongsTo
    {
        return $this->belongsTo(Declaration::class);
    }

    public function nationalMinority(): BelongsTo
    {
        return $this->belongsTo(NationalMinority::class);
    }
}
