<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HighSchool extends Model
{
    protected $table = 'reference_high_schools';

    protected $fillable = ['name', 'city'];
}
