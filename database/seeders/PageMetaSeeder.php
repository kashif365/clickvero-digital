<?php

namespace Database\Seeders;

use App\Models\PageMeta;
use Illuminate\Database\Seeder;

class PageMetaSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'home' => [
                'title' => 'Digital Marketing Services to Grow Your Business Fast',
                'description' => 'Turn clicks into customers with professional Digital Marketing Services. Get smarter SEO, paid advertising and marketing strategies built to grow your business.',
            ],
            'about' => [
                'title' => 'About Us | Clickvora Digital',
                'description' => 'Learn about Clickvora Digital — a remote-first digital marketing agency helping businesses grow online, wherever they are.',
            ],
            'blog' => [
                'title' => 'Blog | Clickvora Digital',
                'description' => 'Insights on SEO, digital marketing, and online growth from the Clickvora Digital team.',
            ],
            'contact' => [
                'title' => 'Contact Us | Clickvora Digital',
                'description' => 'Get in touch with Clickvora Digital for a free consultation. We work with clients remotely, wherever you are.',
            ],
            'faq' => [
                'title' => 'FAQ | Clickvora Digital',
                'description' => 'Answers to frequently asked questions about our digital marketing services.',
            ],
            'pricing' => [
                'title' => 'Pricing | Clickvora Digital',
                'description' => 'Explore Clickvora Digital\' pricing plans and packages.',
            ],
            'project' => [
                'title' => 'Our Work | Clickvora Digital',
                'description' => 'Browse case studies and campaign wins from Clickvora Digital.',
            ],
            'project-details' => [
                'title' => 'Case Study | Clickvora Digital',
                'description' => 'A detailed look at a digital marketing campaign delivered by Clickvora Digital.',
            ],
            'service' => [
                'title' => 'Digital Marketing Services | Clickvora Digital',
                'description' => 'Explore our full range of digital marketing services: SEO, social media marketing, PPC advertising, web development, content marketing, branding, and email marketing.',
            ],
            'team' => [
                'title' => 'Our Team | Clickvora Digital',
                'description' => 'Meet the remote team behind Clickvora Digital.',
            ],
            'team-details' => [
                'title' => 'Team Member | Clickvora Digital',
                'description' => 'Learn more about a member of the Clickvora Digital team.',
            ],
        ];

        foreach ($pages as $route => $meta) {
            PageMeta::updateOrCreate(['route' => $route], $meta);
        }
    }
}
