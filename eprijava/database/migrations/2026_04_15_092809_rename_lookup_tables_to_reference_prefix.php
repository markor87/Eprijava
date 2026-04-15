<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('places',              'reference_places');
        Schema::rename('foreign_languages',   'reference_foreign_languages');
        Schema::rename('required_proofs',     'reference_required_proofs');
        Schema::rename('national_minorities', 'reference_national_minorities');
        Schema::rename('academic_titles',     'reference_academic_titles');
        Schema::rename('ranks',               'reference_ranks');
        Schema::rename('exam_types',          'reference_exam_types');
        Schema::rename('government_bodies',   'reference_government_bodies');
        Schema::rename('high_schools',        'reference_high_schools');
    }

    public function down(): void
    {
        Schema::rename('reference_places',              'places');
        Schema::rename('reference_foreign_languages',   'foreign_languages');
        Schema::rename('reference_required_proofs',     'required_proofs');
        Schema::rename('reference_national_minorities', 'national_minorities');
        Schema::rename('reference_academic_titles',     'academic_titles');
        Schema::rename('reference_ranks',               'ranks');
        Schema::rename('reference_exam_types',          'exam_types');
        Schema::rename('reference_government_bodies',   'government_bodies');
        Schema::rename('reference_high_schools',        'high_schools');
    }
};
