<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foreign_languages', function (Blueprint $table) {
            $table->id();
            $table->string('language_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foreign_languages');
    }
};
