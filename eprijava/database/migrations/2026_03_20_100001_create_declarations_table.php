<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('declarations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('wants_functional_competency_exemption')->default(false);
            $table->boolean('behavioral_competency_checked')->default(false);
            $table->string('behavioral_competency_checked_body')->nullable();
            $table->string('behavioral_competency_passed')->nullable();
            $table->boolean('special_conditions_needed')->default(false);
            $table->string('special_conditions_description')->nullable();
            $table->boolean('national_minority_member')->default(false);
            $table->boolean('employment_terminated_for_breach')->default(false);
            $table->string('official_data_collection')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('declarations');
    }
};
