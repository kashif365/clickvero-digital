<?php

namespace Tests\Feature;

use App\Models\AdditionalContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdditionalContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guest_cannot_manage_additional_content(): void
    {
        $this->get(route('admin.additional-contents.index'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.additional-contents.store'), [])->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_additional_content(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.additional-contents.store'), [
            'page_url' => '/services/auto-transport',
            'title' => 'Auto Transport Extras',
            'content' => '<p>Extra <strong>info</strong> for this page.</p>',
            'status' => 1,
        ]);

        $response->assertRedirect(route('admin.additional-contents.index'));
        $this->assertDatabaseHas('additional_contents', [
            'page_url' => '/services/auto-transport',
            'title' => 'Auto Transport Extras',
        ]);
    }

    public function test_page_url_is_normalized(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.additional-contents.store'), [
            'page_url' => 'services/auto-transport/',
            'content' => '<p>Content</p>',
        ]);

        $this->assertDatabaseHas('additional_contents', ['page_url' => '/services/auto-transport']);
    }

    public function test_malicious_html_is_sanitized(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.additional-contents.store'), [
            'page_url' => '/malicious-test',
            'content' => '<p>Safe</p><script>alert(1)</script><img src=x onerror="alert(1)">',
        ]);

        $record = AdditionalContent::first();
        $this->assertStringNotContainsString('<script', $record->content);
        $this->assertStringNotContainsString('onerror', $record->content);
        $this->assertStringContainsString('<p>Safe</p>', $record->content);
    }

    public function test_duplicate_page_url_is_rejected(): void
    {
        $admin = User::factory()->create();
        AdditionalContent::create(['page_url' => '/dup-page', 'content' => '<p>x</p>']);

        $response = $this->actingAs($admin)->post(route('admin.additional-contents.store'), [
            'page_url' => '/dup-page',
            'content' => '<p>y</p>',
        ]);

        $response->assertSessionHasErrors('page_url');
        $this->assertDatabaseCount('additional_contents', 1);
    }

    public function test_protected_system_path_is_rejected(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.additional-contents.store'), [
            'page_url' => '/admin/blogs',
            'content' => '<p>x</p>',
        ]);

        $response->assertSessionHasErrors('page_url');
        $this->assertDatabaseCount('additional_contents', 0);
    }

    public function test_admin_can_update_additional_content(): void
    {
        $admin = User::factory()->create();
        $content = AdditionalContent::create(['page_url' => '/update-me', 'content' => '<p>old</p>']);

        $this->actingAs($admin)->put(route('admin.additional-contents.update', $content), [
            'page_url' => '/update-me',
            'content' => '<p>new</p>',
            'status' => 1,
        ]);

        $this->assertStringContainsString('new', $content->fresh()->content);
    }

    public function test_admin_can_delete_additional_content(): void
    {
        $admin = User::factory()->create();
        $content = AdditionalContent::create(['page_url' => '/delete-me', 'content' => '<p>x</p>']);

        $this->actingAs($admin)->delete(route('admin.additional-contents.destroy', $content));

        $this->assertDatabaseCount('additional_contents', 0);
    }

    public function test_admin_can_upload_content_image(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.additional-contents.content-image'), [
            'upload' => \Illuminate\Http\UploadedFile::fake()->image('photo.jpg', 800, 600),
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['url']);
        $this->assertStringContainsString('/storage/additional-content/', $response->json('url'));
    }

    public function test_content_image_upload_rejects_invalid_file_type(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.additional-contents.content-image'), [
            'upload' => \Illuminate\Http\UploadedFile::fake()->create('malicious.php', 10, 'application/x-php'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['error' => ['message']]);
    }

    public function test_active_content_renders_on_matching_public_page(): void
    {
        AdditionalContent::create([
            'page_url' => '/about',
            'title' => 'Bonus About Info',
            'content' => '<p>Extra about content.</p>',
            'status' => true,
        ]);

        $response = $this->get('/about');

        $response->assertOk();
        $response->assertSee('Bonus About Info', false);
        $response->assertSee('Extra about content.', false);
        $response->assertSee('additional-content-scroll', false);
    }

    public function test_inactive_content_does_not_render(): void
    {
        AdditionalContent::create([
            'page_url' => '/faq',
            'content' => '<p>Should not appear.</p>',
            'status' => false,
        ]);

        $response = $this->get('/faq');

        $response->assertDontSee('Should not appear.', false);
        $response->assertDontSee('additional-content-scroll', false);
    }

    public function test_content_only_renders_on_its_own_page_not_others(): void
    {
        AdditionalContent::create([
            'page_url' => '/about',
            'content' => '<p>About-only content.</p>',
            'status' => true,
        ]);

        $this->get('/about')->assertSee('About-only content.', false);
        $this->get('/faq')->assertDontSee('About-only content.', false);
    }

    public function test_page_without_additional_content_renders_no_extra_section(): void
    {
        $response = $this->get('/pricing');

        $response->assertOk();
        $response->assertDontSee('additional-content-scroll', false);
    }
}
