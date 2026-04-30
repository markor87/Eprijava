<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->string('qualification_level', 255)->nullable()->change();
            $table->string('educational_scientific_field_id', 255)->nullable()->change();
            $table->string('scientific_professional_field_id', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->text('qualification_level')->nullable()->change();
            $table->text('educational_scientific_field_id')->nullable()->change();
            $table->text('scientific_professional_field_id')->nullable()->change();
        });
    }
};
