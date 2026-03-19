<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->renameColumn('period_od', 'period_from');
            $table->renameColumn('period_do', 'period_to');
            $table->renameColumn('naziv_poslodavca', 'employer_name');
            $table->renameColumn('naziv_radnog_mesta', 'job_title');
            $table->renameColumn('opis_posla', 'job_description');
            $table->renameColumn('osnov_angazovanja', 'employment_basis');
            $table->renameColumn('zahtevano_obrazovanje', 'required_education');
        });
    }

    public function down(): void
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->renameColumn('period_from', 'period_od');
            $table->renameColumn('period_to', 'period_do');
            $table->renameColumn('employer_name', 'naziv_poslodavca');
            $table->renameColumn('job_title', 'naziv_radnog_mesta');
            $table->renameColumn('job_description', 'opis_posla');
            $table->renameColumn('employment_basis', 'osnov_angazovanja');
            $table->renameColumn('required_education', 'zahtevano_obrazovanje');
        });
    }
};
