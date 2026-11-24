<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmptyStateTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_empty_states_when_no_projects_or_field_posts_exist(): void
    {
        $response = $this->get(route('landing'));

        $response->assertStatus(200);
        $response->assertSee('Belum Ada Proyek Inovasi yang Diterbitkan');
        $response->assertSee('Belum Ada Catatan Lapangan');
        $response->assertDontSee('Semua Tahun');
        $response->assertDontSee('Lihat Semua Catatan Kegiatan');
    }

    public function test_public_field_posts_archive_renders_empty_state_when_empty(): void
    {
        $response = $this->get(route('field-posts.index'));

        $response->assertStatus(200);
        $response->assertSee('Belum Ada Catatan Kegiatan yang Diterbitkan');
        $response->assertSee('Kembali ke Beranda');
    }

    public function test_admin_panels_render_empty_states_when_no_records_exist(): void
    {
        $admin = User::factory()->create(['role' => 'superadmin']);

        $this->actingAs($admin)
            ->get(route('apanel.dashboard'))
            ->assertStatus(200)
            ->assertSee('Belum Ada Proyek Terdaftar')
            ->assertSee('Tambah Proyek Pertama');

        $this->actingAs($admin)
            ->get(route('apanel.field-posts.index'))
            ->assertStatus(200)
            ->assertSee('Belum Ada Catatan Lapangan')
            ->assertSee('Tulis Catatan Pertama');
    }
}
