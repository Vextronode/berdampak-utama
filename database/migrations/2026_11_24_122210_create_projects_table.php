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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('year')->index();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->string('partner_name'); // Fleksibel dinamis per mitra desa
            $table->string('category')->index(); // sistem-desa, layanan-darurat, profil-desa
            $table->json('tech_stacks')->nullable();
            $table->string('dashboard_thumbnail')->nullable();
            $table->string('live_url')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_title')->nullable();
            $table->string('supervisor_photo_url')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
