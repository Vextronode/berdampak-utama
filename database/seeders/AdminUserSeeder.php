<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Khusus dev lokal. Password diambil dari ADMIN_PASSWORD, atau dibuat acak
     * dan ditampilkan sekali di terminal. Akun produksi dibuat lewat Tinker
     * (docs/DEPLOYMENT.md Langkah 6).
     */
    public function run(): void
    {
        if (app()->isProduction()) {
            throw new RuntimeException('AdminUserSeeder tidak boleh dijalankan di production. Buat akun admin lewat Tinker (docs/DEPLOYMENT.md Langkah 6).');
        }

        $password = env('ADMIN_PASSWORD') ?: Str::password(16);

        User::updateOrCreate(
            ['email' => 'admin@widyatama.ac.id'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make($password),
                'role' => 'superadmin',
            ]
        );

        if (! env('ADMIN_PASSWORD')) {
            $this->command?->warn("Akun admin lokal: admin@widyatama.ac.id / {$password} (simpan, tidak ditampilkan lagi)");
        }
    }
}
