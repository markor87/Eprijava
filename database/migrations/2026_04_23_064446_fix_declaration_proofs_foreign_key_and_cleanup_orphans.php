<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Remove orphaned rows whose required_proof no longer exists
        DB::table('declaration_proofs')
            ->whereNotIn('required_proof_id', DB::table('reference_required_proofs')->pluck('id'))
            ->delete();

        // Drop the old FK (was generated against old table name 'required_proofs')
        Schema::table('declaration_proofs', function (Blueprint $table) {
            $table->dropForeign(['required_proof_id']);
        });

        // Recreate FK pointing to the renamed table
        Schema::table('declaration_proofs', function (Blueprint $table) {
            $table->foreign('required_proof_id')
                ->references('id')
                ->on('reference_required_proofs')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('declaration_proofs', function (Blueprint $table) {
            $table->dropForeign(['required_proof_id']);
        });

        Schema::table('declaration_proofs', function (Blueprint $table) {
            $table->foreign('required_proof_id')
                ->references('id')
                ->on('required_proofs')
                ->cascadeOnDelete();
        });
    }
};
