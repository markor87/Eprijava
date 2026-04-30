<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->text('position_name')->nullable()->change();
            $table->text('organizational_unit')->nullable()->change();
            $table->text('org_unit_path')->nullable()->change();
            $table->text('sector')->nullable()->change();
            $table->text('qualification_level')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->string('position_name')->nullable()->change();
            $table->string('organizational_unit')->nullable()->change();
            $table->string('org_unit_path')->nullable()->change();
            $table->string('sector')->nullable()->change();
            $table->string('qualification_level')->nullable()->change();
        });
    }
};
