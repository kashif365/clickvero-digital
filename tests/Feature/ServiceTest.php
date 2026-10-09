<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    private function makeService(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'name' => 'SEO Services',
            'slug' => 'seo-services',
            'short_description' => 'Rank higher and earn qualified organic traffic.',
            'description' => '<h2>Why SEO Matters</h2><p>Search engine optimization is the foundation of growth.</p>',
            'status' => true,
        ], $overrides));
    }

    public function test_guest_cannot_manage_services(): void
    {
        $this->get(route('admin.services.index'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.services.store'), [])->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_a_service(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.services.store'), [
            'name' => 'Web Development',
            'short_description' => 'Fast, conversion-focused websites.',
            'description' => '<h2>Benefits</h2><p>We build fast sites.</p>',
            'status' => 1,
            'faqs' => [
                ['question' => 'How long does it take?', 'answer' => '4 to 8 weeks depending on scope.'],
            ],
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['name' => 'Web Development', 'slug' => 'web-development']);

        $service = Service::first();
        $this->assertCount(1, $service->faqList());
    }

    public function test_slug_is_auto_generated_from_name_when_not_provided(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.services.store'), [
            'name' => 'Pay-Per-Click (PPC) Advertising',
            'description' => '<p>x</p>',
        ]);

        $this->assertDatabaseHas('services', ['slug' => 'pay-per-click-ppc-advertising']);
    }

    public function test_duplicate_slugs_are_disambiguated_automatically(): void
    {
        $admin = User::factory()->create();
        $this->makeService(['name' => 'SEO Services', 'slug' => 'seo-services']);

        $this->actingAs($admin)->post(route('admin.services.store'), [
            'name' => 'SEO Services',
            'description' => '<p>x</p>',
        ]);

        $this->assertDatabaseHas('services', ['slug' => 'seo-services-2']);
    }

    public function test_malicious_html_in_description_is_sanitized(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.services.store'), [
            'name' => 'Malicious Test',
            'description' => '<p>Safe</p><script>alert(1)</script><img src=x onerror="alert(1)">',
        ]);

        $service = Service::first();
        $this->assertStringNotContainsString('<script', $service->description);
        $this->assertStringNotContainsString('onerror', $service->description);
        $this->assertStringContainsString('<p>Safe</p>', $service->description);
    }

    public function test_admin_can_update_and_delete_a_service(): void
    {
        $admin = User::factory()->create();
        $service = $this->makeService();

        $this->actingAs($admin)->put(route('admin.services.update', $service), [
            'name' => 'SEO Services',
            'slug' => 'seo-services',
            'description' => '<p>Updated</p>',
            'status' => 1,
        ]);
        $this->assertStringContainsString('Updated', $service->fresh()->description);

        $this->actingAs($admin)->delete(route('admin.services.destroy', $service));
        $this->assertDatabaseCount('services', 0);
    }

    public function test_admin_can_upload_content_image(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.services.content-image'), [
            'upload' => UploadedFile::fake()->image('photo.jpg', 800, 600),
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['url']);
        $this->assertStringContainsString('/storage/services/content/', $response->json('url'));
    }

    public function test_content_image_upload_rejects_invalid_file_type(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.services.content-image'), [
            'upload' => UploadedFile::fake()->create('malicious.php', 10, 'application/x-php'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error' => ['message']]);
    }

    public function test_public_listing_shows_only_active_services(): void
    {
        $this->makeService(['name' => 'Active Service', 'slug' => 'active-service', 'status' => true]);
        $this->makeService(['name' => 'Inactive Service', 'slug' => 'inactive-service', 'status' => false]);

        $response = $this->get(route('service'));

        $response->assertOk();
        $response->assertSee('Active Service');
        $response->assertDontSee('Inactive Service');
    }

    public function test_public_service_page_renders(): void
    {
        $service = $this->makeService();

        $response = $this->get(route('service.show', $service));

        $response->assertOk();
        $response->assertSee('SEO Services');
        $response->assertSee('Why SEO Matters', false);
    }

    public function test_inactive_service_returns_404(): void
    {
        $service = $this->makeService(['status' => false]);

        $this->get(route('service.show', $service))->assertStatus(404);
    }

    public function test_old_service_details_url_redirects_to_service_listing(): void
    {
        $response = $this->get('/service-details');

        $response->assertRedirect('/service');
        $response->assertStatus(301);
    }

    public function test_service_page_renders_unique_seo_title_and_canonical(): void
    {
        $service = $this->makeService([
            'seo_title' => 'Custom SEO Title',
            'seo_description' => 'Custom SEO description text.',
        ]);

        $response = $this->get(route('service.show', $service));
        $html = $response->getContent();

        $this->assertStringContainsString('<title>Custom SEO Title', $html);
        $this->assertStringContainsString('Custom SEO description text.', $html);
        $this->assertSame(1, substr_count($html, '<title>'));
        $this->assertStringContainsString('rel="canonical"', $html);
    }

    public function test_service_page_renders_service_schema_automatically(): void
    {
        $service = $this->makeService();

        $response = $this->get(route('service.show', $service));
        $html = $response->getContent();

        $this->assertStringContainsString('application/ld+json', $html);
        $this->assertStringContainsString('"@type":"Service"', $html);
        $this->assertStringContainsString('"name":"SEO Services"', $html);
    }

    public function test_service_page_renders_faq_schema_when_faqs_present(): void
    {
        $service = $this->makeService([
            'faqs' => [
                ['question' => 'How long does SEO take?', 'answer' => 'Usually 3 to 6 months.'],
            ],
        ]);

        $response = $this->get(route('service.show', $service));
        $html = $response->getContent();

        $this->assertStringContainsString('"@type":"FAQPage"', $html);
        $this->assertStringContainsString('How long does SEO take?', $html);
        $response->assertSee('How long does SEO take?', false);
    }

    public function test_service_page_does_not_render_faq_schema_without_faqs(): void
    {
        $service = $this->makeService(['faqs' => []]);

        $response = $this->get(route('service.show', $service));

        $this->assertStringNotContainsString('FAQPage', $response->getContent());
    }

    public function test_homepage_service_carousel_links_to_dynamic_service_pages(): void
    {
        $service = $this->makeService();

        $response = $this->get('/');

        $response->assertSee('SEO Services');
        $response->assertSee(route('service.show', $service), false);
    }

    public function test_header_services_dropdown_links_to_dynamic_service_pages(): void
    {
        $service = $this->makeService();

        $response = $this->get('/about');

        $response->assertSee(route('service.show', $service), false);
    }
}
