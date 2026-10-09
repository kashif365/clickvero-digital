<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    private const AUTHOR = 'Clickvora Editorial Team';

    public function run(): void
    {
        foreach ($this->posts() as $post) {
            Blog::updateOrCreate(
                ['slug' => $post['slug']],
                $post + ['author' => self::AUTHOR]
            );
        }
    }

    private function posts(): array
    {
        return [
            [
                'slug' => 'technical-seo-checklist',
                'title' => 'A Technical SEO Checklist You Can Actually Finish',
                'category' => 'SEO',
                'image' => '/assets/img/blog/blog-1-2.jpg',
                'published_at' => '2026-09-28',
                'excerpt' => 'Technical SEO does not have to be a hundred-item audit. These are the checks that decide whether search engines can find, read, and trust your pages.',
                'content' => <<<'HTML'
<p>Most technical SEO audits fail for a simple reason: they are too long to act on. A spreadsheet with two hundred rows gets filed away, and nothing ships. This checklist is deliberately short. It covers the issues that most often stop good content from ranking.</p>
<h2>1. Make sure your pages can be crawled and indexed</h2>
<p>Before anything else, confirm search engines are allowed to see the pages you care about.</p>
<ul>
<li>Check <code>robots.txt</code> for rules that block important sections by accident.</li>
<li>Look for stray <code>noindex</code> tags left over from staging or a redesign.</li>
<li>Submit an XML sitemap that lists only the pages you want indexed.</li>
<li>Review the indexing report in Google Search Console for pages marked as excluded.</li>
</ul>
<h2>2. Fix what slows people down</h2>
<p>Speed matters because people leave slow pages, and search engines measure that experience. Compress and correctly size images, load fonts efficiently, and remove scripts nobody remembers adding. Test your key templates, not just the home page: a product or service page is usually where the visit is won or lost.</p>
<h2>3. Give every page one clear job</h2>
<p>Each page should have a unique title, a single main heading, and a canonical URL that points to itself. When several URLs show the same content, pick one and redirect or canonicalize the rest. Duplicate pages compete with each other and dilute the signals you have earned.</p>
<h2>4. Repair the paths between pages</h2>
<p>Internal links tell search engines which pages matter. Fix broken links, replace redirect chains with direct links, and make sure your most valuable pages are reachable within a few clicks of the home page.</p>
<h2>5. Add structured data where it is genuinely useful</h2>
<p>Schema markup helps search engines understand what a page is: an article, a service, a set of questions and answers. Mark up what is truly on the page and validate it before you publish.</p>
<h2>How to prioritize</h2>
<p>Start with anything that blocks indexing, then speed, then duplication and internal links. Re-check after every major site change. Technical SEO is not a one-time project; it is maintenance that protects everything else you invest in.</p>
HTML,
            ],
            [
                'slug' => 'seo-vs-ppc-where-to-invest-first',
                'title' => 'SEO vs. PPC: Where Should You Invest First?',
                'category' => 'Strategy',
                'image' => '/assets/img/blog/blog-1-1.jpg',
                'published_at' => '2026-09-21',
                'excerpt' => 'Paid search buys speed. Organic search builds an asset. The right first move depends on your timeline, your margins, and how well you already know your customer.',
                'content' => <<<'HTML'
<p>It is one of the first questions every growing business asks: should the budget go to search engine optimization or to paid ads? The honest answer is that they solve different problems, and the right starting point depends on where you are.</p>
<h2>What PPC is good at</h2>
<p>Pay-per-click advertising puts you in front of buyers almost immediately. You choose the keywords, set a budget, and get data within days.</p>
<ul>
<li><strong>Speed:</strong> useful for launches, seasonal offers, and testing a new market.</li>
<li><strong>Control:</strong> you decide exactly which searches trigger which message.</li>
<li><strong>Learning:</strong> you quickly discover which keywords and offers convert.</li>
</ul>
<p>The trade-off is that the traffic stops the moment the spend stops.</p>
<h2>What SEO is good at</h2>
<p>Organic search takes longer to build, but the results compound. A page that ranks well can bring in qualified visitors for years without a cost per click. SEO also builds credibility: many people skip the ads and trust the organic results beneath them.</p>
<p>The trade-off is time. Meaningful movement usually takes months, not weeks, and it requires consistent work on content, site quality, and authority.</p>
<h2>A simple way to decide</h2>
<ul>
<li><strong>You need leads this quarter:</strong> start with PPC, and use what you learn to guide SEO.</li>
<li><strong>You have a long sales cycle and a content-hungry audience:</strong> start building SEO now.</li>
<li><strong>Your margins are thin:</strong> be careful with paid clicks and lean harder on organic.</li>
<li><strong>You are entering a new market:</strong> test demand with ads before investing in content.</li>
</ul>
<h2>Why the best answer is usually both</h2>
<p>The two channels make each other better. Paid search data shows which keywords convert, so SEO effort goes where the revenue is. Strong organic pages improve landing-page quality and lower the cost of paid campaigns. Treat them as one search strategy with a short-term engine and a long-term engine, and shift the balance as organic traffic grows.</p>
HTML,
            ],
            [
                'slug' => 'landing-pages-that-convert',
                'title' => 'Seven Elements of a Landing Page That Converts',
                'category' => 'Web Development',
                'image' => '/assets/img/blog/blog-1-3.jpg',
                'published_at' => '2026-09-14',
                'excerpt' => 'Sending paid traffic to a generic page wastes budget. A focused landing page gives each visitor one message, one offer, and one clear next step.',
                'content' => <<<'HTML'
<p>A landing page has one job: turn a visitor with a specific intent into a lead or a customer. When campaigns underperform, the problem is often not the ad. It is the page the ad sends people to. These seven elements show up on almost every page that performs well.</p>
<h2>1. A headline that matches the ad</h2>
<p>If someone clicks an ad about a free audit, the page should open by talking about the free audit. Message match reassures visitors they are in the right place.</p>
<h2>2. One clear call to action</h2>
<p>Decide the single action you want and repeat it. Remove competing links, secondary offers, and anything that invites people to wander away.</p>
<h2>3. Benefits before features</h2>
<p>Lead with the outcome the visitor wants, then explain how you deliver it. Features support the decision; benefits create it.</p>
<h2>4. Proof</h2>
<p>Real testimonials, recognizable client logos, review ratings, and specific results all reduce the risk a visitor feels. Use only proof you can stand behind.</p>
<h2>5. A short, honest form</h2>
<p>Every extra field costs you submissions. Ask only for what you need to take the next step, and say what will happen after the form is sent.</p>
<h2>6. Speed and mobile layout</h2>
<p>A large share of paid traffic arrives on a phone. Check that the page loads quickly on a mobile connection, that buttons are easy to tap, and that the form is comfortable to complete with a thumb.</p>
<h2>7. Answers to the obvious objections</h2>
<p>Price, timing, commitment, and trust are the usual blockers. A brief FAQ near the call to action handles these doubts before they end the visit.</p>
<h2>Then test</h2>
<p>Change one thing at a time, starting with the headline and the offer, and let the data decide. Small, steady improvements to a landing page often outperform a bigger advertising budget.</p>
HTML,
            ],
            [
                'slug' => 'content-calendar-you-will-stick-to',
                'title' => 'How to Build a Content Calendar You Will Actually Stick To',
                'category' => 'Content Marketing',
                'image' => '/assets/img/blog/blog-1-4.jpg',
                'published_at' => '2026-09-07',
                'excerpt' => 'Consistency beats bursts of inspiration. A realistic content calendar starts with goals and capacity, not with a long list of topics.',
                'content' => <<<'HTML'
<p>Most content plans collapse within two months. They start with an ambitious schedule, run into real workloads, and quietly stop. A calendar that survives is built around what your team can sustain and what your audience needs.</p>
<h2>Start with goals, not topics</h2>
<p>Decide what content should achieve: more organic traffic, better-qualified leads, or support for the sales team. The goal determines the format and the topics, and it gives you a way to judge whether the work is paying off.</p>
<h2>Choose three or four content pillars</h2>
<p>Pillars are the broad themes you want to be known for. For a marketing agency, that might be search, paid media, and conversion. Every piece should fit under a pillar. If it does not, it probably does not belong on the calendar.</p>
<h2>Plan from real questions</h2>
<p>The best topics come from your customers. Collect the questions that come up in sales calls, support tickets, and search queries. Content that answers a real question earns attention far more easily than content invented to fill a slot.</p>
<h2>Set a pace you can keep</h2>
<p>One strong article every two weeks, published reliably, will outperform a daily schedule that lasts a month. Be honest about research, writing, review, and design time before you commit to a frequency.</p>
<h2>Build a simple workflow</h2>
<ul>
<li>Give each piece an owner and a due date for the draft, the review, and publication.</li>
<li>Keep a small backlog of approved ideas so a busy week does not break the schedule.</li>
<li>Plan how each article will be reused in email, social posts, and sales material.</li>
</ul>
<h2>Review every quarter</h2>
<p>Look at which pieces brought traffic and enquiries, update the ones that are slipping, and adjust the plan. A content calendar is a working document, and the teams that treat it that way are the ones still publishing a year later.</p>
HTML,
            ],
            [
                'slug' => 'social-media-metrics-that-matter',
                'title' => 'The Social Media Metrics That Actually Matter',
                'category' => 'Social Media',
                'image' => '/assets/img/blog/blog-1-5.jpg',
                'published_at' => '2026-08-31',
                'excerpt' => 'Follower counts feel good and explain very little. These are the numbers that show whether social media is doing real work for your business.',
                'content' => <<<'HTML'
<p>Social platforms offer dozens of numbers, and most reports include too many of them. The useful question is not "what can we measure?" but "what would change a decision?" Group your metrics by the job they do.</p>
<h2>Reach: are the right people seeing you?</h2>
<p>Impressions and reach tell you how far content travels. On their own they are vanity numbers, but they matter as the top of the funnel. Watch the trend, and pay attention to who the audience is rather than only how large it is.</p>
<h2>Engagement: does the content earn a reaction?</h2>
<p>Engagement rate, saves, shares, and comments show whether people find the content worth their time. Shares and saves are the stronger signals, because they mean someone found the post useful enough to keep or pass on.</p>
<h2>Traffic: do people take the next step?</h2>
<p>Link clicks and click-through rate connect social activity to your website. Tag your links so analytics can show exactly which posts and platforms send visitors, and what those visitors do when they arrive.</p>
<h2>Conversion: does it lead to business?</h2>
<p>Leads, sign-ups, and sales that began with a social visit are the numbers leadership cares about. For paid social, track cost per result alongside the quality of the leads, not just the volume.</p>
<h2>What to report</h2>
<ul>
<li>Pick one or two metrics for each stage instead of reporting everything.</li>
<li>Compare against your own previous periods, not against unrelated benchmarks.</li>
<li>Add a sentence of interpretation: what happened, why, and what you will do next.</li>
</ul>
<p>A short report that leads to a decision is worth more than a long one that nobody reads.</p>
HTML,
            ],
            [
                'slug' => 'email-automation-flows-every-store-needs',
                'title' => 'Five Email Automation Flows Every Online Store Needs',
                'category' => 'Email Marketing',
                'image' => '/assets/img/blog/blog-1-6.jpg',
                'published_at' => '2026-08-24',
                'excerpt' => 'Automated emails work while you sleep. Set up these five flows once and they keep bringing customers back without adding to your weekly workload.',
                'content' => <<<'HTML'
<p>Campaign emails take effort every time you send one. Automated flows are different: you build them once, and they send the right message at the right moment for as long as they run. If you sell online, these five are the foundation.</p>
<h2>1. Welcome series</h2>
<p>A new subscriber is at their most interested on day one. Use two or three emails to introduce the brand, explain what makes you different, and point to your best-selling products or most useful content.</p>
<h2>2. Abandoned cart</h2>
<p>People leave carts for ordinary reasons: a distraction, a question about delivery, a wish to compare. A polite reminder with the items they chose, sent within a few hours, recovers a meaningful share of those orders.</p>
<h2>3. Post-purchase</h2>
<p>The sale is the start of the relationship. Confirm the order, set expectations for delivery, share tips for getting the most from the product, and ask for a review once it has arrived.</p>
<h2>4. Win-back</h2>
<p>When a customer has not bought or opened an email for a while, send a short sequence that reminds them what is new. If they still do not respond, stop emailing them. A smaller, engaged list performs better and protects your deliverability.</p>
<h2>5. Browse follow-up</h2>
<p>If a known subscriber views a product several times without buying, a helpful follow-up with details, reviews, or related items can answer the hesitation.</p>
<h2>Getting the details right</h2>
<ul>
<li>Segment where you can: first-time and repeat buyers deserve different messages.</li>
<li>Keep each email focused on one action.</li>
<li>Review performance every few months and refresh the copy and offers.</li>
<li>Always make it easy to unsubscribe and respect consent rules in the regions you sell to.</li>
</ul>
<p>Flows rarely look exciting, but they are often the most dependable revenue in an email program.</p>
HTML,
            ],
            [
                'slug' => 'brand-messaging-framework',
                'title' => 'A Simple Brand Messaging Framework for Small Teams',
                'category' => 'Branding',
                'image' => '/assets/img/blog/blog-2-1.jpg',
                'published_at' => '2026-08-17',
                'excerpt' => 'When everyone describes the company differently, customers notice. A one-page messaging framework keeps your website, ads, and sales conversations consistent.',
                'content' => <<<'HTML'
<p>Ask five people in a small company what the business does and you will often hear five different answers. That inconsistency shows up on the website, in ads, and in sales calls. A messaging framework fixes it, and it does not need to be a long document.</p>
<h2>1. Define who you are for</h2>
<p>Describe your best customer in plain terms: the kind of business or person, the situation they are in, and the problem that makes them look for help. Being specific does not shrink your market. It makes your message land.</p>
<h2>2. Name the problem in their words</h2>
<p>Write down how customers describe the problem, not how you would describe it internally. The phrases they use in emails and calls belong in your headlines.</p>
<h2>3. State your value proposition</h2>
<p>In one or two sentences, say what you do, who it is for, and the outcome it creates. If it could describe any competitor, keep working.</p>
<h2>4. Choose three supporting messages</h2>
<p>These are the main reasons to believe the promise. For each one, list the proof: a process, a guarantee, an example, or a result.</p>
<h2>5. Set the tone of voice</h2>
<p>Pick a few words that describe how you sound, such as clear, direct, and friendly, and give a short example of what that means in practice.</p>
<h2>Put it to work</h2>
<p>Keep the framework to a single page and share it with everyone who writes or speaks for the company. Use it to brief designers and writers, to check new pages before they go live, and to settle debates about wording. Revisit it once or twice a year as you learn more about your customers.</p>
HTML,
            ],
            [
                'slug' => 'how-to-read-a-google-analytics-report',
                'title' => 'How to Read a Google Analytics Report Without Getting Lost',
                'category' => 'Analytics',
                'image' => '/assets/img/blog/blog-2-2.jpg',
                'published_at' => '2026-08-10',
                'excerpt' => 'Analytics tools show everything at once. Four questions cut through the noise and tell you what is working, what is not, and what to do next.',
                'content' => <<<'HTML'
<p>Open an analytics dashboard and you are met with charts for everything. It is easy to spend an hour looking and leave without a conclusion. A better approach is to go in with a small set of questions and find the report that answers each one.</p>
<h2>Question 1: Where do visitors come from?</h2>
<p>The acquisition reports break traffic into channels such as organic search, paid search, social, email, and direct. Look at the trend for each channel and note which ones bring engaged visitors rather than just visits.</p>
<h2>Question 2: What do they do on the site?</h2>
<p>The pages report shows which pages people land on and view most. Engagement rate and average engagement time indicate whether the content holds attention. A popular page with weak engagement is a candidate for improvement.</p>
<h2>Question 3: Do they take the action that matters?</h2>
<p>Set up key events for the actions that matter to your business, such as a form submission, a purchase, or a booked call. Without them, you are measuring activity instead of results.</p>
<h2>Question 4: Which sources drive those actions?</h2>
<p>Combine the first and third questions. A channel that sends less traffic but more conversions deserves more of your budget than a busy channel that converts poorly.</p>
<h2>Habits that keep the data useful</h2>
<ul>
<li>Compare with the previous period and the same period last year to account for seasonality.</li>
<li>Tag campaign links consistently so traffic is attributed to the right source.</li>
<li>Filter out internal traffic so your own team does not distort the numbers.</li>
<li>Write down one finding and one action after every review.</li>
</ul>
<p>Analytics is only valuable when it changes what you do. Four clear questions, asked every month, will take you further than a dashboard nobody opens.</p>
HTML,
            ],
            [
                'slug' => 'local-seo-basics',
                'title' => 'Local SEO Basics: How to Show Up When Nearby Customers Search',
                'category' => 'SEO',
                'image' => '/assets/img/blog/blog-2-3.jpg',
                'published_at' => '2026-08-03',
                'excerpt' => 'When someone searches for a service near them, a handful of businesses get the call. These fundamentals put you in the running.',
                'content' => <<<'HTML'
<p>Searches with local intent, such as a service followed by a city name or "near me", often end in a phone call or a visit the same day. Local SEO is the work of making sure your business appears, and looks trustworthy, at that moment.</p>
<h2>Claim and complete your Google Business Profile</h2>
<p>This is the single most important step. Choose the most accurate primary category, add your services, opening hours, photos, and a clear description. Keep it current: an out-of-date profile sends customers to a closed door.</p>
<h2>Keep your name, address, and phone number consistent</h2>
<p>Your business details should match exactly across your website, your profile, and any directories that list you. Conflicting information makes search engines less confident about showing you.</p>
<h2>Earn and answer reviews</h2>
<p>Ask satisfied customers for a review soon after the job is done, and make it easy with a direct link. Reply to reviews, including the critical ones, calmly and helpfully. Never buy or invent reviews: it breaks platform rules and customer trust.</p>
<h2>Create useful local pages</h2>
<p>If you serve several areas, give each one a page with genuinely specific content: the services offered there, relevant examples, and local details. Thin pages that only swap the city name do not help.</p>
<h2>Cover the on-site basics</h2>
<ul>
<li>Include your location naturally in titles, headings, and page copy.</li>
<li>Add local business structured data to your contact page.</li>
<li>Make sure the site is fast and easy to use on a phone.</li>
<li>Show your phone number and address clearly on every page.</li>
</ul>
<h2>Measure what happens</h2>
<p>Track calls, direction requests, and form enquiries from local search. Those numbers, not rankings alone, tell you whether local SEO is bringing customers through the door.</p>
HTML,
            ],
        ];
    }
}
