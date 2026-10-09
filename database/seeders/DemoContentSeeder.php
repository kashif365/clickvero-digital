<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

/**
 * Placeholder testimonials and team members so the related page sections can
 * be reviewed during development. These people are NOT real: DatabaseSeeder
 * skips this seeder in production, and anything seeded locally should be
 * replaced with genuine entries in the admin panel before launch.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Areeba Khan', 'role' => 'Founder, Northline Retail', 'quote' => 'They translated our product vision into a clean, fast storefront that immediately improved customer engagement.'],
            ['name' => 'Usman Raza', 'role' => 'CEO, RouteSync Labs', 'quote' => 'They handled strategy, design, and development with the kind of clarity that makes launches feel controlled.'],
            ['name' => 'Hina Malik', 'role' => 'Marketing Director, Studio Nine', 'quote' => 'The team brought structure to our campaigns and gave us reporting we could actually use in weekly decisions.'],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::updateOrCreate(['name' => $testimonial['name']], $testimonial + ['sort_order' => $index + 1]);
        }

        $team = [
            ['name' => 'Arlene McCoy', 'role' => 'Project Manager', 'photo' => 'team-1-1.png', 'bio' => 'Keeps scope, timelines, and communication on track from kickoff to launch.'],
            ['name' => 'Jenny Wilson', 'role' => 'Lead Developer', 'photo' => 'team-1-2.png', 'bio' => 'Builds fast, accessible websites and the tracking that campaigns depend on.'],
            ['name' => 'Kristin Watson', 'role' => 'Brand Strategist', 'photo' => 'team-1-3.png', 'bio' => 'Shapes positioning and messaging so every channel tells the same story.'],
            ['name' => 'Robin Khan', 'role' => 'SEO Lead', 'photo' => 'team-1-4.png', 'bio' => 'Owns technical audits, keyword strategy, and organic growth roadmaps.'],
            ['name' => 'Esther Howard', 'role' => 'Paid Media Manager', 'photo' => 'team-1-5.png', 'bio' => 'Plans, launches, and optimizes search and social ad campaigns.'],
            ['name' => 'Wade Warren', 'role' => 'Content Lead', 'photo' => 'team-1-6.png', 'bio' => 'Turns research into articles, landing pages, and email that convert.'],
            ['name' => 'Albert Flores', 'role' => 'Analytics Specialist', 'photo' => 'team-1-7.png', 'bio' => 'Sets up measurement and turns raw data into plain-language reporting.'],
            ['name' => 'Eleanor Pena', 'role' => 'Designer', 'photo' => 'team-1-8.png', 'bio' => 'Designs brand systems, ad creative, and conversion-focused pages.'],
        ];

        foreach ($team as $index => $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name']],
                array_merge($member, ['photo' => '/assets/img/team/'.$member['photo'], 'sort_order' => $index + 1])
            );
        }
    }
}
