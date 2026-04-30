<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('word_has_certificate');
            $table->unsignedSmallInteger('word_certificate_year')->nullable();
            $table->string('word_certificate_attachment')->nullable();
            $table->boolean('excel_has_certificate');
            $table->unsignedSmallInteger('excel_certificate_year')->nullable();
            $table->string('excel_certificate_attachment')->nullable();
            $table->boolean('internet_has_certificate');
            $table->unsignedSmallInteger('internet_certificate_year')->nullable();
            $table->string('internet_certificate_attachment')->nullable();
            $table->boolean('exemption_requested');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_skills');
    }
};
