/*
 | Marketing copy for pages that have no admin-managed data source.
 | Services, blog posts, testimonials, team members, SEO tags, and "additional
 | content" all come from the API and are edited in the admin panel.
 */

const img = (path) => `/assets/img/${path}`;

export const images = {
    hero: img('hero/hero-team-strategy-meeting.webp'),
    discussion: img('hero/hero-marketing-discussion.webp'),
    campaign: img('hero/hero-campaign-success.webp'),
    analytics: img('hero/hero-seo-analytics-dashboard.webp'),
    about: img('about/about-team-collaboration.webp'),
    strategy: img('site/choose-brand-strategy-session.webp'),
};

/** Facts about how we work — deliberately not unverifiable "clients served" style counters. */
export const stats = (serviceCount) => [
    {
        value: String(serviceCount || 7),
        label: 'Connected Services',
        text: 'Search, paid media, social, content, email, branding, and web — planned as one strategy instead of separate projects.',
    },
    {
        value: '4',
        label: 'Stage Process',
        text: 'Discovery, strategy, launch, and reporting. You always know which stage you are in and what happens next.',
    },
    {
        value: '1 day',
        label: 'Response Time',
        text: 'Every enquiry gets a reply from a real person within one business day.',
    },
    {
        value: '100%',
        label: 'Remote-First',
        text: 'A distributed team that works with clients wherever they are based, across time zones.',
    },
];

export const processSteps = [
    {
        title: 'Discovery & Market Research',
        text: 'We study your audience, competitors, and current performance to find where the real growth opportunity is — before any budget is committed.',
        image: img('hero/hero-marketing-discussion.webp'),
    },
    {
        title: 'Strategy & Campaign Planning',
        text: 'Research becomes a concrete plan: channels, messaging, budget, timeline, and the specific numbers we will use to judge success.',
        image: img('site/choose-brand-strategy-session.webp'),
    },
    {
        title: 'Launch & Optimization',
        text: 'We launch, then keep testing creative, targeting, and landing pages as real data comes in, shifting budget toward what performs.',
        image: img('hero/hero-campaign-success.webp'),
    },
    {
        title: 'Reporting & Growth',
        text: 'Each month you get a plain-language report: what happened, why, and what we will do next. Then we reinvest in what is working.',
        image: img('hero/hero-seo-analytics-dashboard.webp'),
    },
];

export const reasons = [
    {
        icon: 'Target',
        title: 'Strategy Before Tactics',
        text: 'Every engagement starts from your commercial goal and works backwards to channels, not the other way round.',
    },
    {
        icon: 'CalendarCheck',
        title: 'Reliable Delivery',
        text: 'Clear scope, agreed milestones, and one point of contact keep work on schedule from kickoff to launch.',
    },
    {
        icon: 'LineChart',
        title: 'Honest Measurement',
        text: 'We set up tracking first, so decisions are based on leads and revenue rather than impressions and guesswork.',
    },
    {
        icon: 'LifeBuoy',
        title: 'Long-Term Support',
        text: 'We stay involved after launch to refine, optimize, and keep performance moving in the right direction.',
    },
];

export const aboutValues = [
    {
        icon: 'Users',
        title: 'Specialists, Not Generalists',
        text: 'Search, paid media, content, design, and development are each handled by someone who does that work every day.',
    },
    {
        icon: 'Lightbulb',
        title: 'Clear Communication',
        text: 'No jargon and no surprises. You get straight answers, regular updates, and reasons behind every recommendation.',
    },
    {
        icon: 'Cpu',
        title: 'Modern Tooling',
        text: 'Current analytics, automation, and development tools keep campaigns measurable and websites fast.',
    },
    {
        icon: 'Headset',
        title: 'A Real Partnership',
        text: 'We work as an extension of your team, share what we learn, and adapt the plan as your business changes.',
    },
];

