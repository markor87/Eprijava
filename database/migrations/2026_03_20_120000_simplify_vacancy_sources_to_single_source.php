<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vacancy_sources', function (Blueprint $table) {
            $table->dropColumn(['internet_presentation', 'press', 'referral', 'nsz', 'live']);
            $table->string('source')->nullable()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('vacancy_sources', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->string('internet_presentation')->nullable();
            $table->string('press')->nullable();
            $table->string('referral')->nullable();
            $table->string('nsz')->nullable();
            $table->string('live')->nullable();
        });
    }
};
