<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foreign_language_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('language');
            $table->string('level');
            $table->boolean('has_certificate');
            $table->unsignedSmallInteger('year_of_examination')->nullable();
            $table->boolean('exemption_requested');
            $table->string('certificate_attachment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foreign_language_skills');
    }
};
