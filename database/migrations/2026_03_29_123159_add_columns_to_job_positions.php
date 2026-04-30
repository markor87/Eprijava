<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->integer('sequence_number')->nullable()->after('position_name');
            $table->string('organizational_unit')->nullable()->after('sequence_number');
            $table->string('org_unit_path')->nullable()->after('organizational_unit');
            $table->string('sector')->nullable()->after('org_unit_path');
            $table->enum('employment_type', ['Неодређено', 'Одређено'])->nullable()->after('sector');
            $table->foreignId('work_location_id')->nullable()->after('employment_type')
                ->constrained('places')->nullOnDelete();
            $table->unsignedBigInteger('educational_scientific_field_id')->nullable()->after('work_location_id');
            $table->unsignedBigInteger('scientific_professional_field_id')->nullable()->after('educational_scientific_field_id');
            $table->unsignedBigInteger('title_id')->nullable()->after('scientific_professional_field_id');
            $table->string('qualification_level')->nullable()->after('title_id');
            $table->integer('executor_count')->nullable()->after('qualification_level');
        });
    }

    public function down(): void
    {
        Schema::table('job_positions', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Place::class, 'work_location_id');
            $table->dropColumn([
                'sequence_number',
                'organizational_unit',
                'org_unit_path',
                'sector',
                'employment_type',
                'work_location_id',
                'educational_scientific_field_id',
                'scientific_professional_field_id',
                'title_id',
                'qualification_level',
                'executor_count',
            ]);
        });
    }
};
