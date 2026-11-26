<?php

namespace Tests\Feature;

use App\Models\FieldPost;
use App\Models\Project;
use App\Models\TechStack;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminFailureHandlingTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->admin = User::factory()->create(['role' => 'superadmin']);
    }

    public function test_project_save_failure_shows_reference_code_without_internal_details(): void
    {
        Project::creating(fn () => throw new \RuntimeException('SQLSTATE rahasia internal'));

        $loggedCode = null;
        Log::shouldReceive('error')->once()->withArgs(function (string $message) use (&$loggedCode) {
            preg_match('/\[(ERR-[0-9A-F]{6})\]/', $message, $match);
            $loggedCode = $match[1] ?? null;

            return $loggedCode !== null;
        });

        $response = $this->actingAs($this->admin)->post(route('apanel.projects.store'), [
            'title' => 'Proyek Gagal',
            'slug' => 'proyek-gagal',
            'year' => 2026,
            'category' => 'sistem-desa',
            'partner_name' => 'Desa Cibenda',
            'summary' => 'Ringkasan',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('error');

        $message = session('errors')->first('error');
        $this->assertStringStartsWith('Gagal menyimpan data proyek. Sampaikan kode ERR-', $message);
        $this->assertStringContainsString($loggedCode, $message);
        $this->assertStringNotContainsString('SQLSTATE', $message);
    }

    public function test_field_post_save_failure_returns_to_form_with_input_and_removes_cover(): void
    {
        FieldPost::creating(fn () => throw new \RuntimeException('DB mati'));
        Log::shouldReceive('error')->once();

        $response = $this->actingAs($this->admin)
            ->from(route('apanel.field-posts.create'))
            ->post(route('apanel.field-posts.store'), [
                'title' => 'Survei Lapangan',
                'slug' => 'survei-lapangan',
                'activity_date' => '2026-04-01',
                'content' => 'Isi cerita kegiatan',
                'cover_image' => UploadedFile::fake()->image('sampul.jpg'),
            ]);

        $response->assertRedirect(route('apanel.field-posts.create'));
        $response->assertSessionHasInput('title', 'Survei Lapangan');
        $this->assertStringStartsWith('Gagal menyimpan catatan lapangan. Sampaikan kode ERR-', session('errors')->first('error'));
        $this->assertSame([], Storage::disk('public')->allFiles('field-posts/covers'));
    }

    public function test_failed_field_post_update_keeps_old_cover_file(): void
    {
        Storage::disk('public')->put('field-posts/covers/lama.jpg', 'lama');
        $post = FieldPost::create([
            'title' => 'Catatan Lama',
            'slug' => 'catatan-lama',
            'activity_date' => '2026-04-01',
            'content' => 'Isi lama',
            'cover_image' => '/storage/field-posts/covers/lama.jpg',
            'is_published' => true,
        ]);

        FieldPost::updating(fn () => throw new \RuntimeException('DB mati'));
        Log::shouldReceive('error')->once();

        $response = $this->actingAs($this->admin)
            ->from(route('apanel.field-posts.edit', $post))
            ->put(route('apanel.field-posts.update', $post), [
                'title' => 'Catatan Baru',
                'slug' => 'catatan-lama',
                'activity_date' => '2026-04-01',
                'content' => 'Isi baru',
                'cover_image' => UploadedFile::fake()->image('baru.jpg'),
            ]);

        $response->assertRedirect(route('apanel.field-posts.edit', $post));
        $response->assertSessionHasInput('title', 'Catatan Baru');
        $this->assertStringStartsWith('Gagal memperbarui catatan lapangan. Sampaikan kode ERR-', session('errors')->first('error'));

        Storage::disk('public')->assertExists('field-posts/covers/lama.jpg');
        $this->assertSame(['field-posts/covers/lama.jpg'], Storage::disk('public')->allFiles('field-posts/covers'));
        $this->assertSame('/storage/field-posts/covers/lama.jpg', $post->fresh()->cover_image);
    }

    public function test_error_box_heading_distinguishes_server_failure_from_form_errors(): void
    {
        // Kesalahan isian form: judul lama
        $this->actingAs($this->admin)
            ->from(route('apanel.projects.create'))
            ->followingRedirects()
            ->post(route('apanel.projects.store'), [])
            ->assertSee('Terdapat beberapa kesalahan pengisian formulir:')
            ->assertDontSee('Perubahan belum tersimpan:');

        // Kegagalan server: judul baru
        Project::creating(fn () => throw new \RuntimeException('DB mati'));
        Log::shouldReceive('error')->once();

        $this->actingAs($this->admin)
            ->from(route('apanel.projects.create'))
            ->followingRedirects()
            ->post(route('apanel.projects.store'), [
                'title' => 'Proyek Gagal',
                'slug' => 'proyek-gagal',
                'year' => 2026,
                'category' => 'sistem-desa',
                'partner_name' => 'Desa Cibenda',
                'summary' => 'Ringkasan',
            ])
            ->assertSee('Perubahan belum tersimpan:')
            ->assertDontSee('Terdapat beberapa kesalahan pengisian formulir:');
    }

    public function test_monogram_handles_non_ascii_names(): void
    {
        $monogram = fn (string $name) => (new TechStack(['name' => $name]))->monogram;

        $this->assertSame('LA', $monogram('Laravel'));
        $this->assertSame('RT', $monogram('Redux Toolkit'));
        $this->assertSame('ÉL', $monogram('Élan'));
        $this->assertSame('ÖS', $monogram('Öko Stack'));
    }
}
