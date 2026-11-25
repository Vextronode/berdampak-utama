<?php

namespace Tests\Feature;

use App\Models\TechStack;
use App\Models\User;
use Database\Seeders\TechStackSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TechStackManagementTest extends TestCase
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

    public function test_guest_cannot_access_tech_stack_management_endpoints(): void
    {
        $response1 = $this->getJson(route('apanel.tech-stacks.search'));
        $response1->assertStatus(401);

        $response2 = $this->postJson(route('apanel.tech-stacks.store'), ['name' => 'Go']);
        $response2->assertStatus(401);
    }

    public function test_authenticated_admin_can_search_tech_stacks(): void
    {
        $response = $this->actingAs($this->admin)->getJson(route('apanel.tech-stacks.search', ['q' => 'laravel']));

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonFragment(['name' => 'Laravel']);
    }

    public function test_admin_can_create_new_tech_stack_with_cdn_url(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('apanel.tech-stacks.store'), [
            'name' => 'Tailwind CSS',
            'slug' => 'tailwindcss',
            'icon_type' => 'cdn_url',
            'brand_color' => '#06B6D4',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('tech_stack.name', 'Tailwind CSS');
    }

    public function test_admin_can_create_new_tech_stack_with_custom_svg_upload_and_it_is_sanitized(): void
    {
        Storage::fake('public');

        $maliciousSvgContent = '<svg viewBox="0 0 24 24"><script>alert("XSS")</script><circle cx="12" cy="12" r="10"/></svg>';
        $svgFile = UploadedFile::fake()->createWithContent('custom-icon.svg', $maliciousSvgContent);

        $response = $this->actingAs($this->admin)->postJson(route('apanel.tech-stacks.store'), [
            'name' => 'Custom Lib',
            'slug' => 'custom-lib',
            'icon_type' => 'custom_upload',
            'brand_color' => '#1E1B64',
            'custom_icon' => $svgFile,
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('tech_stack.name', 'Custom Lib');

        $created = TechStack::where('slug', 'custom-lib')->first();
        $this->assertNotNull($created);
        $this->assertStringNotContainsString('<script>', $created->icon_value);
        $this->assertStringContainsString('<circle', $created->icon_value);
    }

    public function test_svg_upload_strips_event_handlers_and_javascript_links(): void
    {
        Storage::fake('public');

        $payload = '<svg viewBox="0 0 24 24" onload="alert(1)"><a href="javascript:alert(2)"><circle cx="12" cy="12" r="10"/></a>'
            .'<iframe srcdoc="x"></iframe></svg>';
        $svgFile = UploadedFile::fake()->createWithContent('evil.svg', $payload);

        $response = $this->actingAs($this->admin)->postJson(route('apanel.tech-stacks.store'), [
            'name' => 'Evil Lib',
            'custom_icon' => $svgFile,
        ]);

        $response->assertStatus(201);

        $iconValue = TechStack::where('slug', 'evil-lib')->value('icon_value');
        $this->assertStringContainsString('<circle', $iconValue);
        $this->assertStringNotContainsStringIgnoringCase('onload', $iconValue);
        $this->assertStringNotContainsStringIgnoringCase('javascript:', $iconValue);
        $this->assertStringNotContainsStringIgnoringCase('<iframe', $iconValue);
        $this->assertStringNotContainsString('<?xml', $iconValue);
    }

    public function test_invalid_svg_upload_is_rejected(): void
    {
        Storage::fake('public');

        $svgFile = UploadedFile::fake()->createWithContent('broken.svg', '<svg onload=alert(1)>');

        $response = $this->actingAs($this->admin)->postJson(route('apanel.tech-stacks.store'), [
            'name' => 'Broken Lib',
            'custom_icon' => $svgFile,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('custom_icon');
        $this->assertDatabaseMissing('tech_stacks', ['slug' => 'broken-lib']);
    }

    public function test_invalid_brand_color_is_rejected_with_message(): void
    {
        foreach (['merah', 'red;x', '#12345', '#GGGGGG'] as $color) {
            $response = $this->actingAs($this->admin)->postJson(route('apanel.tech-stacks.store'), [
                'name' => 'Warna Salah',
                'brand_color' => $color,
            ]);

            $response->assertStatus(422);
            $response->assertJsonPath('message', 'Warna brand harus berformat heksadesimal, contoh #1E1B64.');
        }

        $this->assertDatabaseMissing('tech_stacks', ['slug' => 'warna-salah']);

        $this->actingAs($this->admin)->postJson(route('apanel.tech-stacks.store'), [
            'name' => 'Warna Benar',
            'brand_color' => '#ff2d20',
        ])->assertStatus(201);
    }

    public function test_admin_can_create_monogram_badge_fallback_tech_stack(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('apanel.tech-stacks.store'), [
            'name' => 'Redux Toolkit',
            'slug' => 'redux-toolkit',
            'icon_type' => 'monogram',
            'brand_color' => '#764ABC',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('tech_stack.monogram', 'RT');
    }
}
