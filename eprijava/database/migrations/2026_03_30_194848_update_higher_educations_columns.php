<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('higher_educations', function (Blueprint $table) {
            $table->dropColumn(['institution_location', 'volume_espb_or_years', 'title_obtained']);
        });

        Schema::table('higher_educations', function (Blueprint $table) {
            $table->unsignedBigInteger('institution_location_id')->nullable()->after('institution_name');
            $table->foreign('institution_location_id')->references('id')->on('places')->nullOnDelete();
            $table->integer('volume_espb')->nullable()->after('study_type');
            $table->unsignedBigInteger('title_id')->nullable()->after('program_name');
            $table->foreign('title_id')->references('id')->on('academic_titles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('higher_educations', function (Blueprint $table) {
            $table->dropForeign(['institution_location_id']);
            $table->dropForeign(['title_id']);
            $table->dropColumn(['institution_location_id', 'volume_espb', 'title_id']);
        });

        Schema::table('higher_educations', function (Blueprint $table) {
            $table->string('institution_location')->nullable();
            $table->string('volume_espb_or_years')->nullable();
            $table->string('title_obtained')->nullable();
        });
    }
};
