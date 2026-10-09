<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Test Blog Post',
            'category' => 'Marketing',
            'author' => 'Jane Doe',
            'excerpt' => 'A short excerpt.',
            'content' => '<p>Hello <b>world</b></p>',
            'published_at' => now()->format('Y-m-d'),
        ], $overrides);
    }

    public function test_guest_cannot_create_blog(): void
    {
        $response = $this->post(route('admin.blogs.store'), $this->validPayload());

        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseCount('blogs', 0);
    }

    public function test_guest_cannot_upload_content_image(): void
    {
        $response = $this->post(route('admin.blogs.content-image'), [
            'upload' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_blog_with_rich_content(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.blogs.store'), $this->validPayload([
            'content' => '<h2>Heading</h2><p>Some <strong>bold</strong> text.</p><ul><li>One</li></ul><table><tr><td>Cell</td></tr></table>',
        ]));

        $response->assertRedirect(route('admin.blogs.index'));

        $blog = Blog::firstOrFail();
        $this->assertStringContainsString('<h2>Heading</h2>', $blog->content);
        $this->assertStringContainsString('<strong>bold</strong>', $blog->content);
        $this->assertStringContainsString('<table>', $blog->content);
    }

    public function test_malicious_html_is_sanitized_on_create(): void
    {
        $admin = User::factory()->create();

        $malicious = '<p>Safe</p><script>alert(1)</script><img src=x onerror="alert(1)"><a href="javascript:alert(1)">bad link</a><iframe src="https://evil.com"></iframe>';

        $this->actingAs($admin)->post(route('admin.blogs.store'), $this->validPayload([
            'content' => $malicious,
        ]));

        $blog = Blog::firstOrFail();
        $this->assertStringNotContainsString('<script', $blog->content);
        $this->assertStringNotContainsString('onerror', $blog->content);
        $this->assertStringNotContainsString('javascript:', $blog->content);
        $this->assertStringNotContainsString('<iframe', $blog->content);
        $this->assertStringContainsString('<p>Safe</p>', $blog->content);
    }

    public function test_external_links_get_safe_target_and_rel_while_internal_links_are_untouched(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.blogs.store'), $this->validPayload([
            'content' => '<p><a href="https://external-example.com/page">external</a> and <a href="/about">internal</a></p>',
        ]));

        $blog = Blog::firstOrFail();
        $this->assertStringContainsString('target="_blank"', $blog->content);
        $this->assertStringContainsString('rel="noopener noreferrer"', $blog->content);
        $this->assertMatchesRegularExpression('/<a href="\/about">internal<\/a>/', $blog->content);
    }

    public function test_admin_can_update_blog_content(): void
    {
        $admin = User::factory()->create();
        $blog = Blog::create($this->validPayload(['slug' => 'test-blog-post']));

        $response = $this->actingAs($admin)->put(route('admin.blogs.update', $blog), $this->validPayload([
            'content' => '<p>Updated content</p>',
        ]));

        $response->assertRedirect(route('admin.blogs.index'));
        $this->assertStringContainsString('Updated content', $blog->fresh()->content);
    }

    public function test_admin_can_upload_valid_content_image(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.blogs.content-image'), [
            'upload' => UploadedFile::fake()->image('photo.jpg', 800, 600),
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['url']);
        $this->assertStringContainsString('/storage/blogs/content/', $response->json('url'));
    }

    public function test_content_image_upload_rejects_invalid_file_type(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.blogs.content-image'), [
            'upload' => UploadedFile::fake()->create('malicious.php', 10, 'application/x-php'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error' => ['message']]);
    }

    public function test_content_image_upload_rejects_oversized_file(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.blogs.content-image'), [
            'upload' => UploadedFile::fake()->image('big.jpg')->size(6000),
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error' => ['message']]);
    }

    public function test_public_blog_details_page_renders_content_as_html(): void
    {
        $blog = Blog::create($this->validPayload([
            'slug' => 'test-blog-post',
            'content' => '<h2>Heading</h2><p>Body text</p>',
        ]));

        $response = $this->get(route('blog-details', $blog));

        $response->assertOk();
        $response->assertSee('<h2>Heading</h2>', false);
        $response->assertSee('blog-content', false);
    }

    public function test_empty_content_is_rejected_per_existing_business_rule(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.blogs.store'), $this->validPayload([
            'content' => '',
        ]));

        $response->assertSessionHasErrors('content');
        $this->assertDatabaseCount('blogs', 0);
    }
}
