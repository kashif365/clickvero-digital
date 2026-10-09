<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\BlogSeeder;
use Database\Seeders\DemoContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TestimonialAndTeamTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guest_cannot_manage_testimonials_or_team(): void
    {
        $this->get(route('admin.testimonials.index'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.testimonials.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.team-members.index'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.team-members.store'), [])->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_update_and_delete_a_testimonial(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get(route('admin.testimonials.create'))->assertOk();

        $this->actingAs($admin)->post(route('admin.testimonials.store'), [
            'name' => 'Jane Client',
            'role' => 'Founder, Acme',
            'quote' => 'Clear plan, reliable delivery.',
            'is_active' => 1,
            'sort_order' => 2,
        ])->assertRedirect(route('admin.testimonials.index'));

        $testimonial = Testimonial::firstOrFail();
        $this->assertSame('Jane Client', $testimonial->name);

        $this->actingAs($admin)->get(route('admin.testimonials.edit', $testimonial))->assertOk()->assertSee('Jane Client');

        $this->actingAs($admin)->put(route('admin.testimonials.update', $testimonial), [
            'name' => 'Jane Client',
            'quote' => 'Updated quote.',
            'is_active' => 0,
        ])->assertRedirect(route('admin.testimonials.index'));

        $this->assertDatabaseHas('testimonials', ['quote' => 'Updated quote.', 'is_active' => false]);

        $this->actingAs($admin)->delete(route('admin.testimonials.destroy', $testimonial))->assertRedirect();
        $this->assertDatabaseCount('testimonials', 0);
    }

    public function test_testimonial_requires_a_name_and_quote(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.testimonials.store'), ['name' => '', 'quote' => ''])
            ->assertSessionHasErrors(['name', 'quote']);
    }

    public function test_admin_can_create_a_team_member_with_a_photo(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.team-members.store'), [
            'name' => 'Sam Strategist',
            'role' => 'SEO Lead',
            'bio' => 'Owns organic growth.',
            'photo' => UploadedFile::fake()->image('sam.jpg', 400, 500),
            'is_active' => 1,
        ])->assertRedirect(route('admin.team-members.index'));

        $member = TeamMember::firstOrFail();
        $this->assertStringStartsWith('/storage/team/', $member->photo);
        Storage::disk('public')->assertExists(str_replace('/storage/', '', $member->photo));

        // Updating without a new file keeps the existing photo.
        $this->actingAs($admin)->put(route('admin.team-members.update', $member), [
            'name' => 'Sam Strategist',
            'role' => 'Head of SEO',
            'is_active' => 1,
        ])->assertRedirect(route('admin.team-members.index'));

        $this->assertSame('Head of SEO', $member->fresh()->role);
        $this->assertSame($member->photo, $member->fresh()->photo);
    }

    public function test_team_member_photo_must_be_an_image(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.team-members.store'), [
            'name' => 'Sam',
            'role' => 'Lead',
            'photo' => UploadedFile::fake()->create('notes.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors('photo');
    }

    public function test_api_only_returns_active_entries_in_display_order(): void
    {
        Testimonial::create(['name' => 'Second', 'quote' => 'B', 'sort_order' => 2]);
        Testimonial::create(['name' => 'First', 'quote' => 'A', 'sort_order' => 1]);
        Testimonial::create(['name' => 'Hidden', 'quote' => 'C', 'is_active' => false]);

        $this->getJson('/api/v1/testimonials')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.name', 'First')
            ->assertJsonPath('data.1.name', 'Second');

        TeamMember::create(['name' => 'Visible', 'role' => 'Lead', 'sort_order' => 1]);
        TeamMember::create(['name' => 'Hidden', 'role' => 'Lead', 'is_active' => false]);

        $this->getJson('/api/v1/team')->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.name', 'Visible');
    }

    public function test_api_returns_empty_lists_when_nothing_is_published(): void
    {
        $this->getJson('/api/v1/testimonials')->assertOk()->assertExactJson(['data' => []]);
        $this->getJson('/api/v1/team')->assertOk()->assertExactJson(['data' => []]);
    }

    public function test_seeders_are_idempotent_and_produce_valid_content(): void
    {
        $this->seed([BlogSeeder::class, DemoContentSeeder::class]);
        $this->seed([BlogSeeder::class, DemoContentSeeder::class]);

        $this->assertDatabaseCount('blogs', 9);
        $this->assertDatabaseCount('testimonials', 3);
        $this->assertDatabaseCount('team_members', 8);

        $this->getJson('/api/v1/blogs?per_page=24')->assertOk()->assertJsonCount(9, 'data');
        $this->getJson('/api/v1/blogs/technical-seo-checklist')
            ->assertOk()
            ->assertJsonPath('data.category', 'SEO')
            ->assertJsonCount(3, 'related');
    }
}
