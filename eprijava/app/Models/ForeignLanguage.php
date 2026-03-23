<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForeignLanguage extends Model
{
    protected $fillable = ['language_name'];

    public function foreignLanguageSkills(): HasMany
    {
        return $this->hasMany(ForeignLanguageSkill::class);
    }
}
