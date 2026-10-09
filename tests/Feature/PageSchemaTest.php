<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\PageSchema;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PageSchemaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guest_cannot_manage_schemas(): void
    {
        $this->get(route('admin.page-schemas.index'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_a_global_schema(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.page-schemas.store'), [
            'name' => 'Sitewide Organization',
            'schema_type' => 'Organization',
            'scope' => 'global',
            'schema_json' => json_encode(['name' => 'Velora Digital', 'url' => 'https://example.com']),
        ]);

        $response->assertRedirect(route('admin.page-schemas.index'));
        $this->assertDatabaseHas('page_schemas', ['name' => 'Sitewide Organization', 'scope' => 'global']);
    }

    public function test_admin_can_create_a_route_scoped_schema(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.page-schemas.store'), [
            'name' => 'Home WebSite schema',
            'schema_type' => 'WebSite',
            'scope' => 'route',
            'route_name' => 'home',
            'schema_json' => json_encode(['name' => 'Velora Digital', 'url' => 'https://example.com']),
        ]);

        $response->assertRedirect(route('admin.page-schemas.index'));
        $this->assertDatabaseHas('page_schemas', ['scope' => 'route', 'route_name' => 'home']);
    }

    public function test_admin_can_create_a_blog_scoped_schema(): void
    {
        $admin = User::factory()->create();
        $blog = Blog::create([
            'title' => 'Post', 'slug' => 'post', 'content' => '<p>x</p>', 'published_at' => now(),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.page-schemas.store'), [
            'name' => 'Post BlogPosting schema',
            'schema_type' => 'BlogPosting',
            'scope' => 'model',
            'blog_id' => $blog->id,
            'schema_json' => json_encode(['headline' => 'Post', 'author' => ['@type' => 'Person', 'name' => 'A']]),
        ]);

        $response->assertRedirect(route('admin.page-schemas.index'));
        $this->assertDatabaseHas('page_schemas', ['scope' => 'model', 'seoable_type' => Blog::class, 'seoable_id' => $blog->id]);
    }

    public function test_invalid_json_is_rejected(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.page-schemas.store'), [
            'name' => 'Broken schema',
            'schema_type' => 'Organization',
            'scope' => 'global',
            'schema_json' => '{not valid json',
        ]);

        $response->assertSessionHasErrors('schema_json');
        $this->assertDatabaseCount('page_schemas', 0);
    }

    public function test_schema_missing_required_properties_is_rejected(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.page-schemas.store'), [
            'name' => 'Incomplete Organization',
            'schema_type' => 'Organization',
            'scope' => 'global',
            'schema_json' => json_encode(['url' => 'https://example.com']), // missing "name"
        ]);

        $response->assertSessionHasErrors('schema_json');
        $this->assertDatabaseCount('page_schemas', 0);
    }

    public function test_schema_json_containing_script_tag_is_rejected(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.page-schemas.store'), [
            'name' => 'Malicious schema',
            'schema_type' => 'Organization',
            'scope' => 'global',
            'schema_json' => '{"name": "<script>alert(1)</script>"}',
        ]);

        $response->assertSessionHasErrors('schema_json');
        $this->assertDatabaseCount('page_schemas', 0);
    }

    public function test_active_schema_renders_as_json_ld_on_public_page(): void
    {
        PageSchema::create([
            'name' => 'Home WebSite',
            'schema_type' => 'WebSite',
            'scope' => 'route',
            'route_name' => 'home',
            'schema_json' => ['name' => 'Velora Digital', 'url' => 'https://example.com'],
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertSee('application/ld+json', false);
        $response->assertSee('"@type":"WebSite"', false);
        $response->assertSee('"@context":"https://schema.org"', false);
    }

    public function test_inactive_schema_is_excluded_from_rendering(): void
    {
        PageSchema::create([
            'name' => 'Inactive schema',
            'schema_type' => 'WebSite',
            'scope' => 'route',
            'route_name' => 'home',
            'schema_json' => ['name' => 'Should not render', 'url' => 'https://example.com'],
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertDontSee('Should not render', false);
    }

    public function test_multiple_schemas_render_on_the_same_page(): void
    {
        PageSchema::create([
            'name' => 'Global org', 'schema_type' => 'Organization', 'scope' => 'global',
            'schema_json' => ['name' => 'Velora Digital'], 'priority' => 1,
        ]);
        PageSchema::create([
            'name' => 'Home website', 'schema_type' => 'WebSite', 'scope' => 'route', 'route_name' => 'home',
            'schema_json' => ['name' => 'Velora Digital', 'url' => 'https://example.com'], 'priority' => 2,
        ]);

        $response = $this->get('/');
        $html = $response->getContent();

        $this->assertSame(2, substr_count($html, 'application/ld+json'));
    }

    public function test_schema_scoped_to_a_different_route_does_not_leak_globally(): void
    {
        PageSchema::create([
            'name' => 'FAQ only schema', 'schema_type' => 'FAQPage', 'scope' => 'route', 'route_name' => 'faq',
            'schema_json' => ['mainEntity' => []],
        ]);

        $home = $this->get('/');
        $home->assertDontSee('FAQPage', false);

        $faq = $this->get('/faq');
        $faq->assertSee('"@type":"FAQPage"', false);
    }

    public function test_blog_scoped_schema_only_appears_on_its_own_post(): void
    {
        $blogA = Blog::create(['title' => 'Post A', 'slug' => 'post-a', 'content' => '<p>a</p>', 'published_at' => now()]);
        $blogB = Blog::create(['title' => 'Post B', 'slug' => 'post-b', 'content' => '<p>b</p>', 'published_at' => now()]);

        PageSchema::create([
            'name' => 'Post A schema', 'schema_type' => 'BlogPosting', 'scope' => 'model',
            'seoable_type' => Blog::class, 'seoable_id' => $blogA->id,
            'schema_json' => ['headline' => 'Post A'],
        ]);

        $this->get(route('blog-details', $blogA))->assertSee('"@type":"BlogPosting"', false);
        $this->get(route('blog-details', $blogB))->assertDontSee('BlogPosting', false);
    }

    public function test_toggle_and_duplicate_actions(): void
    {
        $admin = User::factory()->create();
        $schema = PageSchema::create([
            'name' => 'Toggle me', 'schema_type' => 'Organization', 'scope' => 'global',
            'schema_json' => ['name' => 'X'],
        ]);

        $this->actingAs($admin)->patch(route('admin.page-schemas.toggle', $schema));
        $this->assertFalse($schema->fresh()->is_active);

        $this->actingAs($admin)->post(route('admin.page-schemas.duplicate', $schema));
        $this->assertDatabaseCount('page_schemas', 2);
        $this->assertDatabaseHas('page_schemas', ['name' => 'Toggle me (copy)', 'is_active' => false]);
    }

    public function test_cache_invalidates_when_schema_changes(): void
    {
        $schema = PageSchema::create([
            'name' => 'Cache test', 'schema_type' => 'Organization', 'scope' => 'global',
            'schema_json' => ['name' => 'X'],
        ]);

        $this->assertCount(1, PageSchema::applicableTo('home', null));

        $schema->update(['is_active' => false]);

        $this->assertCount(0, PageSchema::applicableTo('home', null));
    }
}
