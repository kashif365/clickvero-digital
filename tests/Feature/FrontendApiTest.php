<?php

namespace Tests\Feature;

use App\Models\AdditionalContent;
use App\Models\Blog;
use App\Models\PageMeta;
use App\Models\Quote;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FrontendApiTest extends TestCase
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
            'description' => '<h2>Why SEO Matters</h2><p>It is the foundation of growth.</p>',
            'faqs' => [['question' => 'How long does SEO take?', 'answer' => 'Usually a few months.']],
            'status' => true,
        ], $overrides));
    }

    private function makeBlog(array $overrides = []): Blog
    {
        static $count = 0;
        $count++;

        return Blog::create(array_merge([
            'title' => "Post {$count}",
            'slug' => "post-{$count}",
            'category' => 'SEO',
            'excerpt' => 'A short excerpt.',
            'content' => '<p>Body</p>',
            'published_at' => now()->subDays($count),
        ], $overrides));
    }

    public function test_site_endpoint_returns_branding_and_active_services_only(): void
    {
        SiteSetting::current()->update(['site_name' => 'Clickvora Digital', 'contact_email' => 'hello@example.com']);
        $this->makeService();
        $this->makeService(['name' => 'Hidden', 'slug' => 'hidden', 'status' => false]);

        $this->getJson('/api/v1/site')
            ->assertOk()
            ->assertJsonPath('data.name', 'Clickvora Digital')
            ->assertJsonPath('data.email', 'hello@example.com')
            ->assertJsonCount(1, 'data.services')
            ->assertJsonPath('data.services.0.slug', 'seo-services');
    }

    public function test_services_index_lists_active_services_without_rich_text(): void
    {
        $this->makeService(['sort_order' => 2]);
        $this->makeService(['name' => 'Branding', 'slug' => 'branding', 'sort_order' => 1]);
        $this->makeService(['name' => 'Hidden', 'slug' => 'hidden', 'status' => false]);

        $response = $this->getJson('/api/v1/services')->assertOk()->assertJsonCount(2, 'data');

        $this->assertSame(['branding', 'seo-services'], array_column($response->json('data'), 'slug'));
        $this->assertArrayNotHasKey('description', $response->json('data.0'));
    }

    public function test_service_show_returns_description_and_faqs(): void
    {
        $this->makeService();

        $this->getJson('/api/v1/services/seo-services')
            ->assertOk()
            ->assertJsonPath('data.name', 'SEO Services')
            ->assertJsonPath('data.faqs.0.question', 'How long does SEO take?')
            ->assertJsonFragment(['description' => '<h2>Why SEO Matters</h2><p>It is the foundation of growth.</p>']);
    }

    public function test_inactive_or_missing_service_returns_json_404(): void
    {
        $this->makeService(['status' => false]);

        $this->getJson('/api/v1/services/seo-services')->assertNotFound();
        $this->getJson('/api/v1/services/does-not-exist')->assertNotFound()->assertJsonStructure(['message']);
    }

    public function test_blogs_index_is_paginated_newest_first(): void
    {
        foreach (range(1, 5) as $i) {
            $this->makeBlog();
        }

        $response = $this->getJson('/api/v1/blogs?per_page=2')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('meta.total', 5)
            ->assertJsonPath('meta.last_page', 3)
            ->assertJsonPath('categories', ['SEO']);

        $dates = array_column($response->json('data'), 'published_at');
        $this->assertGreaterThan($dates[1], $dates[0]);
        $this->assertArrayNotHasKey('content', $response->json('data.0'));

        $this->getJson('/api/v1/blogs?per_page=2&page=3')->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_blogs_index_filters_by_search_and_category(): void
    {
        $this->makeBlog(['title' => 'Local SEO checklist', 'category' => 'SEO']);
        $this->makeBlog(['title' => 'Email flows that convert', 'category' => 'Email']);

        $this->getJson('/api/v1/blogs?search=checklist')->assertOk()->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Local SEO checklist');

        $this->getJson('/api/v1/blogs?category=Email')->assertOk()->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Email flows that convert');

        $this->getJson('/api/v1/blogs?search=nothing-matches')->assertOk()->assertJsonCount(0, 'data');
    }

    public function test_blogs_index_rejects_invalid_per_page(): void
    {
        $this->getJson('/api/v1/blogs?per_page=500')->assertUnprocessable()->assertJsonValidationErrors('per_page');
    }

    public function test_blog_show_returns_content_and_related_posts(): void
    {
        $this->makeBlog(['title' => 'Main Post', 'slug' => 'main-post', 'content' => '<p>Full body</p>']);
        $this->makeBlog();
        $this->makeBlog();

        $response = $this->getJson('/api/v1/blogs/main-post')
            ->assertOk()
            ->assertJsonPath('data.title', 'Main Post')
            ->assertJsonPath('data.content', '<p>Full body</p>')
            ->assertJsonCount(2, 'related');

        $this->assertNotContains('main-post', array_column($response->json('related'), 'slug'));

        $this->getJson('/api/v1/blogs/missing')->assertNotFound();
    }

    public function test_quote_can_be_submitted_through_the_api(): void
    {
        $this->postJson('/api/v1/quotes', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'SEO Services',
            'message' => 'We need help with organic growth.',
        ])->assertCreated()->assertJsonStructure(['message', 'data' => ['id']]);

        $this->assertDatabaseHas('quotes', ['email' => 'jane@example.com', 'subject' => 'SEO Services']);
    }

    public function test_quote_submission_is_validated_server_side(): void
    {
        $this->postJson('/api/v1/quotes', ['name' => '', 'email' => 'not-an-email', 'message' => ''])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'message']);

        $this->assertSame(0, Quote::count());
    }

    public function test_quote_submissions_are_rate_limited(): void
    {
        $payload = ['name' => 'Jane', 'email' => 'jane@example.com', 'message' => 'Hello'];

        foreach (range(1, 6) as $i) {
            $this->postJson('/api/v1/quotes', $payload)->assertCreated();
        }

        $this->postJson('/api/v1/quotes', $payload)->assertTooManyRequests();
    }

    public function test_page_endpoint_returns_route_seo_and_additional_content(): void
    {
        PageMeta::create(['route' => 'about', 'title' => 'Custom About Title', 'description' => 'About description.', 'robots_index' => false]);
        AdditionalContent::create(['page_url' => '/about', 'title' => 'Bonus', 'content' => '<p>Extra about content.</p>', 'status' => true]);

        $this->getJson('/api/v1/page?path=/about')
            ->assertOk()
            ->assertJsonPath('data.seo.title', 'Custom About Title')
            ->assertJsonPath('data.seo.description', 'About description.')
            ->assertJsonPath('data.seo.robots', 'noindex,follow')
            ->assertJsonPath('data.seo.canonical', 'http://localhost/about')
            ->assertJsonPath('data.additional_content.title', 'Bonus');

        $this->getJson('/api/v1/page?path=/faq')->assertOk()->assertJsonPath('data.additional_content', null);
    }

    public function test_page_endpoint_resolves_model_seo_for_detail_pages(): void
    {
        $this->makeService(['seo_title' => 'Expert SEO Help']);
        $this->makeBlog(['title' => 'Model Titled Post', 'slug' => 'model-titled-post', 'excerpt' => 'Post excerpt.']);

        $this->getJson('/api/v1/page?path=/services/seo-services')->assertOk()->assertJsonPath('data.seo.title', 'Expert SEO Help');

        $this->getJson('/api/v1/page?path=/blog-details/model-titled-post')
            ->assertOk()
            ->assertJsonPath('data.seo.title', 'Model Titled Post')
            ->assertJsonPath('data.seo.description', 'Post excerpt.');
    }

    public function test_page_endpoint_requires_a_valid_path(): void
    {
        $this->getJson('/api/v1/page')->assertUnprocessable()->assertJsonValidationErrors('path');
        $this->getJson('/api/v1/page?path=https://evil.test')->assertUnprocessable();
        $this->getJson('/api/v1/page?path=/no-such-page')
            ->assertOk()
            ->assertJsonPath('data.seo.title', 'Page Not Found')
            ->assertJsonPath('data.seo.robots', 'noindex,follow');
        $this->getJson('/api/v1/page?path=/blog-details/missing')->assertOk()->assertJsonPath('data.seo.title', 'Page Not Found');
    }

    public function test_public_pages_render_the_react_shell_with_site_data(): void
    {
        $this->makeService();

        foreach (['/', '/about', '/service', '/blog', '/contact', '/faq', '/pricing', '/project', '/team'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('<div id="root"></div>', false)
                ->assertSee('window.__APP__', false)
                ->assertSee('seo-services', false);
        }
    }

    public function test_unknown_urls_render_the_shell_with_a_404_status(): void
    {
        $this->get('/this-page-does-not-exist')->assertNotFound()->assertSee('<div id="root"></div>', false);
        $this->get('/blog-details/missing-post')->assertNotFound()->assertSee('<div id="root"></div>', false);
    }

    public function test_embedded_site_data_cannot_break_out_of_the_script_tag(): void
    {
        $this->makeService(['name' => '</script><script>alert(1)</script>', 'slug' => 'xss']);

        $this->get('/')->assertOk()->assertDontSee('</script><script>alert(1)', false);
    }

    public function test_admin_panel_still_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get(route('admin.login'))->assertOk();
    }
}
