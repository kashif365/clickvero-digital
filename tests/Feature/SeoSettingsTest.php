<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SeoSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guest_cannot_view_or_update_seo_settings(): void
    {
        $this->get(route('admin.seo-settings.edit'))->assertRedirect(route('admin.login'));
        $this->put(route('admin.seo-settings.update'), [])->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_seo_settings_with_sensible_defaults(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.seo-settings.edit'));

        $response->assertOk();
        $this->assertTrue(SiteSetting::current()->default_robots_index);
    }

    public function test_admin_can_update_seo_settings(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.seo-settings.update'), [
            'site_name' => 'My Site',
            'title_suffix' => '| My Site',
            'default_title' => 'Default Title',
            'default_description' => 'Default description.',
            'default_keywords' => 'seo, marketing, growth',
            'organization_name' => 'My Org',
            'contact_email' => 'hello@example.com',
            'facebook' => 'https://facebook.com/mysite',
        ]);

        $response->assertRedirect(route('admin.seo-settings.edit'));

        $settings = SiteSetting::current();
        $this->assertSame('My Site', $settings->site_name);
        $this->assertSame(['seo', 'marketing', 'growth'], $settings->default_keywords);
        $this->assertSame('https://facebook.com/mysite', $settings->social_links['facebook']);
    }

    public function test_settings_cache_reflects_updates(): void
    {
        $admin = User::factory()->create();
        $this->assertNotSame('Updated Name', SiteSetting::current()->site_name);

        $this->actingAs($admin)->put(route('admin.seo-settings.update'), ['site_name' => 'Updated Name']);

        $this->assertSame('Updated Name', SiteSetting::current()->site_name);
    }
}

