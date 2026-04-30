<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->unique('path');
            $table->timestamps();
        });

        // Populate from computer_skills
        DB::table('computer_skills')->whereNotNull('user_id')->get()->each(function ($skill) {
            foreach (['word_certificate_attachment', 'excel_certificate_attachment', 'internet_certificate_attachment'] as $field) {
                if (!empty($skill->$field)) {
                    DB::table('attachments')->insertOrIgnore([
                        'user_id'    => $skill->user_id,
                        'path'       => $skill->$field,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        // Populate from foreign_language_skill_sets
        DB::table('foreign_language_skill_sets')->whereNotNull('user_id')->get()->each(function ($skillSet) {
            $paths = json_decode($skillSet->certificate_attachment, true) ?? [];
            foreach ($paths as $path) {
                if (!empty($path)) {
                    DB::table('attachments')->insertOrIgnore([
                        'user_id'    => $skillSet->user_id,
                        'path'       => $path,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
