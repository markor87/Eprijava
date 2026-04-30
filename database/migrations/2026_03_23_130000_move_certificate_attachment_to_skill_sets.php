<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foreign_language_skill_sets', function (Blueprint $table) {
            $table->json('certificate_attachment')->nullable();
        });

        Schema::table('foreign_language_skills', function (Blueprint $table) {
            $table->dropColumn('certificate_attachment');
        });
    }

    public function down(): void
    {
        Schema::table('foreign_language_skill_sets', function (Blueprint $table) {
            $table->dropColumn('certificate_attachment');
        });

        Schema::table('foreign_language_skills', function (Blueprint $table) {
            $table->string('certificate_attachment')->nullable();
        });
    }
};
