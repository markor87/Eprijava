<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foreign_language_skills', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'language']);

            $table->foreignId('foreign_language_skill_set_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('foreign_language_id')->after('foreign_language_skill_set_id')->constrained()->cascadeOnDelete();

            $table->string('level')->nullable()->change();
            $table->boolean('has_certificate')->nullable()->change();
            $table->boolean('exemption_requested')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('foreign_language_skills', function (Blueprint $table) {
            $table->dropForeign(['foreign_language_skill_set_id']);
            $table->dropForeign(['foreign_language_id']);
            $table->dropColumn(['foreign_language_skill_set_id', 'foreign_language_id']);

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('language');

            $table->string('level')->nullable(false)->change();
            $table->boolean('has_certificate')->nullable(false)->change();
            $table->boolean('exemption_requested')->nullable(false)->change();
        });
    }
};
