<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacancy_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('internet_presentation')->nullable();
            $table->json('press')->nullable();
            $table->json('referral')->nullable();
            $table->json('nsz')->nullable();
            $table->json('live')->nullable();
            $table->boolean('interested_in_other_jobs')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacancy_sources');
    }
};
