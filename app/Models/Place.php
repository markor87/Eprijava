<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'reference_places';

    protected $fillable = ['name', 'municipality_name'];
}
