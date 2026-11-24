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
        Schema::table('project_contributors', function (Blueprint $table) {
            $table->string('class_year', 10)->nullable()->after('npm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_contributors', function (Blueprint $table) {
            $table->dropColumn('class_year');
        });
    }
};
