<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vacancy_sources', function (Blueprint $table) {
            $table->string('internet_presentation')->nullable()->change();
            $table->string('press')->nullable()->change();
            $table->string('referral')->nullable()->change();
            $table->string('nsz')->nullable()->change();
            $table->string('live')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('vacancy_sources', function (Blueprint $table) {
            $table->json('internet_presentation')->nullable()->change();
            $table->json('press')->nullable()->change();
            $table->json('referral')->nullable()->change();
            $table->json('nsz')->nullable()->change();
            $table->json('live')->nullable()->change();
        });
    }
};
