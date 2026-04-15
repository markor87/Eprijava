<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicTitle extends Model
{
    protected $table = 'reference_academic_titles';

    protected $fillable = [
        'educational_scientific_field',
        'scientific_professional_area',
        'title',
    ];
}
