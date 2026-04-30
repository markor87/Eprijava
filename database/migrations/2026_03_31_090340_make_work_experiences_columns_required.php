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
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->text('job_description')->nullable(false)->change();
            $table->string('employment_basis')->nullable(false)->change();
            $table->json('required_education')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->text('job_description')->nullable()->change();
            $table->string('employment_basis')->nullable()->change();
            $table->json('required_education')->nullable()->change();
        });
    }
};
