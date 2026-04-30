<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // High school only
            $table->string('hs_institution_name')->nullable();
            $table->string('hs_institution_location')->nullable();
            $table->string('duration_and_direction')->nullable();
            $table->string('occupation')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();

            // Higher education only
            $table->string('he_institution_name')->nullable();
            $table->string('he_institution_location')->nullable();
            $table->string('study_type')->nullable();
            $table->string('program_name')->nullable();
            $table->string('volume_espb_or_years')->nullable();
            $table->string('title_obtained')->nullable();
            $table->date('graduation_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