/** How the remote team is organised — shown on the Team page alongside admin-managed members. */
export const disciplines = [
    { icon: 'Target', title: 'Strategy', text: 'Research, positioning, channel planning, and budget allocation.' },
    { icon: 'LineChart', title: 'Search & Paid Media', text: 'Technical SEO, content optimization, and search and social advertising.' },
    { icon: 'Lightbulb', title: 'Content & Creative', text: 'Articles, landing pages, email, ad creative, and brand design.' },
    { icon: 'Layers', title: 'Web & Analytics', text: 'Fast, accessible websites with tracking and reporting built in.' },
];

/**
 * Engagement playbooks: how we typically approach common situations. These
 * describe our method, not results claimed for a named client.
 */
export const projects = [
    {
        slug: 'ecommerce-growth',
        category: 'E-commerce',
        title: 'Online Store Growth',
        text: 'For stores with traffic but disappointing sales: improve product discovery and checkout, then scale the channels that convert.',
        image: img('project/project-1-1.jpg'),
        situation:
            'The store gets visitors, but too few of them buy. Advertising costs are rising, and it is unclear which channels actually produce profitable orders.',
        approach: [
            'Audit analytics and the checkout funnel to find where shoppers drop off.',
            'Fix product page content, site speed, and mobile checkout friction first.',
            'Restructure shopping and search campaigns around margin, not just revenue.',
            'Add abandoned-cart and post-purchase email flows to lift repeat orders.',
        ],
        deliverables: ['Conversion audit', 'Product page and checkout improvements', 'Shopping and search campaigns', 'Lifecycle email flows'],
        measures: ['Conversion rate', 'Return on ad spend', 'Average order value', 'Repeat purchase rate'],
    },
    {
        slug: 'saas-lead-generation',
        category: 'B2B & SaaS',
        title: 'SaaS Lead Generation',
        text: 'For software companies that need a steady flow of qualified demos and trials instead of occasional spikes.',
        image: img('project/project-1-2.jpg'),
        situation:
            'Sign-ups depend on launches and referrals. The website explains features well but does little to turn interested visitors into trials or demo requests.',
        approach: [
            'Clarify positioning and the single action each page should drive.',
            'Build landing pages matched to specific use cases and search intent.',
            'Publish content that answers the questions buyers ask before a demo.',
            'Run targeted search and LinkedIn campaigns, and nurture leads by email.',
        ],
        deliverables: ['Messaging framework', 'Use-case landing pages', 'Content plan', 'Paid campaigns and nurture sequence'],
        measures: ['Qualified demo requests', 'Trial sign-ups', 'Cost per qualified lead', 'Trial-to-paid rate'],
    },
    {
        slug: 'local-service-visibility',
        category: 'Local Business',
        title: 'Local Service Visibility',
        text: 'For service businesses that want to be found — and chosen — when nearby customers search.',
        image: img('project/project-1-3.jpg'),
        situation:
            'Competitors appear in the map results and get the calls. The business has good word of mouth but a thin online presence and few reviews.',
        approach: [
            'Complete and optimize the Google Business Profile and local listings.',
            'Create service and location pages with genuinely specific content.',
            'Set up a simple, compliant process for requesting customer reviews.',
            'Run tightly targeted local search ads with call tracking.',
        ],
        deliverables: ['Business profile optimization', 'Service and location pages', 'Review request process', 'Local search campaigns'],
        measures: ['Calls and direction requests', 'Form enquiries', 'Map visibility', 'Cost per booked job'],
    },
    {
        slug: 'lifecycle-email',
        category: 'Email Marketing',
        title: 'Lifecycle Email Program',
        text: 'For brands with a growing list that is only used for occasional newsletters and promotions.',
        image: img('project/project-2-1.jpg'),
        situation:
            'Most revenue comes from first-time buyers. Email is sent irregularly, to everyone at once, and unsubscribes climb after each promotion.',
        approach: [
            'Clean the list and segment by purchase history and engagement.',
            'Build welcome, abandoned-cart, post-purchase, and win-back flows.',
            'Plan a campaign calendar that balances value and promotion.',
            'Test subject lines, timing, and offers, and monitor deliverability.',
        ],
        deliverables: ['List audit and segmentation', 'Automated flows', 'Campaign calendar', 'Templates and reporting'],
        measures: ['Revenue from email', 'Repeat purchase rate', 'Click rate', 'Unsubscribe and complaint rates'],
    },
    {
        slug: 'brand-refresh',
        category: 'Branding & Content',
        title: 'Brand & Content Refresh',
        text: 'For companies whose look and message no longer match the business they have become.',
        image: img('project/project-2-2.jpg'),
        situation:
            'The website, sales material, and social channels all describe the company differently. New visitors struggle to understand what it does and why it is different.',
        approach: [
            'Interview stakeholders and customers to define positioning.',
            'Write a one-page messaging framework and tone-of-voice guide.',
            'Refresh the visual identity and core website pages.',
            'Create a content plan that expresses the brand consistently.',
        ],
        deliverables: ['Messaging framework', 'Visual identity update', 'Rewritten core pages', 'Content guidelines'],
        measures: ['Engagement on key pages', 'Branded search interest', 'Enquiry quality', 'Sales-team feedback'],
    },
    {
        slug: 'social-launch',
        category: 'Social Media',
        title: 'Social Launch Campaign',
        text: 'For new products or brands that need awareness quickly and a community that lasts beyond launch week.',
        image: img('project/project-2-3.jpg'),
        situation:
            'A launch date is fixed, the audience is small, and there is no established rhythm for content or community management.',
        approach: [
            'Choose the one or two platforms where the audience already spends time.',
            'Plan pre-launch, launch, and follow-up content with a clear story.',
            'Support organic content with paid social aimed at defined audiences.',
            'Tag every link so results can be traced back to posts and ads.',
        ],
        deliverables: ['Platform strategy', 'Launch content calendar', 'Paid social campaigns', 'Community management guidelines'],
        measures: ['Reach among target audience', 'Engagement rate', 'Site visits and sign-ups', 'Cost per result'],
    },
];

