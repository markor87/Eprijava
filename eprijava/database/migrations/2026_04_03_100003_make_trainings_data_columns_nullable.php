<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->boolean('has_certificate')->nullable()->change();
            $table->string('issuing_authority')->nullable()->change();
            $table->date('exam_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->boolean('has_certificate')->nullable(false)->change();
            $table->string('issuing_authority')->nullable(false)->change();
            $table->date('exam_date')->nullable(false)->change();
        });
    }
};
