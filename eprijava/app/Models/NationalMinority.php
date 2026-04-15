<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NationalMinority extends Model
{
    protected $table = 'reference_national_minorities';

    protected $fillable = [
        'minority_name',
    ];

    public function declarationMinorities(): HasMany
    {
        return $this->hasMany(DeclarationMinority::class);
    }
}
