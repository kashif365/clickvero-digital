<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Core service pages. The SEO, Local SEO, Search Engine Marketing, and Social
 * Media Marketing pages live in ServicePageContentSeeder; the website and web app
 * development pages live in WebDevelopmentContentSeeder.
 */
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->services() as $index => $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                array_merge($service, ['sort_order' => $index + 1])
            );
        }
    }

    private function services(): array
    {
        return [
            [
                'slug' => 'pay-per-click-advertising',
                'name' => 'Pay-Per-Click (PPC) Advertising',
                'short_description' => 'Get in front of ready-to-buy customers instantly with expertly managed PPC campaigns across Google, Bing, and social platforms.',
                'seo_title' => 'PPC Advertising Services | Paid Search & Social Ads',
                'seo_description' => 'Our PPC advertising services deliver measurable ROI through Google Ads, Bing Ads, and paid social campaigns managed by certified specialists.',
                'keywords' => 'PPC advertising, pay per click, Google Ads, paid search, paid social, PPC management, digital marketing agency',
                'description' => <<<'HTML'
                    <h2>Instant Visibility, Measurable Results</h2>
                    <p>Pay-per-click advertising puts your business in front of customers the moment they're searching for what you offer. Unlike SEO, PPC delivers immediate traffic, giving you a fast, controllable, and highly measurable channel for growth.</p>

                    <h2>Benefits of PPC Advertising</h2>
                    <ul>
                        <li><strong>Immediate results</strong> — start driving qualified traffic from day one.</li>
                        <li><strong>Full budget control</strong> — you decide exactly how much to spend and where.</li>
                        <li><strong>Precise targeting</strong> — reach customers by keyword, location, device, and intent.</li>
                        <li><strong>Transparent ROI</strong> — every click and conversion is tracked and reported.</li>
                    </ul>

                    <h2>What's Included</h2>
                    <h3>Campaign Strategy</h3>
                    <p>Keyword research, competitor analysis, and budget planning built around your target cost per acquisition.</p>
                    <h3>Ad Creation &amp; Copywriting</h3>
                    <p>Compelling ad copy and creative designed to maximize click-through and conversion rates.</p>
                    <h3>Landing Page Guidance</h3>
                    <p>Recommendations to align landing pages with ad intent for higher Quality Scores and conversion rates.</p>
                    <h3>Bid &amp; Budget Management</h3>
                    <p>Ongoing bid adjustments and budget reallocation toward what's actually converting.</p>

                    <h2>Our Process</h2>
                    <h3>1. Discovery &amp; Goal Setting</h3>
                    <p>We define target cost per acquisition, budget, and priority campaigns.</p>
                    <h3>2. Campaign Build</h3>
                    <p>Account structure, keyword targeting, ad copy, and tracking are set up and quality-checked before launch.</p>
                    <h3>3. Launch &amp; Monitor</h3>
                    <p>Campaigns go live with close monitoring during the initial learning phase.</p>
                    <h3>4. Optimize &amp; Scale</h3>
                    <p>We continuously test ad variations and reallocate budget toward top-performing campaigns.</p>

                    <h2>Why Choose Us</h2>
                    <p>We manage PPC as a performance channel, not a "set and forget" line item. Every campaign is actively optimized against real business metrics — leads and revenue, not just clicks.</p>

                    <h2>Industry Use Cases</h2>
                    <p>Our PPC management supports eCommerce stores driving direct sales, B2B companies generating qualified leads, and local businesses filling appointment calendars.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'How much should I budget for PPC advertising?', 'answer' => 'Budgets vary widely by industry and competition. We help determine a realistic starting budget during onboarding based on your goals and target cost per acquisition.'],
                    ['question' => 'How quickly will I see results from PPC?', 'answer' => "PPC can drive traffic within days of launch, though campaigns typically need 2 to 4 weeks of data before they're fully optimized."],
                    ['question' => 'Which platforms do you manage PPC on?', 'answer' => 'We manage campaigns on Google Ads, Bing Ads, and paid social platforms including Facebook, Instagram, and LinkedIn Ads.'],
                    ['question' => 'Do you require long-term contracts?', 'answer' => "We recommend at least a 3-month commitment to allow campaigns to reach full optimization, but we don't lock clients into long-term contracts."],
                ],
            ],
            [
                'slug' => 'content-marketing',
                'name' => 'Content Marketing',
                'short_description' => 'Attract, educate, and convert your audience with strategic content that builds authority and drives organic growth.',
                'seo_title' => 'Content Marketing Services | Content Strategy & Creation',
                'seo_description' => 'Our content marketing services combine strategy, writing, and distribution to build authority, drive organic traffic, and generate qualified leads.',
                'keywords' => 'content marketing, content strategy, blog writing, content creation, inbound marketing, digital marketing agency',
                'description' => <<<'HTML'
                    <h2>Content That Builds Authority and Drives Growth</h2>
                    <p>Content marketing is how modern brands earn attention, trust, and organic traffic without relying solely on paid channels. We build content strategies rooted in what your audience is actually searching for and struggling with — not just what's trending.</p>

                    <h2>Benefits of Content Marketing</h2>
                    <ul>
                        <li><strong>Compounding organic traffic</strong> — quality content keeps attracting visitors long after it's published.</li>
                        <li><strong>Established authority</strong> — helpful, expert content builds trust with your audience.</li>
                        <li><strong>Supports every channel</strong> — content fuels SEO, social media, and email marketing.</li>
                        <li><strong>Lower cost per lead</strong> — content marketing typically costs less than paid acquisition over time.</li>
                    </ul>

                    <h2>What's Included</h2>
                    <h3>Content Strategy</h3>
                    <p>A content roadmap built around keyword research and your customers' buying journey.</p>
                    <h3>Blog &amp; Article Writing</h3>
                    <p>SEO-optimized, well-researched content written for your audience and your brand voice.</p>
                    <h3>Content Distribution</h3>
                    <p>Repurposing and promoting content across email, social, and other owned channels.</p>
                    <h3>Performance Tracking</h3>
                    <p>Reporting on traffic, engagement, and conversions generated from published content.</p>

                    <h2>Our Process</h2>
                    <h3>1. Research &amp; Strategy</h3>
                    <p>We identify the topics and keywords most likely to attract and convert your target audience.</p>
                    <h3>2. Content Calendar</h3>
                    <p>A planned publishing schedule aligned with your marketing goals.</p>
                    <h3>3. Creation &amp; Editing</h3>
                    <p>Every piece is researched, written, and edited to a professional publishing standard.</p>
                    <h3>4. Distribution &amp; Analysis</h3>
                    <p>Content is promoted across relevant channels, with performance tracked and reported monthly.</p>

                    <h2>Why Choose Us</h2>
                    <p>We write content built to rank and convert, not just fill a calendar. Every piece is tied back to a measurable goal — traffic, leads, or authority.</p>

                    <h2>Industry Use Cases</h2>
                    <p>Our content marketing services support SaaS companies building thought leadership, eCommerce brands driving organic traffic, and service businesses establishing local authority.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'How often should we publish new content?', 'answer' => 'Consistency matters more than volume — most clients publish 2 to 4 pieces per month, though the right cadence depends on your goals and resources.'],
                    ['question' => 'Do you write the content or just create a strategy?', 'answer' => 'We handle the full process: strategy, writing, editing, and distribution guidance.'],
                    ['question' => 'How does content marketing support SEO?', 'answer' => 'Content targeting the right keywords is one of the strongest ways to build organic search visibility over time.'],
                    ['question' => 'Can you write content for a technical or niche industry?', 'answer' => "Yes, we research each client's industry thoroughly and can work with subject-matter experts to ensure accuracy."],
                ],
            ],
            [
                'slug' => 'branding',
                'name' => 'Branding Services',
                'short_description' => 'Build a brand identity and messaging system that makes your business instantly recognizable and trustworthy.',
                'seo_title' => 'Branding Services | Brand Identity & Strategy Agency',
                'seo_description' => 'Our branding services help businesses build a distinctive identity, voice, and visual system that builds trust and stands out from competitors.',
                'keywords' => 'branding services, brand identity, brand strategy, logo design, brand messaging, digital marketing agency',
                'description' => <<<'HTML'
                    <h2>A Strong Brand Is a Competitive Advantage</h2>
                    <p>Your brand is more than a logo — it's the consistent experience, voice, and visual identity that makes your business memorable and trustworthy. We help companies build brand systems that hold up across every touchpoint, from your website to your ads to your packaging.</p>

                    <h2>Benefits of Professional Branding</h2>
                    <ul>
                        <li><strong>Instant recognition</strong> — a consistent identity makes your brand memorable.</li>
                        <li><strong>Increased trust</strong> — professional branding signals credibility to new customers.</li>
                        <li><strong>Premium positioning</strong> — strong brands can command higher prices.</li>
                        <li><strong>Marketing consistency</strong> — a clear brand system speeds up every future campaign.</li>
                    </ul>

                    <h2>What's Included</h2>
                    <h3>Brand Strategy</h3>
                    <p>Positioning, messaging, and voice guidelines that define how your brand shows up everywhere.</p>
                    <h3>Visual Identity</h3>
                    <p>Logo design, color palette, and typography built into a cohesive visual system.</p>
                    <h3>Brand Guidelines</h3>
                    <p>A documented style guide so your team and partners stay consistent.</p>
                    <h3>Marketing Collateral</h3>
                    <p>Templates and assets ready for use across your website, social media, and campaigns.</p>

                    <h2>Our Process</h2>
                    <h3>1. Discovery</h3>
                    <p>We learn about your business, audience, competitors, and long-term vision.</p>
                    <h3>2. Strategy</h3>
                    <p>We define your positioning, voice, and messaging pillars.</p>
                    <h3>3. Visual Design</h3>
                    <p>Logo, color, and typography exploration through to a finished identity system.</p>
                    <h3>4. Guidelines &amp; Rollout</h3>
                    <p>A complete brand guide and rollout across your key marketing assets.</p>

                    <h2>Why Choose Us</h2>
                    <p>We build brands as strategic assets, grounded in market positioning — not just visual preference. The result is a brand identity that supports every other marketing effort you make.</p>

                    <h2>Industry Use Cases</h2>
                    <p>We've built brand identities for startups launching for the first time, established businesses repositioning for growth, and companies expanding into new markets.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'How long does a branding project take?', 'answer' => 'A full brand identity project typically takes 4 to 6 weeks, depending on scope and rounds of revision.'],
                    ['question' => 'Do you design logos only, or full brand systems?', 'answer' => 'We build complete brand systems — strategy, visual identity, and guidelines — not just a standalone logo.'],
                    ['question' => 'Can you rebrand an existing business?', 'answer' => 'Yes, we regularly help established businesses reposition and refresh their brand identity as they grow or pivot.'],
                    ['question' => 'What do we receive at the end of a branding project?', 'answer' => "You'll receive a complete brand guidelines document, logo files, and core marketing templates ready to use."],
                ],
            ],
            [
                'slug' => 'email-marketing',
                'name' => 'Email Marketing',
                'short_description' => 'Turn your email list into a reliable revenue channel with strategic campaigns, automation, and segmentation.',
                'seo_title' => 'Email Marketing Services | Campaigns & Automation',
                'seo_description' => 'Our email marketing services build automated flows and campaigns that nurture leads, retain customers, and drive consistent revenue.',
                'keywords' => 'email marketing, email automation, email campaigns, newsletter marketing, digital marketing agency',
                'description' => <<<'HTML'
                    <h2>One of the Highest-ROI Marketing Channels</h2>
                    <p>Email marketing consistently delivers some of the highest returns of any digital channel — when it's done right. We build email programs that nurture leads, retain customers, and drive repeat revenue through strategic campaigns and automation.</p>

                    <h2>Benefits of Email Marketing</h2>
                    <ul>
                        <li><strong>High ROI</strong> — email remains one of the most cost-effective marketing channels available.</li>
                        <li><strong>Direct ownership</strong> — unlike social platforms, you own your email list.</li>
                        <li><strong>Personalization at scale</strong> — segmentation lets you send the right message to the right person.</li>
                        <li><strong>Automated revenue</strong> — flows like welcome series and abandoned cart run on autopilot.</li>
                    </ul>

                    <h2>What's Included</h2>
                    <h3>List Segmentation</h3>
                    <p>Grouping subscribers by behavior and interests for more relevant, higher-converting emails.</p>
                    <h3>Campaign Creation</h3>
                    <p>Designed, written, and tested email campaigns aligned with your goals.</p>
                    <h3>Automation Flows</h3>
                    <p>Welcome series, abandoned cart, re-engagement, and other automated sequences built to run continuously.</p>
                    <h3>Performance Reporting</h3>
                    <p>Open rates, click-throughs, and revenue attribution tracked and reported regularly.</p>

                    <h2>Our Process</h2>
                    <h3>1. Audit &amp; Strategy</h3>
                    <p>We review your current list, tools, and goals to build a tailored email strategy.</p>
                    <h3>2. Flow &amp; Campaign Build</h3>
                    <p>We build core automation flows and a campaign calendar.</p>
                    <h3>3. Testing &amp; Launch</h3>
                    <p>Every email is tested across devices and inboxes before it goes live.</p>
                    <h3>4. Optimization</h3>
                    <p>We continuously test subject lines, content, and send times to improve performance.</p>

                    <h2>Why Choose Us</h2>
                    <p>We treat email as a revenue channel, not just a newsletter. Every campaign and flow is built with clear performance goals and measured against real business outcomes.</p>

                    <h2>Industry Use Cases</h2>
                    <p>Our email marketing services support eCommerce brands recovering abandoned carts, SaaS companies nurturing trial users, and service businesses staying top-of-mind with past clients.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'What email platforms do you work with?', 'answer' => "We work with all major email platforms and can recommend the right one for your business if you don't already have one."],
                    ['question' => 'Do I need a large email list to get started?', 'answer' => 'No — email marketing works at any list size. We help you grow your list while optimizing what you send to current subscribers.'],
                    ['question' => 'What automated flows do you recommend?', 'answer' => 'Common starting points include welcome series, abandoned cart, post-purchase, and win-back flows, tailored to your business type.'],
                    ['question' => 'How do you measure email marketing success?', 'answer' => 'We track open rates, click-through rates, and — most importantly — revenue and conversions attributed to email.'],
                ],
            ],
        ];
    }
}