export const toolStack = [
    { tab: 'SEO', items: ['Google Search Console', 'Ahrefs', 'Semrush', 'Screaming Frog', 'Schema Markup', 'PageSpeed Insights'] },
    { tab: 'Paid Media', items: ['Google Ads', 'Meta Ads', 'LinkedIn Ads', 'Microsoft Ads', 'TikTok Ads', 'YouTube Ads'] },
    { tab: 'Social', items: ['Instagram', 'Facebook', 'LinkedIn', 'TikTok', 'YouTube', 'X (Twitter)'] },
    { tab: 'Analytics', items: ['Google Analytics 4', 'Tag Manager', 'Looker Studio', 'Hotjar', 'Call Tracking', 'A/B Testing'] },
    { tab: 'Email', items: ['Klaviyo', 'Mailchimp', 'HubSpot', 'ActiveCampaign', 'Lifecycle Flows', 'List Segmentation'] },
    { tab: 'Web', items: ['Laravel', 'React', 'WordPress', 'Shopify', 'Tailwind CSS', 'Headless CMS'] },
];

export const faqGroups = [
    {
        group: 'Working with us',
        items: [
            {
                question: 'What does Clickvora Digital specialize in?',
                answer: 'We are a remote-first digital marketing agency. Our work covers SEO, pay-per-click advertising, social media marketing, content marketing, branding, email marketing, and web development — planned together so every channel supports the same commercial goal.',
            },
            {
                question: 'Who do you typically work with?',
                answer: 'Growing businesses that want marketing tied to measurable outcomes: online stores, software and B2B companies, and local service businesses. We scope each engagement around your goals and budget rather than a fixed package size.',
            },
            {
                question: 'What does your process look like?',
                answer: 'Every engagement moves through four stages: discovery and market research, strategy and campaign planning, launch and optimization, and reporting and growth. You get a clear plan, with agreed success measures, before anything goes live.',
            },
            {
                question: 'How involved will our team need to be?',
                answer: 'Most at the start, when we need access to your analytics and ad accounts and input on goals, customers, and brand. After launch, a short regular check-in and timely feedback on creative is usually enough.',
            },
        ],
    },
    {
        group: 'Results and reporting',
        items: [
            {
                question: 'How long does it take to see results?',
                answer: 'It depends on the channel. Paid campaigns produce data within days of launch, while SEO and content typically build over several months. During planning we set realistic milestones for each channel so you know what to expect and when.',
            },
            {
                question: 'Can you guarantee rankings or a specific return?',
                answer: 'No, and you should be cautious of anyone who does. Search engines and ad platforms change constantly and no agency controls them. What we commit to is a sound strategy, consistent execution, and transparent reporting on the numbers that matter.',
            },
            {
                question: 'How do you report on performance?',
                answer: 'You receive a plain-language report every month covering what happened, why, and what we will do next, focused on leads, sales, and cost rather than vanity metrics. You also keep full access to your own analytics and ad accounts.',
            },
        ],
    },
    {
        group: 'Pricing and getting started',
        items: [
            {
                question: 'How does pricing work?',
                answer: 'We offer monthly plans based on how many channels we manage for you. Advertising spend is paid directly to the ad platforms and is separate from our fee. One-off projects, such as a website build or an audit, are quoted individually.',
            },
            {
                question: 'Is there a long-term contract?',
                answer: 'You can work with us month to month, or choose a 12-month plan at a lower monthly rate. Either way, your accounts, data, and creative assets remain yours.',
            },
            {
                question: 'How do I get started?',
                answer: 'Send us a message through the contact form with a few details about your business and goals. We will reply within one business day to arrange a discovery call.',
            },
        ],
    },
];

