<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Change the column default so new users get it enabled automatically
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_email_authentication')->default(true)->change();
        });

        // Enable it for all existing users
        DB::table('users')->update(['has_email_authentication' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_email_authentication')->default(false)->change();
        });
    }
};
