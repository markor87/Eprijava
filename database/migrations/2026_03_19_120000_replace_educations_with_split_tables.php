<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('educations');

        Schema::create('high_school_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('institution_name')->nullable();
            $table->string('institution_location')->nullable();
            $table->string('duration')->nullable();
            $table->string('direction')->nullable();
            $table->string('occupation')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->timestamps();
        });

        Schema::create('higher_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('study_type')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('institution_location')->nullable();
            $table->string('volume_espb_or_years')->nullable();
            $table->string('program_name')->nullable();
            $table->string('title_obtained')->nullable();
            $table->string('graduation_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('high_school_educations');
        Schema::dropIfExists('higher_educations');
    }
};
