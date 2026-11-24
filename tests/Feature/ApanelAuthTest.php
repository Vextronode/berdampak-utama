<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ApanelAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('admin@widyatama.ac.id|127.0.0.1');
    }

    public function test_accessing_apanel_directly_redirects_to_login_for_guests(): void
    {
        $response = $this->get('/apanel');

        $response->assertRedirect('/apanel/login');
    }

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/apanel/login');

        $response->assertStatus(200);
        $response->assertSee('Portal Pengelola Kampus Berdampak');
        $response->assertSee('Email Institusi / Username');
        $response->assertSee('Kata Sandi');
        $response->assertSee('Masuk ke Panel Pengelola');
        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-cache', (string) $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('must-revalidate', (string) $response->headers->get('Cache-Control'));
        $response->assertHeader('Pragma', 'no-cache');
    }

    public function test_user_cannot_authenticate_with_invalid_credentials(): void
    {
        $response = $this->post('/apanel/login', [
            'email' => 'wrong@widyatama.ac.id',
            'password' => 'invalid-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_authenticate_with_valid_credentials(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@widyatama.ac.id'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('PasswordBerdampak2026!'),
                'role' => 'superadmin',
            ]
        );

        $response = $this->post('/apanel/login', [
            'email' => 'admin@widyatama.ac.id',
            'password' => 'PasswordBerdampak2026!',
        ]);

        $response->assertRedirect('/apanel/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_user_accessing_apanel_redirects_to_dashboard(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get('/apanel');

        $response->assertRedirect('/apanel/dashboard');
    }

    public function test_authenticated_user_accessing_login_page_redirects_to_dashboard(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get('/apanel/login');

        $response->assertRedirect('/apanel/dashboard');
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get('/apanel/dashboard');

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee('Total Proyek');
    }

    public function test_user_can_logout(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->post('/apanel/logout');

        $response->assertRedirect('/apanel/login');
        $this->assertGuest();
    }

    public function test_login_rate_limiting_locks_out_after_five_failed_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/apanel/login', [
                'email' => 'admin@widyatama.ac.id',
                'password' => 'wrong-pass',
            ]);
        }

        $response = $this->post('/apanel/login', [
            'email' => 'admin@widyatama.ac.id',
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertTrue(session('errors')->first('email') !== null);
        $this->assertStringContainsString('Terlalu banyak percobaan', session('errors')->first('email'));
    }
}
