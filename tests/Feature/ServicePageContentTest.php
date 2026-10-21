<?php

namespace Tests\Feature;

use App\Models\Service;
use Database\Seeders\ServicePageContentSeeder;
use Database\Seeders\WebDevelopmentContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePageContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_new_pages_and_updates_existing_ones_in_place(): void
    {
        $existing = Service::create(['name' => 'Old SEO', 'slug' => 'seo-services', 'description' => '<p>Old</p>', 'sort_order' => 3, 'banner_image' => 'services/banner.webp']);
        Service::create(['name' => 'Branding', 'slug' => 'branding', 'sort_order' => 9]);

        $this->seed(ServicePageContentSeeder::class);
        $this->seed(ServicePageContentSeeder::class); // re-running is safe

        $this->assertSame(5, Service::count());

        $seo = $existing->fresh();
        $this->assertSame('SEO Services Company That Turns Search Traffic Into Sales', $seo->headline);
        $this->assertSame(3, $seo->sort_order);
        $this->assertSame('services/banner.webp', $seo->banner_image);
        $this->assertCount(10, $seo->faqs);

        $this->assertGreaterThan(9, Service::where('slug', 'local-seo-services')->value('sort_order'));
        $this->assertTrue((bool) Service::where('slug', 'search-engine-marketing-services')->value('status'));
    }

    public function test_seeded_markup_survives_sanitizing_and_reaches_the_api(): void
    {
        $this->seed(ServicePageContentSeeder::class);

        $response = $this->getJson('/api/v1/services/local-seo-services')
            ->assertOk()
            ->assertJsonPath('data.headline', 'Local SEO Services That Turn Nearby Searches Into Real Customers');

        $html = $response->json('data.description');

        // The page design relies on these elements (see .service-content in app.css).
        $this->assertSame(10, substr_count($html, '<blockquote>'));
        $this->assertStringContainsString('<ol>', $html);
        $this->assertStringContainsString('<a href="/contact">', $html);
        $this->assertStringNotContainsString('Digital Marketings World', $html);
    }

    public function test_web_development_pages_update_existing_services_without_duplicates(): void
    {
        Service::create(['name' => 'Web Development', 'slug' => 'web-development', 'sort_order' => 4]);
        Service::create(['name' => 'E-Commerce Web Development', 'slug' => 'ecommerce-web-development', 'sort_order' => 12]);
        Service::create(['name' => 'Web Application Development', 'slug' => 'web-app-development', 'sort_order' => 13]);

        $this->seed(WebDevelopmentContentSeeder::class);

        $this->assertSame(5, Service::count());
        $this->assertSame(4, Service::where('slug', 'web-development')->value('sort_order'));
        $this->assertSame(
            'Web Application Development Services That Turn Your Ideas Into Business Growth',
            Service::where('slug', 'web-app-development')->value('headline'),
        );

        $html = $this->getJson('/api/v1/services/business-website-development')->assertOk()->json('data.description');
        $this->assertStringContainsString('<a href="/services/custom-website-development-services">', $html);
        $this->assertStringNotContainsString('Digital Marketings World', $html);
        $this->assertStringNotContainsString('digitalmarketingshub', $html);
    }
}
