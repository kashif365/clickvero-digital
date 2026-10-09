<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

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
                'slug' => 'seo-services',
                'name' => 'SEO Services',
                'short_description' => 'Rank higher, earn qualified organic traffic, and turn search visibility into predictable revenue with our data-driven SEO services.',
                'seo_title' => 'SEO Services | Search Engine Optimization Agency',
                'seo_description' => 'Grow your organic traffic with our SEO services — technical SEO, on-page optimization, content strategy, and link building for businesses worldwide.',
                'keywords' => 'SEO services, search engine optimization, digital marketing agency, organic traffic, technical SEO, on-page SEO, link building',
                'description' => <<<'HTML'
                    <h2>Why SEO Matters for Your Business</h2>
                    <p>Search engine optimization is the foundation of sustainable online growth. Unlike paid advertising, the traffic you earn through SEO keeps compounding over time, giving you a channel that gets more efficient the longer you invest in it. As a full-service digital marketing agency, we build SEO programs around your actual business goals, not vanity rankings.</p>

                    <h2>Benefits of Our SEO Services</h2>
                    <ul>
                        <li><strong>Higher organic visibility</strong> — rank for the keywords your customers are actually searching for.</li>
                        <li><strong>Lower customer acquisition cost</strong> — organic traffic doesn't stop when the ad budget does.</li>
                        <li><strong>Stronger brand trust</strong> — top rankings signal authority and credibility to buyers.</li>
                        <li><strong>Compounding returns</strong> — content and technical fixes keep paying off long after they ship.</li>
                    </ul>

                    <h2>What's Included</h2>
                    <h3>Technical SEO</h3>
                    <p>Site speed, crawlability, indexation, structured data, and Core Web Vitals — we fix the technical issues holding your site back from ranking.</p>
                    <h3>On-Page Optimization</h3>
                    <p>Keyword mapping, title tags, meta descriptions, internal linking, and content optimization aligned to search intent.</p>
                    <h3>Content Strategy</h3>
                    <p>Keyword research and content briefs built around topics your audience is actively searching for.</p>
                    <h3>Authority Building</h3>
                    <p>Ethical link building and digital PR to strengthen your site's authority in your industry.</p>

                    <h2>Our SEO Process</h2>
                    <h3>1. Audit &amp; Research</h3>
                    <p>We start with a full technical and competitive audit to identify quick wins and long-term opportunities.</p>
                    <h3>2. Strategy &amp; Roadmap</h3>
                    <p>We build a prioritized roadmap covering technical fixes, content, and authority building.</p>
                    <h3>3. Execution</h3>
                    <p>Our team implements the roadmap — from code-level fixes to published content.</p>
                    <h3>4. Reporting &amp; Iteration</h3>
                    <p>Monthly reporting on rankings, traffic, and conversions, with the strategy refined as we learn what works.</p>

                    <h2>Why Choose Us for SEO</h2>
                    <p>We're a remote-first digital marketing agency, which means you get a dedicated SEO team without the overhead of a traditional agency. We focus on metrics that matter — organic revenue and qualified leads — not just rankings for their own sake.</p>

                    <h2>Industry Use Cases</h2>
                    <p>Our SEO services work across eCommerce, SaaS, professional services, and content publishers — anywhere search is a meaningful channel for new customers.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'How long does SEO take to show results?', 'answer' => 'Most clients see meaningful movement in rankings and traffic within 3 to 6 months, with compounding gains after that as content and authority build up.'],
                    ['question' => 'Do you guarantee first-page rankings?', 'answer' => 'No ethical SEO agency can guarantee specific rankings, since search engines control their own algorithms. We focus on sustainable, white-hat strategies that deliver long-term organic growth.'],
                    ['question' => 'Is SEO worth it for a new business?', 'answer' => 'Yes — starting SEO early means you build authority and rankings before competitors catch up, and the earlier you start, the sooner you benefit from compounding organic traffic.'],
                    ['question' => 'Do you work with businesses outside the US?', 'answer' => 'Yes, we are a remote-first agency serving clients worldwide, with experience running SEO campaigns across multiple regions and languages.'],
                ],
            ],
            [
                'slug' => 'social-media-marketing',
                'name' => 'Social Media Marketing',
                'short_description' => 'Build an engaged audience and turn followers into customers with strategic, platform-native social media marketing.',
                'seo_title' => 'Social Media Marketing Services | Grow Your Brand Online',
                'seo_description' => 'Our social media marketing services help brands grow engaged audiences on Instagram, Facebook, LinkedIn, and X with strategy, content, and paid social.',
                'keywords' => 'social media marketing, social media management, Instagram marketing, Facebook ads, LinkedIn marketing, content strategy',
                'description' => <<<'HTML'
                    <h2>Turn Social Media Into a Growth Channel</h2>
                    <p>Social media marketing is about more than posting consistently — it's about building an audience that trusts your brand and converts into customers. We design social strategies tailored to each platform's audience and algorithm, not a one-size-fits-all content calendar.</p>

                    <h2>Benefits of Social Media Marketing</h2>
                    <ul>
                        <li><strong>Direct audience connection</strong> — build a community that engages with your brand daily.</li>
                        <li><strong>Increased brand awareness</strong> — reach new audiences through shares, discovery, and paid amplification.</li>
                        <li><strong>Better customer insight</strong> — social listening reveals what your audience actually cares about.</li>
                        <li><strong>Support for other channels</strong> — social proof strengthens SEO, PPC, and email performance.</li>
                    </ul>

                    <h2>What's Included</h2>
                    <h3>Platform Strategy</h3>
                    <p>A content and growth strategy tailored to Instagram, Facebook, LinkedIn, X, or TikTok — wherever your audience actually spends time.</p>
                    <h3>Content Creation</h3>
                    <p>Graphics, short-form video, and copy designed to perform on each specific platform.</p>
                    <h3>Community Management</h3>
                    <p>Timely responses to comments and messages that keep your audience engaged and protect your brand reputation.</p>
                    <h3>Paid Social Campaigns</h3>
                    <p>Targeted paid social to accelerate reach, drive traffic, and generate leads faster than organic alone.</p>

                    <h2>Our Process</h2>
                    <h3>1. Audience Research</h3>
                    <p>We identify who your customers are, which platforms they use, and what content resonates with them.</p>
                    <h3>2. Content Planning</h3>
                    <p>A monthly content calendar aligned with your brand voice and campaign goals.</p>
                    <h3>3. Publishing &amp; Engagement</h3>
                    <p>Consistent publishing paired with active community management.</p>
                    <h3>4. Analysis &amp; Optimization</h3>
                    <p>We track engagement, follower growth, and conversions, adjusting the strategy every month.</p>

                    <h2>Why Choose Us</h2>
                    <p>We treat every platform differently instead of repurposing the same content everywhere. That platform-native approach is why our campaigns consistently outperform generic social calendars.</p>

                    <h2>Industry Use Cases</h2>
                    <p>We've run social media marketing for eCommerce brands, B2B SaaS companies, local service businesses, and personal brands — each with a strategy built around their specific audience.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'Which social platforms should my business be on?', 'answer' => 'It depends on where your audience spends time. B2B brands often see the best results on LinkedIn, while consumer brands typically perform best on Instagram, Facebook, or TikTok. We help you decide during onboarding.'],
                    ['question' => 'Do you create the content or do we?', 'answer' => "We handle strategy, content creation, and publishing end-to-end, though we're happy to incorporate content you already have."],
                    ['question' => 'How do you measure social media success?', 'answer' => 'We track engagement rate, follower growth, click-throughs, and — most importantly — conversions and leads generated from social channels.'],
                    ['question' => 'Do you run paid social ads too?', 'answer' => 'Yes, we manage paid social campaigns alongside organic content to accelerate reach and results.'],
                ],
            ],
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
                'slug' => 'web-development',
                'name' => 'Web Development',
                'short_description' => 'Fast, conversion-focused websites built to turn visitors into customers — designed, developed, and optimized for growth.',
                'seo_title' => 'Web Development Services | Custom Websites That Convert',
                'seo_description' => 'Our web development services deliver fast, responsive, SEO-ready websites built to convert visitors into customers, with ongoing support included.',
                'keywords' => 'web development services, website design, custom websites, responsive web design, website development agency',
                'description' => <<<'HTML'
                    <h2>Your Website Is Your Most Important Marketing Asset</h2>
                    <p>Every marketing channel eventually sends traffic to your website — which means a slow, confusing, or outdated site quietly undermines every other investment you make. We build websites engineered specifically for conversions, speed, and long-term scalability.</p>

                    <h2>Benefits of Professional Web Development</h2>
                    <ul>
                        <li><strong>Higher conversion rates</strong> — clear user journeys turn more visitors into leads and customers.</li>
                        <li><strong>Better SEO performance</strong> — fast, well-structured sites rank better in search engines.</li>
                        <li><strong>Improved credibility</strong> — a polished site builds instant trust with new visitors.</li>
                        <li><strong>Long-term scalability</strong> — a solid technical foundation grows with your business.</li>
                    </ul>

                    <h2>What's Included</h2>
                    <h3>Custom Design</h3>
                    <p>A design system built around your brand, not a generic template.</p>
                    <h3>Responsive Development</h3>
                    <p>Fully responsive builds tested across desktop, tablet, and mobile devices.</p>
                    <h3>SEO-Ready Foundation</h3>
                    <p>Clean code, fast load times, and proper technical structure from day one.</p>
                    <h3>Ongoing Support</h3>
                    <p>Post-launch support for updates, fixes, and performance monitoring.</p>

                    <h2>Our Process</h2>
                    <h3>1. Discovery</h3>
                    <p>We learn your business goals, target audience, and the actions you want visitors to take.</p>
                    <h3>2. Design</h3>
                    <p>Wireframes and visual design focused on clarity and conversion.</p>
                    <h3>3. Development</h3>
                    <p>Clean, performant development with careful attention to speed and accessibility.</p>
                    <h3>4. Launch &amp; Support</h3>
                    <p>A thorough QA process before launch, followed by ongoing support as your site grows.</p>

                    <h2>Why Choose Us</h2>
                    <p>We build websites as marketing assets first and design objects second — every decision is made with conversions and search performance in mind.</p>

                    <h2>Industry Use Cases</h2>
                    <p>We build websites for service businesses, eCommerce stores, SaaS products, and content-driven brands that need a site that performs as hard as it looks.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'How long does a website project take?', 'answer' => 'Most projects take 4 to 8 weeks depending on scope, from discovery through launch.'],
                    ['question' => 'Will my website be mobile-friendly?', 'answer' => 'Yes, every site we build is fully responsive and tested across desktop, tablet, and mobile devices.'],
                    ['question' => 'Do you offer website maintenance after launch?', 'answer' => 'Yes, we offer ongoing support plans covering updates, monitoring, and fixes after your site goes live.'],
                    ['question' => 'Will my new website be optimized for SEO?', 'answer' => 'Yes, every website we build starts with a clean, fast, SEO-ready technical foundation.'],
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
