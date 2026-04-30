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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Personal info
            $table->string('first_name');
            $table->string('last_name');
            $table->string('national_id', 13)->unique();
            $table->string('citizenship');
            $table->string('place_of_birth');

            // Residence address
            $table->string('address_street');
            $table->string('address_postal_code');
            $table->string('address_city');

            // Delivery address (nullable — null means same as residence)
            $table->string('delivery_street')->nullable();
            $table->string('delivery_postal_code')->nullable();
            $table->string('delivery_city')->nullable();

            // Contact
            $table->string('phone');
            $table->string('email');

            // Other
            $table->text('alternative_delivery')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
