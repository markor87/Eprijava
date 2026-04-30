<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('exam_types')->insert([
            ['name' => 'Државни стручни испит', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Испит за инспектора',   'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Правосудни испит',       'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_types');
    }
};
