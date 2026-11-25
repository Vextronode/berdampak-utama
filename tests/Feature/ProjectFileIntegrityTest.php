<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectFileIntegrityTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->admin = User::factory()->create(['role' => 'superadmin']);
    }

    private function makeProject(string $slug, array $attributes = []): Project
    {
        return Project::create(array_merge([
            'title' => "Proyek {$slug}",
            'slug' => $slug,
            'year' => 2026,
            'summary' => 'Ringkasan proyek',
            'partner_name' => 'Desa Cibenda',
            'category' => 'sistem-desa',
            'is_published' => true,
        ], $attributes));
    }

    private function basePayload(Project $project): array
    {
        return [
            'title' => $project->title,
            'slug' => $project->slug,
            'year' => $project->year,
            'category' => $project->category,
            'partner_name' => $project->partner_name,
            'summary' => $project->summary,
        ];
    }

    public function test_failed_update_keeps_old_files_and_discards_new_uploads(): void
    {
        Storage::disk('public')->put('projects/thumbnails/old.jpg', 'old');
        $project = $this->makeProject('gagal', ['dashboard_thumbnail' => '/storage/projects/thumbnails/old.jpg']);

        Project::updating(fn () => throw new \RuntimeException('Simulasi kegagalan database'));

        $response = $this->actingAs($this->admin)->put(route('apanel.projects.update', $project), $this->basePayload($project) + [
            'dashboard_thumbnail' => UploadedFile::fake()->image('new.jpg'),
        ]);

        $response->assertSessionHasErrors('error');
        Storage::disk('public')->assertExists('projects/thumbnails/old.jpg');
        $this->assertSame(['projects/thumbnails/old.jpg'], Storage::disk('public')->files('projects/thumbnails'));
    }

    public function test_existing_avatar_from_another_project_is_ignored_and_not_deleted(): void
    {
        Storage::disk('public')->put('projects/contributors/other.jpg', 'other');
        $other = $this->makeProject('lain');
        $other->contributors()->create([
            'name' => 'Mahasiswa Lain', 'npm' => '111', 'major' => 'TI', 'role' => 'Dev',
            'avatar_url' => '/storage/projects/contributors/other.jpg',
        ]);
        $project = $this->makeProject('target');

        $this->actingAs($this->admin)->put(route('apanel.projects.update', $project), $this->basePayload($project) + [
            'contributors' => [[
                'name' => 'Mahasiswa Target', 'npm' => '222', 'major' => 'TI', 'role' => 'Dev',
                'existing_avatar' => '/storage/projects/contributors/other.jpg',
                'photo' => UploadedFile::fake()->image('baru.jpg'),
            ]],
        ])->assertSessionHasNoErrors();

        Storage::disk('public')->assertExists('projects/contributors/other.jpg');
        $this->assertNotSame('/storage/projects/contributors/other.jpg', $project->contributors()->value('avatar_url'));
    }

    public function test_existing_gallery_urls_outside_project_are_not_saved(): void
    {
        $project = $this->makeProject('galeri', ['gallery_images' => [
            ['image_url' => '/storage/projects/gallery/milik-sendiri.jpg', 'caption' => 'Sendiri'],
        ]]);

        $this->actingAs($this->admin)->put(route('apanel.projects.update', $project), $this->basePayload($project) + [
            'existing_gallery_urls' => [
                '/storage/projects/gallery/milik-sendiri.jpg',
                '/storage/projects/gallery/milik-proyek-lain.jpg',
                'https://contoh-luar.example/gambar.jpg',
            ],
        ])->assertSessionHasNoErrors();

        $this->assertSame(
            ['/storage/projects/gallery/milik-sendiri.jpg'],
            array_column($project->fresh()->gallery_images, 'image_url'),
        );
    }
}
