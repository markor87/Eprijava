<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->foreign('title_id')->references('id')->on('ranks')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->dropForeign(['title_id']);
        });
    }
};
