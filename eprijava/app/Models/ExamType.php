<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamType extends Model
{
    protected $fillable = ['name', 'sort_order'];

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }
}
