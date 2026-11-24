<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * AdminUserSeeder sengaja tidak dipanggil di sini untuk produksi.
     * Buat akun admin secara manual lewat Tinker setelah deploy pertama
     * (lihat docs/DEPLOYMENT.md, Bagian 3 Langkah 6).
     * Untuk dev lokal: php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        $this->call([
            TechStackSeeder::class,
            ProjectSeeder::class,
        ]);
    }
}
