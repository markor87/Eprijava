<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('high_school_educations')->update([
            'institution_name'     => null,
            'institution_location' => null,
        ]);

        Schema::table('high_school_educations', function (Blueprint $table) {
            $table->unsignedBigInteger('institution_name')->nullable()->change();
            $table->unsignedBigInteger('institution_location')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('high_school_educations', function (Blueprint $table) {
            $table->string('institution_name')->nullable()->change();
            $table->string('institution_location')->nullable()->change();
        });
    }
};
