<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('computer_skills', function (Blueprint $table) {
            $table->boolean('word_exemption_requested')->after('word_certificate_attachment')->default(false);
            $table->boolean('excel_exemption_requested')->after('excel_certificate_attachment')->default(false);
            $table->boolean('internet_exemption_requested')->after('internet_certificate_attachment')->default(false);
            $table->dropColumn('exemption_requested');
        });
    }

    public function down(): void
    {
        Schema::table('computer_skills', function (Blueprint $table) {
            $table->boolean('exemption_requested')->default(false);
            $table->dropColumn(['word_exemption_requested', 'excel_exemption_requested', 'internet_exemption_requested']);
        });
    }
};
