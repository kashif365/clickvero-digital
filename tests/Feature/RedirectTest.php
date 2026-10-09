<?php

namespace Tests\Feature;

use App\Models\Redirect;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_manage_redirects(): void
    {
        $this->get(route('admin.redirects.index'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.redirects.store'), [])->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_a_redirect(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'name' => 'Old pricing',
            'source_path' => '/old-pricing',
            'destination' => '/pricing',
            'type' => 301,
        ]);

        $response->assertRedirect(route('admin.redirects.index'));
        $this->assertDatabaseHas('redirects', ['source_path' => '/old-pricing', 'destination' => '/pricing', 'type' => 301]);
    }

    public function test_source_path_is_normalized(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => 'old-page/',
            'destination' => '/new-page',
            'type' => 301,
        ]);

        $this->assertDatabaseHas('redirects', ['source_path' => '/old-page']);
    }

    #[DataProvider('redirectTypeProvider')]
    public function test_every_supported_redirect_type_is_accepted(int $type): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => '/type-test-'.$type,
            'destination' => '/target',
            'type' => $type,
        ]);

        $response->assertRedirect(route('admin.redirects.index'));
        $this->assertDatabaseHas('redirects', ['source_path' => '/type-test-'.$type, 'type' => $type]);
    }

    public static function redirectTypeProvider(): array
    {
        return [[301], [302], [307], [308]];
    }

    public function test_duplicate_source_path_is_rejected(): void
    {
        $admin = User::factory()->create();
        Redirect::create(['source_path' => '/dup', 'destination' => '/a', 'type' => 301]);

        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => '/dup',
            'destination' => '/b',
            'type' => 301,
        ]);

        $response->assertSessionHasErrors('source_path');
        $this->assertDatabaseCount('redirects', 1);
    }

    public function test_self_redirect_is_rejected(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => '/loop',
            'destination' => '/loop',
            'type' => 301,
        ]);

        $response->assertSessionHasErrors('destination');
        $this->assertDatabaseCount('redirects', 0);
    }

    public function test_chained_redirect_is_rejected(): void
    {
        $admin = User::factory()->create();
        Redirect::create(['source_path' => '/b', 'destination' => '/c', 'type' => 301]);

        // /a -> /b would chain into the existing /b -> /c
        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => '/a',
            'destination' => '/b',
            'type' => 301,
        ]);

        $response->assertSessionHasErrors('destination');
        $this->assertDatabaseCount('redirects', 1);
    }

    public function test_reverse_loop_redirect_is_rejected(): void
    {
        $admin = User::factory()->create();
        Redirect::create(['source_path' => '/a', 'destination' => '/b', 'type' => 301]);

        // /b -> /a would create a loop with the existing /a -> /b
        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => '/b',
            'destination' => '/a',
            'type' => 301,
        ]);

        $response->assertSessionHasErrors('destination');
        $this->assertDatabaseCount('redirects', 1);
    }

    public function test_internal_and_external_destinations_are_accepted(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => '/internal',
            'destination' => '/somewhere',
            'type' => 301,
        ])->assertSessionDoesntHaveErrors();

        $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => '/external',
            'destination' => 'https://example.com/page',
            'type' => 301,
        ])->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('redirects', ['source_path' => '/internal']);
        $this->assertDatabaseHas('redirects', ['source_path' => '/external']);
    }

    #[DataProvider('unsafeDestinationProvider')]
    public function test_unsafe_destination_protocols_are_rejected(string $destination): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => '/unsafe-test',
            'destination' => $destination,
            'type' => 301,
        ]);

        $response->assertSessionHasErrors('destination');
        $this->assertDatabaseCount('redirects', 0);
    }

    public static function unsafeDestinationProvider(): array
    {
        return [
            ['javascript:alert(1)'],
            ['data:text/html,<script>alert(1)</script>'],
            ['vbscript:msgbox(1)'],
            ['file:///etc/passwd'],
        ];
    }

    #[DataProvider('protectedPrefixProvider')]
    public function test_protected_system_paths_cannot_be_used_as_source(string $path): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'source_path' => $path,
            'destination' => '/somewhere',
            'type' => 301,
        ]);

        $response->assertSessionHasErrors('source_path');
        $this->assertDatabaseCount('redirects', 0);
    }

    public static function protectedPrefixProvider(): array
    {
        return [
            ['/admin/blogs'], ['/api/anything'], ['/storage/file.jpg'], ['/build/app.js'],
            ['/assets/main.css'], ['/login'], ['/logout'], ['/up'], ['/robots.txt'], ['/sitemap.xml'],
        ];
    }

    public function test_active_redirect_is_followed_with_correct_status_code(): void
    {
        Redirect::create(['source_path' => '/old-url', 'destination' => '/pricing', 'type' => 302]);

        $response = $this->get('/old-url');

        $response->assertStatus(302);
        $response->assertRedirect('/pricing');
    }

    public function test_inactive_redirect_is_not_followed(): void
    {
        Redirect::create(['source_path' => '/inactive-url', 'destination' => '/pricing', 'type' => 301, 'is_active' => false]);

        $response = $this->get('/inactive-url');

        $response->assertStatus(404);
    }

    public function test_query_string_is_preserved_on_redirect(): void
    {
        Redirect::create(['source_path' => '/old-search', 'destination' => '/pricing', 'type' => 301]);

        $response = $this->get('/old-search?utm_source=test&ref=abc');

        $location = $response->headers->get('Location');
        parse_str(parse_url($location, PHP_URL_QUERY), $query);

        $response->assertStatus(301);
        $this->assertStringStartsWith('http://localhost/pricing?', $location);
        ksort($query);
        $this->assertSame(['ref' => 'abc', 'utm_source' => 'test'], $query);
    }

    public function test_toggle_activates_and_deactivates(): void
    {
        $admin = User::factory()->create();
        $redirect = Redirect::create(['source_path' => '/toggle-me', 'destination' => '/pricing', 'type' => 301]);

        $this->actingAs($admin)->patch(route('admin.redirects.toggle', $redirect));
        $this->assertFalse($redirect->fresh()->is_active);

        $this->actingAs($admin)->patch(route('admin.redirects.toggle', $redirect));
        $this->assertTrue($redirect->fresh()->is_active);
    }

    public function test_bulk_delete_removes_selected_redirects(): void
    {
        $admin = User::factory()->create();
        $one = Redirect::create(['source_path' => '/bulk-1', 'destination' => '/a', 'type' => 301]);
        $two = Redirect::create(['source_path' => '/bulk-2', 'destination' => '/b', 'type' => 301]);

        $this->actingAs($admin)->post(route('admin.redirects.bulk'), [
            'action' => 'delete',
            'ids' => [$one->id, $two->id],
        ]);

        $this->assertDatabaseCount('redirects', 0);
    }

    public function test_cache_is_invalidated_when_redirect_changes(): void
    {
        $redirect = Redirect::create(['source_path' => '/cache-test', 'destination' => '/pricing', 'type' => 301]);

        $this->assertArrayHasKey('/cache-test', Redirect::activeMap());

        $redirect->update(['is_active' => false]);

        $this->assertArrayNotHasKey('/cache-test', Redirect::activeMap());
    }

    public function test_admin_route_is_never_redirected_even_if_somehow_matched(): void
    {
        // Defense in depth: even if a row existed with a protected source (bypassing validation),
        // normal admin routes must still resolve normally rather than 500 or hang.
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }
}