export const faqs = faqGroups.flatMap((group) => group.items);

export const contactReasons = [
    { icon: 'Zap', title: 'Quick Response', text: 'A reply from a real person within one business day.' },
    { icon: 'Target', title: 'Strategy-Led', text: 'Every campaign starts from a plan built around measurable goals.' },
    { icon: 'LineChart', title: 'Clear Reporting', text: 'Plain-language performance reports you can use in real decisions.' },
];

export const pricing = {
    periods: [
        { key: 'annual', label: '12-month plan', note: 'Lower monthly rate' },
        { key: 'monthly', label: 'Month to month', note: 'Cancel anytime' },
    ],
    plans: [
        {
            name: 'Starter',
            summary: 'One channel, done properly. Ideal for testing what works.',
            price: { annual: 120, monthly: 140 },
            featured: false,
            features: [
                'One managed channel (SEO, PPC, or social)',
                'Initial audit and 90-day plan',
                'Tracking and analytics setup',
                'Monthly performance report',
                'Email support',
            ],
        },
        {
            name: 'Growth',
            summary: 'Multiple channels working together toward one goal.',
            price: { annual: 180, monthly: 200 },
            featured: true,
            features: [
                'Up to three managed channels',
                'Everything in Starter',
                'Landing page recommendations and testing',
                'Content plan with monthly articles',
                'Fortnightly check-in call',
            ],
        },
        {
            name: 'Scale',
            summary: 'A full marketing team for brands ready to accelerate.',
            price: { annual: 250, monthly: 270 },
            featured: false,
            features: [
                'All channels, fully managed',
                'Everything in Growth',
                'Email automation and lifecycle flows',
                'Conversion rate optimization',
                'Weekly check-in and priority support',
            ],
        },
    ],
    notes: [
        'Advertising spend is paid directly to the ad platforms and is not included in plan fees.',
        'Website builds, audits, and other one-off projects are quoted separately.',
    ],
};
