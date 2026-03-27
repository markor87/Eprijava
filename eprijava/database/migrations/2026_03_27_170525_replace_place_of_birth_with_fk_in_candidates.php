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
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('place_of_birth');
            $table->foreignId('place_of_birth_id')->nullable()->constrained('places')->nullOnDelete()->after('citizenship');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropForeign(['place_of_birth_id']);
            $table->dropColumn('place_of_birth_id');
            $table->string('place_of_birth')->after('citizenship');
        });
    }
};
