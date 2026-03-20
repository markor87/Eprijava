<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('declaration_proofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('required_proof_id')->constrained()->cascadeOnDelete();
            $table->string('declaration_choice')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('declaration_proofs');
    }
};
