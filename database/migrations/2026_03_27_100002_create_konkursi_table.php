<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konkursi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('government_body_id')->nullable()->constrained('government_bodies')->nullOnDelete();
            $table->enum('tip_konkursa', ['Јавни', 'Интерни']);
            $table->date('datum_od');
            $table->date('datum_do');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konkursi');
    }
};
