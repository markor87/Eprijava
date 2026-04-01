<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('government_bodies', function (Blueprint $table) {
            $table->string('government_body_code')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('government_bodies', function (Blueprint $table) {
            $table->dropColumn('government_body_code');
        });
    }
};
