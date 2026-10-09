<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\PageMeta;
use App\Models\User;
use App\Services\SitemapGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SitemapGenerationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guest_cannot_generate_sitemap(): void
    {
        $this->post(route('admin.sitemap.generate'))->assertRedirect(route('admin.login'));
    }

    public function test_generated_sitemap_includes_static_pages_and_blog_posts(): void
    {
        $admin = User::factory()->create();
        Blog::create(['title' => 'Post', 'slug' => 'post', 'content' => '<p>x</p>', 'published_at' => now()]);

        $this->actingAs($admin)->post(route('admin.sitemap.generate'))
            ->assertRedirect(route('admin.sitemap.index'));

        $xml = Storage::disk('public')->get('sitemap.xml');

        $this->assertStringContainsString(route('home'), $xml);
        $this->assertStringContainsString(route('blog-details', ['blog' => 'post']), $xml);
    }

    public function test_noindex_page_is_excluded_from_sitemap(): void
    {
        PageMeta::create(['route' => 'faq', 'title' => 'FAQ', 'robots_index' => false]);

        (new SitemapGenerator())->regenerate();
        $xml = Storage::disk('public')->get('sitemap.xml');

        $this->assertStringNotContainsString(route('faq'), $xml);
    }

    public function test_inactive_page_seo_excludes_page_from_sitemap(): void
    {
        PageMeta::create(['route' => 'pricing', 'title' => 'Pricing', 'is_active' => false]);

        (new SitemapGenerator())->regenerate();
        $xml = Storage::disk('public')->get('sitemap.xml');

        $this->assertStringNotContainsString(route('pricing'), $xml);
    }

    public function test_noindex_blog_post_is_excluded_from_sitemap(): void
    {
        $blog = Blog::create(['title' => 'Hidden Post', 'slug' => 'hidden-post', 'content' => '<p>x</p>', 'published_at' => now()]);
        PageMeta::create(['seoable_type' => Blog::class, 'seoable_id' => $blog->id, 'title' => 'Hidden', 'robots_index' => false]);

        $visibleBlog = Blog::create(['title' => 'Visible Post', 'slug' => 'visible-post', 'content' => '<p>x</p>', 'published_at' => now()]);

        (new SitemapGenerator())->regenerate();
        $xml = Storage::disk('public')->get('sitemap.xml');

        $this->assertStringNotContainsString(route('blog-details', $blog), $xml);
        $this->assertStringContainsString(route('blog-details', $visibleBlog), $xml);
    }

    public function test_sitemap_regenerates_automatically_when_a_blog_is_saved(): void
    {
        $this->assertFalse(Storage::disk('public')->exists('sitemap.xml'));

        Blog::create(['title' => 'Auto Post', 'slug' => 'auto-post', 'content' => '<p>x</p>', 'published_at' => now()]);

        $this->assertTrue(Storage::disk('public')->exists('sitemap.xml'));
        $this->assertStringContainsString('auto-post', Storage::disk('public')->get('sitemap.xml'));
    }

    public function test_sitemap_route_serves_generated_file(): void
    {
        (new SitemapGenerator())->regenerate();

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
    }
}
