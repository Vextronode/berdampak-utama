<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\TechStack;
use App\Models\User;
use Database\Seeders\TechStackSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApanelProjectCreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(TechStackSeeder::class);

        $this->admin = User::factory()->create([
            'email' => 'admin@widyatama.ac.id',
            'role' => 'superadmin',
        ]);
    }

    public function test_guest_is_redirected_to_login_when_accessing_create_project_page(): void
    {
        $response = $this->get(route('apanel.projects.create'));

        $response->assertStatus(302);
        $response->assertRedirect(route('apanel.login'));
    }

    public function test_authenticated_admin_can_view_create_project_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('apanel.projects.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Proyek Baru');
        $response->assertSee('1. Informasi Umum');
        $response->assertSee('2. Deskripsi Proyek');
        $response->assertSee('3. Tangkapan Layar Dashboard Utama');
        $response->assertSee('4. Pilih Teknologi yang Digunakan');
        $response->assertSee('5. Tim Pengembang');
        $response->assertSee('Publikasikan Proyek Sekarang');
        $response->assertSee('Simpan sebagai Draft');
        $response->assertSee('Laravel');
        $response->assertSee('React');
    }

    public function test_validation_fails_when_required_fields_are_missing(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('apanel.projects.store'), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'title',
            'slug',
            'year',
            'category',
            'partner_name',
            'summary',
        ]);
    }

    public function test_slug_uniqueness_validation_fails_if_slug_already_taken(): void
    {
        Project::create([
            'title' => 'SIGAP Existing',
            'slug' => 'sigap',
            'year' => 2026,
            'summary' => 'Existing project summary',
            'partner_name' => 'Desa Cibenda',
            'category' => 'Layanan Tanggap Darurat & Pengaduan',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->admin)->post(route('apanel.projects.store'), [
            'title' => 'SIGAP Proyek Baru',
            'slug' => '/projek/sigap',
            'year' => 2026,
            'category' => 'Layanan Tanggap Darurat & Pengaduan',
            'partner_name' => 'Desa Cibenda',
            'summary' => 'Deskripsi singkat proyek',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['slug']);
    }

    public function test_admin_can_successfully_store_new_project_with_all_cards_data(): void
    {
        Storage::fake('public');

        $laravelStack = TechStack::where('slug', 'laravel')->first();
        $reactStack = TechStack::where('slug', 'react')->first();

        $thumbnail = UploadedFile::fake()->image('dashboard_16_9.png', 1920, 1080);
        $supervisorPhoto = UploadedFile::fake()->image('hendra.jpg', 400, 400);
        $galleryPhoto1 = UploadedFile::fake()->image('desa1.jpg', 800, 600);
        $galleryPhoto2 = UploadedFile::fake()->image('desa2.jpg', 800, 600);
        $mhsPhoto = UploadedFile::fake()->image('naufal.jpg', 300, 300);

        $payload = [
            // Card 1
            'title' => 'SIGAP - Sistem Tanggap Darurat',
            'slug' => '/projek/sigap-tanggap-darurat',
            'year' => 2026,
            'category' => 'Layanan Tanggap Darurat & Pengaduan',
            'partner_name' => 'Pemerintah Desa Cibenda, Bandung Barat',
            'live_url' => 'https://sigap.desa-cibenda.id',
            'is_published' => '1',

            // Card 2
            'summary' => 'Sistem penanganan insiden darurat dan peringatan bencana real-time untuk warga Desa Cibenda.',
            'problem_statement' => "Latar Belakang Masalah:\nWarga kesulitan melapor secara terpusat.\n\nSolusi Sistem:\nSistem darurat berbasis GPS.",
            'features' => [
                [
                    'icon' => 'emergency',
                    'title' => 'Tombol Darurat Real-Time',
                    'description' => 'Mengirim sinyal bahaya beserta lokasi warga ke perangkat desa.',
                ],
                [
                    'icon' => 'location',
                    'title' => 'Pemetaan Lokasi Insiden',
                    'description' => 'Titik koordinat muncul otomatis di peta operator.',
                ],
            ],
            'gallery_images' => [$galleryPhoto1, $galleryPhoto2],
            'gallery_captions' => ['Sosialisasi aplikasi kepada warga', 'Pelatihan operator desa'],

            // Card 3
            'dashboard_thumbnail' => $thumbnail,

            // Card 4
            'tech_stack_ids' => [$laravelStack->id, $reactStack->id],
            'custom_tech_stacks' => 'Prisma ORM, WhatsApp Cloud API',

            // Card 5
            'supervisor_name' => 'Dr. Hendra Wijaya, M.Kom.',
            'supervisor_title' => 'Dosen Pembimbing & Penanggung Jawab',
            'supervisor_photo' => $supervisorPhoto,
            'contributors' => [
                [
                    'name' => 'Naufal Fadhiil',
                    'npm' => '230611103',
                    'class_year' => '2023',
                    'major' => 'S1 Teknik Informatika',
                    'role' => 'Tech Lead & Full Stack Developer',
                    'photo' => $mhsPhoto,
                ],
                [
                    'name' => 'Raka Pratama',
                    'npm' => '230611115',
                    'class_year' => '2023',
                    'major' => 'S1 Teknik Informatika',
                    'role' => 'Frontend Developer',
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('apanel.projects.store'), $payload);

        $response->assertStatus(302);
        $response->assertRedirect(route('apanel.dashboard'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('projects', [
            'slug' => 'sigap-tanggap-darurat',
            'partner_name' => 'Pemerintah Desa Cibenda, Bandung Barat',
            'year' => 2026,
            'is_published' => true,
        ]);

        $project = Project::where('slug', 'sigap-tanggap-darurat')->first();
        $this->assertNotNull($project);
        $this->assertNotNull($project->dashboard_thumbnail);
        $this->assertNotNull($project->supervisor_photo_url);
        $this->assertCount(2, $project->gallery_images);

        // Verifikasi relasi pivot tech stack
        $this->assertTrue($project->techStackItems->contains($laravelStack));
        $this->assertTrue($project->techStackItems->contains($reactStack));

        // Verifikasi custom tech stacks dibuat dan di-link
        $prismaStack = TechStack::where('slug', 'prisma-orm')->first();
        $this->assertNotNull($prismaStack);
        $this->assertTrue($project->techStackItems->contains($prismaStack));

        // Verifikasi kontributor tersimpan
        $this->assertCount(2, $project->contributors);
        $this->assertDatabaseHas('project_contributors', [
            'project_id' => $project->id,
            'name' => 'Naufal Fadhiil',
            'npm' => '230611103',
            'class_year' => '2023',
            'major' => 'S1 Teknik Informatika',
            'role' => 'Tech Lead & Full Stack Developer',
        ]);
        $this->assertDatabaseHas('project_contributors', [
            'project_id' => $project->id,
            'name' => 'Raka Pratama',
            'npm' => '230611115',
            'class_year' => '2023',
            'major' => 'S1 Teknik Informatika',
            'role' => 'Frontend Developer',
        ]);

        // Verifikasi halaman detail proyek dapat dirender tanpa error
        $detailResponse = $this->get(route('projects.show', $project->slug));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('SIGAP - Sistem Tanggap Darurat');
        $detailResponse->assertSee('Sosialisasi aplikasi kepada warga');
        $detailResponse->assertSee('Angkatan 2023');
        $detailResponse->assertSee('Laravel');
        $detailResponse->assertSee('Fitur Kunci Sistem');
        $detailResponse->assertSee('Tombol Darurat Real-Time');
        $detailResponse->assertSee('Pemetaan Lokasi Insiden');
    }

    public function test_admin_can_save_project_as_draft(): void
    {
        $payload = [
            'title' => 'Proyek Draf Inovasi Desa',
            'slug' => '/projek/proyek-draf-inovasi-desa',
            'year' => 2026,
            'category' => 'Sistem Informasi Desa',
            'partner_name' => 'Desa Sukamaju',
            'summary' => 'Ringkasan singkat proyek draf.',
            'is_published' => '0',
        ];

        $response = $this->actingAs($this->admin)->post(route('apanel.projects.store'), $payload);

        $response->assertStatus(302);
        $response->assertRedirect(route('apanel.dashboard'));

        $this->assertDatabaseHas('projects', [
            'slug' => 'proyek-draf-inovasi-desa',
            'is_published' => false,
        ]);
    }

    public function test_dashboard_displays_registered_projects_with_edit_and_delete_controls(): void
    {
        $project = Project::create([
            'title' => 'Sistem Desa Digital Mandiri',
            'slug' => 'sistem-desa-digital-mandiri',
            'year' => 2027,
            'summary' => 'Sistem administrasi desa.',
            'partner_name' => 'Desa Mekarwangi',
            'category' => 'Sistem Informasi Desa',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('apanel.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Proyek Terdaftar');
        $response->assertSee('Sistem Desa Digital Mandiri');
        $response->assertSee('Desa Mekarwangi');
        $response->assertSee(route('apanel.projects.edit', $project));
        $response->assertSee(route('apanel.projects.destroy', $project));
    }

    public function test_admin_can_view_and_update_existing_project(): void
    {
        Storage::fake('public');

        $laravelStack = TechStack::where('slug', 'laravel')->first();
        $goStack = TechStack::where('slug', 'go')->first();

        $oldThumb = UploadedFile::fake()->image('old.png', 800, 450)->store('projects/thumbnails', 'public');

        $project = Project::create([
            'title' => 'Proyek Lama',
            'slug' => 'proyek-lama',
            'year' => 2026,
            'summary' => 'Ringkasan lama.',
            'partner_name' => 'Desa Lama',
            'category' => 'E-Government',
            'dashboard_thumbnail' => '/storage/'.$oldThumb,
            'is_published' => true,
        ]);
        $project->techStackItems()->sync([$laravelStack->id]);

        $editPage = $this->actingAs($this->admin)->get(route('apanel.projects.edit', $project));
        $editPage->assertStatus(200);
        $editPage->assertSee('Edit Proyek');
        $editPage->assertSee('Proyek Lama');

        $newThumb = UploadedFile::fake()->image('new.png', 1920, 1080);

        $updateResponse = $this->actingAs($this->admin)->put(route('apanel.projects.update', $project), [
            'title' => 'Proyek Diperbarui',
            'slug' => 'proyek-lama',
            'year' => 2027,
            'category' => 'Sistem Layanan Publik',
            'partner_name' => 'Desa Baru Maju',
            'summary' => 'Ringkasan proyek yang telah diperbarui.',
            'dashboard_thumbnail' => $newThumb,
            'tech_stack_ids' => [$goStack->id],
            'contributors' => [
                [
                    'name' => 'Raihan Dastra',
                    'npm' => '230611001',
                    'class_year' => '2023',
                    'major' => 'S1 Teknik Informatika',
                    'role' => 'Lead Developer',
                ],
            ],
            'is_published' => '1',
        ]);

        $updateResponse->assertStatus(302);
        $updateResponse->assertRedirect(route('apanel.dashboard'));

        $project->refresh();
        $this->assertEquals('Proyek Diperbarui', $project->title);
        $this->assertEquals(2027, $project->year);
        $this->assertEquals('Desa Baru Maju', $project->partner_name);
        $this->assertTrue($project->techStackItems->contains($goStack));
        $this->assertFalse($project->techStackItems->contains($laravelStack));
        $this->assertCount(1, $project->contributors);
        $this->assertEquals('Raihan Dastra', $project->contributors->first()->name);
        Storage::disk('public')->assertMissing($oldThumb);
    }

    public function test_admin_can_toggle_publish_status_and_delete_project(): void
    {
        Storage::fake('public');
        $thumbPath = UploadedFile::fake()->image('thumb.png', 800, 450)->store('projects/thumbnails', 'public');

        $project = Project::create([
            'title' => 'Proyek Uji Hapus',
            'slug' => 'proyek-uji-hapus',
            'year' => 2027,
            'summary' => 'Ringkasan uji hapus.',
            'partner_name' => 'Desa Cihampelas',
            'category' => 'Inovasi Desa',
            'dashboard_thumbnail' => '/storage/'.$thumbPath,
            'is_published' => true,
        ]);

        $project->contributors()->create([
            'name' => 'Test Student',
            'npm' => '230611099',
            'class_year' => '2023',
            'major' => 'S1 Teknik Informatika',
            'role' => 'Developer',
        ]);

        // Toggle Publish -> Draft
        $toggleResp = $this->actingAs($this->admin)->patch(route('apanel.projects.toggle-publish', $project));
        $toggleResp->assertRedirect(route('apanel.dashboard'));
        $this->assertFalse($project->fresh()->is_published);

        // Delete Project
        $deleteResp = $this->actingAs($this->admin)->delete(route('apanel.projects.destroy', $project));
        $deleteResp->assertRedirect(route('apanel.dashboard'));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        $this->assertDatabaseMissing('project_contributors', ['project_id' => $project->id]);
        Storage::disk('public')->assertMissing($thumbPath);
    }
}
