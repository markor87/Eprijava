<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SifarnikSrednjeSkole extends Model
{
    protected $table = 'high_schools';

    protected $fillable = ['name', 'city'];
}
