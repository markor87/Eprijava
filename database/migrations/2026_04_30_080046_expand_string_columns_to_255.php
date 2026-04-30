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
        Schema::table('job_positions', function (Blueprint $table) {
            $table->string('position_name', 255)->nullable()->change();
            $table->string('org_unit_path', 255)->nullable()->change();
            $table->string('organizational_unit', 255)->nullable()->change();
            $table->string('sector', 255)->nullable()->change();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->string('org_unit_path', 255)->nullable()->change();
            $table->string('rank_name', 255)->nullable()->change();
        });

        Schema::table('higher_educations', function (Blueprint $table) {
            $table->string('program_name', 255)->change();
            $table->string('institution_name', 255)->change();
        });

        Schema::table('work_experiences', function (Blueprint $table) {
            $table->string('employer_name', 255)->change();
            $table->string('job_title', 255)->change();
        });

        Schema::table('additional_trainings', function (Blueprint $table) {
            $table->string('training_name', 255)->change();
            $table->string('institution_name', 255)->change();
        });

        Schema::table('reference_government_bodies', function (Blueprint $table) {
            $table->string('name', 255)->change();
        });

        Schema::table('candidates', function (Blueprint $table) {
            $table->string('address_street', 255)->change();
            $table->string('delivery_street', 255)->nullable()->change();
        });

        Schema::table('reference_academic_titles', function (Blueprint $table) {
            $table->string('educational_scientific_field', 255)->change();
            $table->string('scientific_professional_area', 255)->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->string('position_name', 100)->nullable()->change();
            $table->string('org_unit_path', 100)->nullable()->change();
            $table->string('organizational_unit', 100)->nullable()->change();
            $table->string('sector', 100)->nullable()->change();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->string('org_unit_path', 100)->nullable()->change();
            $table->string('rank_name', 100)->nullable()->change();
        });

        Schema::table('higher_educations', function (Blueprint $table) {
            $table->string('program_name', 100)->change();
            $table->string('institution_name', 100)->change();
        });

        Schema::table('work_experiences', function (Blueprint $table) {
            $table->string('employer_name', 100)->change();
            $table->string('job_title', 100)->change();
        });

        Schema::table('additional_trainings', function (Blueprint $table) {
            $table->string('training_name', 100)->change();
            $table->string('institution_name', 100)->change();
        });

        Schema::table('reference_government_bodies', function (Blueprint $table) {
            $table->string('name', 100)->change();
        });

        Schema::table('candidates', function (Blueprint $table) {
            $table->string('address_street', 100)->change();
            $table->string('delivery_street', 100)->nullable()->change();
        });

        Schema::table('reference_academic_titles', function (Blueprint $table) {
            $table->string('educational_scientific_field', 100)->change();
            $table->string('scientific_professional_area', 100)->change();
        });
    }
};
