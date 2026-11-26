<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        putenv('ADMIN_PASSWORD');
        parent::tearDown();
    }

    public function test_seeder_refuses_to_run_in_production(): void
    {
        $this->app['env'] = 'production';

        $this->expectException(RuntimeException::class);

        // Dipanggil langsung (setara db:seed --force yang melewati konfirmasi production)
        try {
            $this->app->make(AdminUserSeeder::class)->run();
        } finally {
            $this->assertDatabaseCount('users', 0);
        }
    }

    public function test_seeder_uses_admin_password_from_env(): void
    {
        putenv('ADMIN_PASSWORD=RahasiaLokal-123');

        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'admin@widyatama.ac.id')->firstOrFail();
        $this->assertTrue(Hash::check('RahasiaLokal-123', $admin->password));
        $this->assertSame('superadmin', $admin->role);
    }

    public function test_seeder_generates_random_password_when_env_is_empty(): void
    {
        $this->seed(AdminUserSeeder::class);
        $first = User::where('email', 'admin@widyatama.ac.id')->value('password');

        $this->seed(AdminUserSeeder::class);
        $second = User::where('email', 'admin@widyatama.ac.id')->value('password');

        $this->assertFalse(Hash::check('PasswordBerdampak2026!', $second));
        $this->assertNotSame($first, $second);
        $this->assertDatabaseCount('users', 1);
    }
}
