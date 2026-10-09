<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\PageMeta;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PageSeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    private function makeBlog(array $overrides = []): Blog
    {
        return Blog::create(array_merge([
            'title' => 'A Great Blog Post',
            'slug' => 'a-great-blog-post',
            'excerpt' => 'A short excerpt about the post.',
            'content' => '<p>Body</p>',
            'published_at' => now(),
        ], $overrides));
    }

    public function test_guest_cannot_manage_page_seo(): void
    {
        $this->get(route('admin.page-metas.index'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_seo_record_for_static_page(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.page-metas.store'), [
            'target_type' => 'route',
            'route' => 'faq',
            'title' => 'FAQ | Custom Title',
            'description' => 'Custom FAQ description.',
        ]);

        $response->assertRedirect(route('admin.page-metas.index'));
        $this->assertDatabaseHas('page_metas', ['route' => 'faq', 'title' => 'FAQ | Custom Title']);
    }

    public function test_admin_can_create_seo_record_for_a_blog_post(): void
    {
        $admin = User::factory()->create();
        $blog = $this->makeBlog();

        $response = $this->actingAs($admin)->post(route('admin.page-metas.store'), [
            'target_type' => 'blog',
            'blog_id' => $blog->id,
            'title' => 'Custom Blog SEO Title',
            'description' => 'Custom blog SEO description.',
            'keywords' => 'seo, marketing',
            'focus_keyword' => 'marketing',
        ]);

        $response->assertRedirect(route('admin.page-metas.index'));
        $this->assertDatabaseHas('page_metas', [
            'seoable_type' => Blog::class,
            'seoable_id' => $blog->id,
            'title' => 'Custom Blog SEO Title',
        ]);

        $record = PageMeta::where('seoable_id', $blog->id)->first();
        $this->assertSame(['seo', 'marketing'], $record->keywords);
    }

    public function test_duplicate_seo_record_for_same_static_route_is_rejected(): void
    {
        $admin = User::factory()->create();
        PageMeta::create(['route' => 'faq', 'title' => 'Existing']);

        $response = $this->actingAs($admin)->post(route('admin.page-metas.store'), [
            'target_type' => 'route',
            'route' => 'faq',
            'title' => 'Duplicate attempt',
        ]);

        $response->assertSessionHasErrors('route');
        $this->assertDatabaseCount('page_metas', 1);
    }

    public function test_duplicate_seo_record_for_same_blog_is_rejected(): void
    {
        $admin = User::factory()->create();
        $blog = $this->makeBlog();
        PageMeta::create(['seoable_type' => Blog::class, 'seoable_id' => $blog->id, 'title' => 'Existing']);

        $response = $this->actingAs($admin)->post(route('admin.page-metas.store'), [
            'target_type' => 'blog',
            'blog_id' => $blog->id,
            'title' => 'Duplicate attempt',
        ]);

        $response->assertSessionHasErrors('blog_id');
        $this->assertDatabaseCount('page_metas', 1);
    }

    public function test_home_page_renders_seo_record_title_and_description(): void
    {
        PageMeta::create([
            'route' => 'home',
            'title' => 'Custom Home Title',
            'description' => 'Custom home description.',
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('<title>Custom Home Title</title>', false);
        $response->assertSee('Custom home description.', false);
    }

    public function test_blog_post_renders_its_own_seo_record_not_the_shared_route_record(): void
    {
        // The pre-fix bug: a shared "blog-details" route record used to override every post's own title.
        PageMeta::create(['route' => 'blog-details', 'title' => 'Generic Blog Details Title']);
        $blog = $this->makeBlog(['title' => 'My Unique Post Title']);
        PageMeta::create([
            'seoable_type' => Blog::class,
            'seoable_id' => $blog->id,
            'title' => 'My Unique Post Title | Custom SEO',
            'description' => 'Unique post description.',
        ]);

        $response = $this->get(route('blog-details', $blog));

        $response->assertOk();
        $response->assertSee('My Unique Post Title | Custom SEO', false);
        $response->assertDontSee('Generic Blog Details Title', false);
    }

    public function test_blog_post_without_seo_record_falls_back_to_model_title_and_excerpt(): void
    {
        $blog = $this->makeBlog(['title' => 'Fallback Title Post', 'excerpt' => 'Fallback excerpt text.']);

        $response = $this->get(route('blog-details', $blog));

        $response->assertOk();
        $response->assertSee('Fallback Title Post', false);
        $response->assertSee('Fallback excerpt text.', false);
    }

    public function test_site_default_title_used_when_no_page_or_model_seo_exists(): void
    {
        $settings = SiteSetting::current();
        $settings->update(['default_title' => 'Site Default Title', 'default_description' => 'Site default description.']);

        // "faq" has a seeded PageMeta already from PageMetaSeeder in normal runs, but this test DB is fresh/unseeded.
        $response = $this->get('/faq');

        $response->assertOk();
        $response->assertSee('Site Default Title', false);
    }

    public function test_title_suffix_is_appended(): void
    {
        SiteSetting::current()->update(['title_suffix' => '| MySite']);
        PageMeta::create(['route' => 'home', 'title' => 'Home Page']);

        $response = $this->get('/');

        $response->assertSee('<title>Home Page | MySite</title>', false);
    }

    public function test_noindex_renders_correct_robots_meta_tag(): void
    {
        PageMeta::create(['route' => 'contact', 'title' => 'Contact', 'robots_index' => false, 'robots_follow' => true]);

        $response = $this->get('/contact');

        $response->assertSee('<meta name="robots" content="noindex,follow">', false);
    }

    public function test_default_robots_meta_tag_is_index_follow(): void
    {
        PageMeta::create(['route' => 'about', 'title' => 'About']);

        $response = $this->get('/about');

        $response->assertSee('<meta name="robots" content="index,follow">', false);
    }

    public function test_canonical_relative_url_is_resolved_to_absolute(): void
    {
        PageMeta::create(['route' => 'home', 'title' => 'Home', 'canonical_url' => '/canonical-target']);

        $response = $this->get('/');

        $response->assertSee('rel="canonical" href="'.config('app.url').'/canonical-target"', false);
    }

    public function test_open_graph_and_twitter_tags_render_with_fallback_chain(): void
    {
        PageMeta::create([
            'route' => 'home',
            'title' => 'OG Test Title',
            'description' => 'OG test description.',
        ]);

        $response = $this->get('/');

        $response->assertSee('property="og:title" content="OG Test Title"', false);
        $response->assertSee('property="og:description" content="OG test description."', false);
        $response->assertSee('name="twitter:title" content="OG Test Title"', false);
    }

    public function test_page_only_renders_a_single_title_and_canonical_tag(): void
    {
        PageMeta::create(['route' => 'home', 'title' => 'Only One Title']);

        $response = $this->get('/');
        $html = $response->getContent();

        $this->assertSame(1, substr_count($html, '<title>'));
        $this->assertSame(1, substr_count($html, 'rel="canonical"'));
        $this->assertSame(1, substr_count($html, 'name="robots"'));
    }

    public function test_admin_can_delete_seo_record(): void
    {
        $admin = User::factory()->create();
        $pageMeta = PageMeta::create(['route' => 'faq', 'title' => 'FAQ']);

        $this->actingAs($admin)->delete(route('admin.page-metas.destroy', $pageMeta));

        $this->assertDatabaseCount('page_metas', 0);
    }
}
