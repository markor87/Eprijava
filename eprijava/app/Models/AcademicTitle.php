<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicTitle extends Model
{
    protected $table = 'academic_titles';

    protected $fillable = [
        'educational_scientific_field',
        'scientific_professional_area',
        'title',
    ];
}
