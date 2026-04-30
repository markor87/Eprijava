<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('competition_id')->nullable()->constrained('competitions')->nullOnDelete();
            $table->foreignId('government_body_id')->nullable()->constrained('government_bodies')->nullOnDelete();
            $table->foreignId('job_position_id')->nullable()->constrained('job_positions')->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('national_id');
            $table->string('org_unit_path')->nullable();
            $table->string('rank_name')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'job_position_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
