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
            $table->string('study_type')->nullable(false)->change();
            $table->integer('volume_espb')->nullable(false)->change();
            $table->string('institution_name')->nullable(false)->change();
            $table->unsignedBigInteger('institution_location_id')->nullable(false)->change();
            $table->string('program_name')->nullable(false)->change();
            $table->unsignedBigInteger('title_id')->nullable(false)->change();
            $table->string('graduation_date')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('higher_educations', function (Blueprint $table) {
            $table->string('study_type')->nullable()->change();
            $table->integer('volume_espb')->nullable()->change();
            $table->string('institution_name')->nullable()->change();
            $table->unsignedBigInteger('institution_location_id')->nullable()->change();
            $table->string('program_name')->nullable()->change();
            $table->unsignedBigInteger('title_id')->nullable()->change();
            $table->string('graduation_date')->nullable()->change();
        });
    }
};
