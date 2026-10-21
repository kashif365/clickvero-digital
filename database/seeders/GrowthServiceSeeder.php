<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Services added for the grouped Services mega menu. Unlike ServiceSeeder this
 * only creates missing services, so it is safe to run against a live database
 * without overwriting anything edited in the admin panel. (E-Commerce Web
 * Development and Web Application Development moved to WebDevelopmentContentSeeder.)
 *
 *     php artisan db:seed --class=GrowthServiceSeeder
 */
class GrowthServiceSeeder extends Seeder
{
    public function run(): void
    {
        $next = (int) Service::max('sort_order');

        foreach ($this->services() as $service) {
            Service::firstOrCreate(['slug' => $service['slug']], $service + ['sort_order' => ++$next]);
        }
    }

    private function services(): array
    {
        return [
            [
                'slug' => 'ecommerce-marketing',
                'name' => 'eCommerce Marketing',
                'short_description' => 'Shopify and ecommerce marketing built around your products, audience, margins, and growth goals.',
                'seo_title' => 'eCommerce Marketing Agency | Shopify Marketing Services',
                'seo_description' => 'eCommerce marketing that improves product discovery, conversion rate, and retention — from a Shopify marketing agency focused on profitable growth.',
                'keywords' => 'ecommerce marketing, ecommerce agency, Shopify marketing agency, online store marketing, cart abandonment, customer retention',
                'description' => <<<'HTML'
                    <h2>Marketing Built for Online Stores</h2>
                    <p>Online stores face challenges that are unique to selling online: intense competition, customer acquisition costs, product discovery, conversion rate, customer retention, and cart abandonment. Each one needs its own answer.</p>
                    <p>Whether you're looking for a Shopify marketing agency or an ecommerce agency that can build a strategy around your products, audience, margins, and growth goals, we help you along the way.</p>

                    <h2>Challenges We Help Online Stores Overcome</h2>
                    <ul>
                        <li><strong>Competition</strong> — stand out in crowded categories and marketplaces.</li>
                        <li><strong>Customer acquisition</strong> — reach buyers profitably across search, shopping, and social.</li>
                        <li><strong>Product discovery</strong> — help shoppers find the right product quickly.</li>
                        <li><strong>Conversion rate</strong> — remove friction from product pages and checkout.</li>
                        <li><strong>Customer retention</strong> — turn first-time buyers into repeat customers.</li>
                        <li><strong>Cart abandonment</strong> — recover sales with timely, relevant follow-up.</li>
                    </ul>

                    <h2>What's Included</h2>
                    <h3>Ecommerce SEO</h3>
                    <p>Product and collection page optimization so your store is found for high-intent searches.</p>
                    <h3>Paid Shopping &amp; Social</h3>
                    <p>Shopping, search, and paid social campaigns structured around margin, not just revenue.</p>
                    <h3>Remarketing &amp; Email</h3>
                    <p>Abandoned-cart, post-purchase, and win-back flows that lift repeat orders.</p>
                    <h3>Conversion Optimization</h3>
                    <p>Product page, site speed, and checkout improvements that turn more visitors into buyers.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'Can you help Shopify stores with marketing?', 'answer' => "Yes. A Shopify business can benefit from a combination of eCommerce SEO, paid advertising, content, social media, product-page optimization, remarketing, and conversion-focused strategies. The appropriate mix depends on the store's products, customers, market, and growth objectives."],
                    ['question' => 'Do you work with stores on platforms other than Shopify?', 'answer' => 'Yes. Our ecommerce marketing approach works for WooCommerce, BigCommerce, and custom-built stores as well.'],
                ],
            ],
            [
                'slug' => 'shopify-seo',
                'name' => 'Shopify SEO',
                'short_description' => 'Shopify SEO that improves store rankings, drives qualified traffic, and increases sales.',
                'seo_title' => 'Shopify SEO Agency | Shopify Store Optimization Services',
                'seo_description' => 'Our Shopify SEO agency improves product and collection page rankings, technical Shopify SEO, and content strategy to grow store traffic and sales.',
                'keywords' => 'Shopify SEO, Shopify SEO agency, Shopify store optimization, ecommerce SEO, collection page SEO, product page SEO',
                'description' => <<<'HTML'
                    <h2>Visibility for Your Shopify Store</h2>
                    <p>Your Shopify eCommerce store isn't going to succeed with amazing products alone. You need visibility. Our Shopify SEO agency experts help eCommerce businesses improve their rankings, drive more traffic, and increase sales.</p>

                    <h2>Shopify SEO Includes</h2>
                    <ul>
                        <li><strong>Product page optimization</strong> — titles, descriptions, and structured data that match how shoppers search.</li>
                        <li><strong>Collection page SEO</strong> — category pages built to rank for broader commercial searches.</li>
                        <li><strong>Technical Shopify SEO</strong> — duplicate URLs, site speed, indexation, and theme issues.</li>
                        <li><strong>Content strategy</strong> — buying guides and articles that answer pre-purchase questions.</li>
                        <li><strong>Link building</strong> — ethical authority building for your store.</li>
                        <li><strong>Keyword optimization</strong> — mapping the right keywords to the right pages.</li>
                    </ul>

                    <h2>Why It Matters</h2>
                    <p>We drive traffic to Shopify stores from people who are looking for the products you offer — visitors who are far more likely to buy than untargeted traffic.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'Can you optimize Shopify stores?', 'answer' => 'Absolutely. Our Shopify SEO agency specializes in improving Shopify store visibility, rankings, traffic, and conversions.'],
                    ['question' => 'How long does Shopify SEO take to show results?', 'answer' => 'SEO typically takes three to six months to generate noticeable results, depending on competition, store authority, and the number of products.'],
                ],
            ],
            [
                'slug' => 'growth-marketing',
                'name' => 'Growth Marketing',
                'short_description' => 'Data-driven growth marketing that blends acquisition, conversion, retention, and optimization.',
                'seo_title' => 'Growth Marketing Agency | Data-Driven Growth Strategy',
                'seo_description' => 'Growth marketing that continuously tests, measures, and improves your customer journey across acquisition, conversion, and retention.',
                'keywords' => 'growth marketing, growth marketing agency, conversion optimization, customer acquisition, retention marketing, marketing experimentation',
                'description' => <<<'HTML'
                    <h2>Growth Is a Series of Better Decisions</h2>
                    <p>Growth doesn't happen overnight — it's usually the result of a series of campaigns. It comes from continuously discovering opportunities, testing assumptions, analysing data, and improving the customer journey. Our growth marketing method blends acquisition, conversion, retention, and optimization.</p>

                    <h2>Questions Growth Marketing Answers</h2>
                    <ul>
                        <li>Which channels generate qualified prospects?</li>
                        <li>Which pages produce the strongest conversions?</li>
                        <li>Where are potential customers dropping off?</li>
                        <li>Which audiences respond to your offer?</li>
                        <li>Which campaigns produce sustainable returns?</li>
                        <li>What should be tested next?</li>
                    </ul>

                    <h2>How We Work</h2>
                    <h3>1. Measure</h3>
                    <p>We set up tracking first so every decision is based on leads and revenue, not impressions.</p>
                    <h3>2. Prioritize</h3>
                    <p>Opportunities are ranked by expected impact and effort, so the biggest wins come first.</p>
                    <h3>3. Test</h3>
                    <p>We run focused experiments on channels, audiences, offers, and landing pages.</p>
                    <h3>4. Scale</h3>
                    <p>What works gets more budget; what doesn't gets cut. This approach relies on data, enabling decisions that grow with your business.</p>
                    HTML,
                'faqs' => [
                    ['question' => 'How is growth marketing different from traditional marketing?', 'answer' => 'Traditional marketing often focuses on a single campaign or channel. Growth marketing covers the whole customer journey and improves it continuously through testing and data.'],
                    ['question' => 'How long does digital marketing take to produce results?', 'answer' => 'The timeframe varies by channel, market, competition, budget, website condition, and starting point. Paid campaigns can generate traffic quickly, while SEO and content strategies generally require consistent optimization and time.'],
                ],
            ],
        ];
    }
}
