<?php

namespace Tests\Feature;

use App\Models\FieldPost;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    private function makeProject(string $title, string $slug, bool $published): Project
    {
        return Project::create([
            'title' => $title,
            'slug' => $slug,
            'year' => 2026,
            'summary' => "Ringkasan {$title}",
            'partner_name' => 'Desa Cibenda',
            'category' => 'sistem-desa',
            'is_published' => $published,
        ]);
    }

    public function test_draft_project_is_hidden_from_landing_and_detail_page(): void
    {
        $this->makeProject('Proyek Tayang', 'proyek-tayang', true);
        $this->makeProject('Proyek Rahasia Draft', 'proyek-draft', false);

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('Proyek Tayang')
            ->assertDontSee('Proyek Rahasia Draft');

        $this->get(route('projects.show', 'proyek-tayang'))->assertOk()->assertSee('Proyek Tayang');
        $this->get(route('projects.show', 'proyek-draft'))->assertNotFound();
    }

    public function test_project_page_renders_its_own_title_and_social_meta(): void
    {
        $project = $this->makeProject('Proyek Meta', 'proyek-meta', true);
        $project->update(['dashboard_thumbnail' => '/storage/projects/thumbnails/meta.jpg']);

        $this->get(route('projects.show', 'proyek-meta'))
            ->assertOk()
            ->assertSee('<title>Proyek Meta - Detail Proyek | Berdampak Utama</title>', false)
            ->assertSee('<meta name="description" content="Ringkasan Proyek Meta">', false)
            ->assertSee('<meta property="og:image" content="'.url('/storage/projects/thumbnails/meta.jpg').'">', false);
    }

    public function test_unknown_slugs_return_not_found(): void
    {
        $this->get(route('projects.show', 'tidak-ada'))->assertNotFound();
        $this->get(route('field-posts.show', 'tidak-ada'))->assertNotFound();
    }

    public function test_draft_field_posts_are_hidden_from_public_listings(): void
    {
        foreach ([['Catatan Tayang', true], ['Catatan Rahasia Draft', false]] as [$title, $published]) {
            FieldPost::create([
                'title' => $title,
                'slug' => str($title)->slug(),
                'activity_date' => '2026-04-01',
                'content' => "Isi {$title}",
                'is_published' => $published,
            ]);
        }

        $this->get(route('field-posts.index'))
            ->assertOk()
            ->assertSee('Catatan Tayang')
            ->assertDontSee('Catatan Rahasia Draft');

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('Catatan Tayang')
            ->assertDontSee('Catatan Rahasia Draft');
    }
}
