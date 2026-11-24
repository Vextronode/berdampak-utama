<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('problem_statement')->nullable()->after('description');
            $table->json('features')->nullable()->after('problem_statement');
            $table->json('gallery_images')->nullable()->after('features');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['problem_statement', 'features', 'gallery_images']);
        });
    }
};
