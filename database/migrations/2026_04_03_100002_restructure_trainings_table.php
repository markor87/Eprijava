<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create a training_set for each distinct user that has trainings
        $userIds = DB::table('trainings')->distinct()->pluck('user_id');
        foreach ($userIds as $userId) {
            DB::table('training_sets')->insert([
                'user_id'    => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Add new columns
        Schema::table('trainings', function (Blueprint $table) {
            $table->unsignedBigInteger('training_set_id')->nullable()->after('id');
            $table->unsignedBigInteger('exam_type_id')->nullable()->after('training_set_id');
        });

        // 3. Populate training_set_id from user_id
        $sets = DB::table('training_sets')->get()->keyBy('user_id');
        DB::table('trainings')->get()->each(function ($row) use ($sets) {
            $setId = $sets[$row->user_id]?->id ?? null;

            $examTypeId = DB::table('exam_types')
                ->where('name', $row->exam_type)
                ->value('id');

            DB::table('trainings')
                ->where('id', $row->id)
                ->update([
                    'training_set_id' => $setId,
                    'exam_type_id'    => $examTypeId,
                ]);
        });

        // 4. Add FK constraints and drop old columns
        Schema::table('trainings', function (Blueprint $table) {
            $table->foreign('training_set_id')->references('id')->on('training_sets')->cascadeOnDelete();
            $table->foreign('exam_type_id')->references('id')->on('exam_types')->nullOnDelete();
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'exam_type']);
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('exam_type')->nullable();
            $table->dropForeign(['training_set_id']);
            $table->dropForeign(['exam_type_id']);
            $table->dropColumn(['training_set_id', 'exam_type_id']);
        });
    }
};
