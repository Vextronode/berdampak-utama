<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@widyatama.ac.id'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('PasswordBerdampak2026!'),
                'role' => 'superadmin',
            ]
        );
    }
}
