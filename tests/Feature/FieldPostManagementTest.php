<?php

namespace Tests\Feature;

use App\Models\FieldPost;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FieldPostManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@widyatama.ac.id',
            'role' => 'superadmin',
        ]);
    }

    public function test_guest_is_redirected_when_accessing_apanel_field_posts(): void
    {
        $this->get(route('apanel.field-posts.index'))
            ->assertRedirect(route('apanel.login'));

        $this->get(route('apanel.field-posts.create'))
            ->assertRedirect(route('apanel.login'));
    }

    public function test_admin_can_create_edit_toggle_and_delete_field_post(): void
    {
        Storage::fake('public');

        $project = Project::create([
            'title' => 'SIGAP Desa Cibenda',
            'slug' => 'sigap-desa-cibenda',
            'year' => 2026,
            'summary' => 'Sistem tanggap darurat.',
            'partner_name' => 'Desa Cibenda',
            'category' => 'Tanggap Darurat',
            'is_published' => true,
        ]);

        // 1. View index & create form
        $this->actingAs($this->admin)
            ->get(route('apanel.field-posts.index'))
            ->assertStatus(200)
            ->assertSee('Daftar Catatan Kegiatan');

        $this->actingAs($this->admin)
            ->get(route('apanel.field-posts.create'))
            ->assertStatus(200)
            ->assertSee('Tulis Catatan Lapangan');

        // 2. Store new field post
        $cover = UploadedFile::fake()->image('kegiatan.jpg', 1200, 675);

        $storeResp = $this->actingAs($this->admin)->post(route('apanel.field-posts.store'), [
            'title' => 'Pelatihan Operator Desa Cibenda',
            'slug' => '/catatan/pelatihan-operator-desa-cibenda',
            'activity_date' => '2026-03-10',
            'project_id' => $project->id,
            'cover_image' => $cover,
            'summary' => 'Pelatihan langsung penggunaan aplikasi bagi perangkat desa.',
            'content' => "Hari pertama pelatihan berjalan lancar.\nPerangkat desa antusias mencoba fitur pelaporan.",
            'is_published' => '1',
        ]);

        $storeResp->assertRedirect(route('apanel.field-posts.index'));

        $post = FieldPost::where('slug', 'pelatihan-operator-desa-cibenda')->first();
        $this->assertNotNull($post);
        $this->assertTrue($post->is_published);
        $this->assertEquals($project->id, $post->project_id);
        $oldCoverRelative = str_replace('/storage/', '', $post->cover_image);
        Storage::disk('public')->assertExists($oldCoverRelative);

        // 3. Public detail & index render
        $this->get(route('field-posts.index'))
            ->assertStatus(200)
            ->assertSee('Pelatihan Operator Desa Cibenda');

        $this->get(route('field-posts.show', $post->slug))
            ->assertStatus(200)
            ->assertSee('Pelatihan Operator Desa Cibenda')
            ->assertSee('SIGAP Desa Cibenda')
            ->assertSee('Perangkat desa antusias mencoba fitur pelaporan.');

        // 4. Update post with new cover
        $newCover = UploadedFile::fake()->image('kegiatan-v2.png', 1200, 675);
        $updateResp = $this->actingAs($this->admin)->put(route('apanel.field-posts.update', $post), [
            'title' => 'Pelatihan Operator Desa Cibenda Batch 2',
            'slug' => 'pelatihan-operator-desa-cibenda',
            'activity_date' => '2026-03-15',
            'project_id' => $project->id,
            'cover_image' => $newCover,
            'summary' => 'Ringkasan batch 2.',
            'content' => 'Konten batch 2 diperbarui.',
            'is_published' => '1',
        ]);

        $updateResp->assertRedirect(route('apanel.field-posts.index'));
        $post->refresh();
        $this->assertEquals('Pelatihan Operator Desa Cibenda Batch 2', $post->title);
        Storage::disk('public')->assertMissing($oldCoverRelative);

        // 5. Toggle Publish -> Draft hides from public
        $this->actingAs($this->admin)
            ->patch(route('apanel.field-posts.toggle-publish', $post))
            ->assertRedirect(route('apanel.field-posts.index'));

        $this->assertFalse($post->fresh()->is_published);
        $this->get(route('field-posts.show', $post->slug))->assertStatus(404);
        $this->get(route('field-posts.index'))->assertDontSee('Pelatihan Operator Desa Cibenda Batch 2');

        // 6. Delete cleans up DB and image file
        $currentCoverRelative = str_replace('/storage/', '', $post->cover_image);
        $this->actingAs($this->admin)
            ->delete(route('apanel.field-posts.destroy', $post))
            ->assertRedirect(route('apanel.field-posts.index'));

        $this->assertDatabaseMissing('field_posts', ['id' => $post->id]);
        Storage::disk('public')->assertMissing($currentCoverRelative);
    }

    public function test_public_field_posts_archive_supports_search_and_project_filter(): void
    {
        $p1 = Project::create([
            'title' => 'Program Alpha',
            'slug' => 'program-alpha',
            'year' => 2026,
            'summary' => 'Alpha summary',
            'partner_name' => 'Desa A',
            'category' => 'Tech',
            'is_published' => true,
        ]);

        $p2 = Project::create([
            'title' => 'Program Beta',
            'slug' => 'program-beta',
            'year' => 2026,
            'summary' => 'Beta summary',
            'partner_name' => 'Desa B',
            'category' => 'Tech',
            'is_published' => true,
        ]);

        FieldPost::create([
            'project_id' => $p1->id,
            'title' => 'Kegiatan Alpha Pertama',
            'slug' => 'kegiatan-alpha-pertama',
            'activity_date' => '2026-04-01',
            'summary' => 'Ringkasan alpha.',
            'content' => 'Konten alpha.',
            'is_published' => true,
        ]);

        FieldPost::create([
            'project_id' => $p2->id,
            'title' => 'Kegiatan Beta Kedua',
            'slug' => 'kegiatan-beta-kedua',
            'activity_date' => '2026-04-02',
            'summary' => 'Ringkasan beta.',
            'content' => 'Konten beta.',
            'is_published' => true,
        ]);

        $this->get(route('field-posts.index', ['proyek' => 'program-alpha']))
            ->assertStatus(200)
            ->assertSee('Kegiatan Alpha Pertama')
            ->assertDontSee('Kegiatan Beta Kedua');

        $this->get(route('field-posts.index', ['q' => 'Beta']))
            ->assertStatus(200)
            ->assertSee('Kegiatan Beta Kedua')
            ->assertDontSee('Kegiatan Alpha Pertama');
    }

    public function test_slug_typed_with_spaces_becomes_hyphenated(): void
    {
        $this->actingAs($this->admin)->post(route('apanel.field-posts.store'), [
            'title' => 'Survei Cibenda',
            'slug' => '/catatan/Survei Cibenda',
            'activity_date' => '2026-04-01',
            'content' => 'Isi catatan',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('field_posts', ['slug' => 'survei-cibenda']);
    }
}
