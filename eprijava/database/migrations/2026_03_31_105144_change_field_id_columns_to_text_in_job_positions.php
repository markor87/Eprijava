<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->text('educational_scientific_field_id')->nullable()->change();
            $table->text('scientific_professional_field_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->unsignedBigInteger('educational_scientific_field_id')->nullable()->change();
            $table->unsignedBigInteger('scientific_professional_field_id')->nullable()->change();
        });
    }
};
