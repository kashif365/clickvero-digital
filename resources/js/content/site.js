/*
 | Marketing copy for pages that have no admin-managed data source.
 | Services, blog posts, testimonials, team members, SEO tags, and "additional
 | content" all come from the API and are edited in the admin panel.
 */

const img = (path) => `/assets/img/${path}`;

const BRAND = 'Clickvora Digital';

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
        value: '5',
        label: 'Stage Process',
        text: 'Discovery, strategy, implementation, optimization, and scaling. You always know which stage you are in and what happens next.',
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
        title: 'Discovery & Research',
        text: 'We begin by understanding your business, market, customers, competitors, current performance, and growth objectives.',
        image: img('hero/hero-marketing-discussion.webp'),
    },
    {
        title: 'Strategy Development',
        text: 'Our experts identify opportunities and create a customized, prioritized roadmap based on data, market analysis, and your business goals.',
        image: img('site/choose-brand-strategy-session.webp'),
    },
    {
        title: 'Implementation',
        text: 'Our team turns the strategy into campaigns, content, optimization, creative assets, and marketing activities across SEO, PPC, content marketing, and web development channels.',
        image: img('about/about-team-collaboration.webp'),
    },
    {
        title: 'Measurement & Optimization',
        text: 'We monitor meaningful performance indicators and continuously refine campaigns, content, targeting, conversion paths, and strategy to maximize ROI. Marketing is never truly finished.',
        image: img('hero/hero-seo-analytics-dashboard.webp'),
    },
    {
        title: 'Scaling Growth',
        text: 'Successful campaigns are expanded to generate greater traffic, leads, and revenue.',
        image: img('hero/hero-campaign-success.webp'),
    },
];

export const whyChoose = {
    text: `The digital marketplace is continually changing. Search engines improve their algorithms, users change their behaviour, and competition gets more intense. That's why having a trusted partner who knows how to stay one step ahead is vital. ${BRAND} blends creativity, technology, analysis, and marketing know-how — the right mix of people and resources to help businesses win their markets online.`,
    reasons: [
        {
            icon: 'Target',
            title: 'Strategy Before Execution',
            text: "We don't shoot in the dark and hope to get lucky. We begin by gaining a clear understanding of your market, audience, competitors, offer, existing digital footprint, and business goals.",
        },
        {
            icon: 'LineChart',
            title: 'Data-Informed Decisions',
            text: "Marketing should get better over time. Performance data shows what's working and what needs improvement, and points to future opportunities.",
        },
        {
            icon: 'Network',
            title: 'One Connected Marketing Ecosystem',
            text: 'SEO, paid advertising, content, social media, and website conversion must complement one another. We develop strategies that let these channels work together instead of in silos.',
        },
        {
            icon: 'MousePointerClick',
            title: 'Conversion-Focused Thinking',
            text: 'Traffic is good for business — action is essential. Our strategies cover the whole journey from discovery, to consideration, to conversion.',
        },
        {
            icon: 'TrendingUp',
            title: 'Scalable Marketing',
            text: 'Your marketing strategy should adapt as your business changes. From adding more content and new campaigns to boosting SEO visibility and expanding into new markets, your digital infrastructure should be able to power your growth.',
        },
    ],
    differentiators: [
        'Customized Marketing Strategies',
        'Transparent Reporting & Analytics',
        'ROI-Focused Campaigns',
        'Experienced Marketing Specialists',
        'SEO & PPC Experts',
        'Scalable Growth Solutions',
        'Dedicated Client Support',
        'Long-Term Business Success',
    ],
    goal: 'Our goal is clear — to support businesses to grow sustainably with innovative digital marketing solutions.',
};

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

/** The questions shown on the home page; the FAQ page adds the practical groups below. */
const basicsFaqs = [
    {
        question: 'What does a digital marketing agency do?',
        answer: 'A digital marketing agency helps businesses increase online visibility, generate leads, improve search rankings, and grow revenue by promoting their products or services through online channels such as SEO, PPC advertising, social media, content marketing, email marketing, websites, and conversion optimization. The specific strategy depends on the business, audience, market, and growth objectives.',
    },
    {
        question: 'Why should I hire a digital marketing agency in the USA?',
        answer: 'A digital marketing agency can provide specialized expertise across search, advertising, content, social media, analytics, and conversion strategy. For businesses targeting customers in the USA, a dedicated strategy can help align messaging, channels, campaigns, and content with the intended market.',
    },
    {
        question: 'Why should I hire a PPC agency?',
        answer: 'A professional PPC agency manages advertising campaigns, optimizes budgets, improves conversions, and helps businesses achieve better ROI from paid advertising.',
    },
    {
        question: 'How does SEO help a business grow?',
        answer: "SEO can improve a website's visibility for relevant searches. When a business creates technically sound, useful, search-intent-focused content, it can increase opportunities to attract people actively looking for related products, services, or information.",
    },
    {
        question: 'What is GEO in digital marketing?',
        answer: 'GEO, or Generative Engine Optimization, focuses on improving how a brand and its information can be understood and surfaced within AI-powered search and answer experiences. It complements traditional SEO by emphasizing clear information, topical relevance, authoritative content, entities, and direct answers to user questions.',
    },
    {
        question: 'Why is content marketing important?',
        answer: 'Content marketing builds authority, increases organic traffic, improves search rankings, and helps businesses convert visitors into customers.',
    },
    {
        question: 'How do I choose a digital marketing agency?',
        answer: "Consider the agency's relevant experience, services, strategic process, communication, reporting approach, understanding of your market, and ability to connect marketing activity with meaningful business objectives. The right fit depends on your specific requirements rather than a universal agency ranking.",
    },
];

const serviceFaqs = [
    {
        question: `What services does ${BRAND} offer?`,
        answer: `${BRAND} provides digital marketing services including SEO, PPC and performance marketing, social media marketing, content marketing, eCommerce marketing, website marketing strategy, and growth marketing.`,
    },
    {
        question: 'What makes your local SEO agency different?',
        answer: 'We focus on improving local search visibility, Google Business Profile optimization, local citations, and location-based keyword rankings to help businesses attract nearby customers.',
    },
    {
        question: 'Do you provide website building services?',
        answer: 'Yes. We offer complete website building services including design, development, optimization, maintenance, and performance improvements.',
    },
    {
        question: 'Can you optimize Shopify stores?',
        answer: 'Absolutely. Our Shopify SEO agency specializes in improving Shopify store visibility, rankings, traffic, and conversions.',
    },
    {
        question: 'Can you help Shopify stores with marketing?',
        answer: "Yes. A Shopify business can benefit from a combination of eCommerce SEO, paid advertising, content, social media, product-page optimization, remarketing, and conversion-focused strategies. The appropriate mix depends on the store's products, customers, market, and growth objectives.",
    },
    {
        question: 'Do you provide white label marketing services?',
        answer: `Yes. ${BRAND} can support businesses and agencies that require white label marketing services, including campaign, SEO, content, advertising, and related digital marketing capabilities.`,
    },
    {
        question: 'What industries do you work with?',
        answer: 'We work with local businesses, startups, eCommerce brands, healthcare providers, real estate companies, service businesses, and enterprise organizations.',
    },
];

const timingFaqs = [
    {
        question: 'How long does SEO take to show results?',
        answer: 'SEO typically takes three to six months to generate noticeable results, depending on competition, website authority, and industry factors.',
    },
    {
        question: 'How long does digital marketing take to produce results?',
        answer: 'The timeframe varies by channel, market, competition, budget, website condition, and starting point. Paid campaigns can generate traffic quickly, while SEO and content strategies generally require consistent optimization and time to build sustainable search visibility.',
    },
];

const startFaq = {
    question: `How can I get started with ${BRAND}?`,
    answer: 'Start by discussing your business, target audience, current marketing activities, challenges, and growth objectives. From there, a suitable digital marketing strategy can be developed around your priorities.',
};

export const homeFaqs = [...basicsFaqs, ...serviceFaqs, ...timingFaqs, startFaq];

/** Contact and Pricing show this group on its own. */
export const pricingFaqs = [
    {
        question: 'How does pricing work?',
        answer: 'We offer monthly plans based on how many channels we manage for you. Advertising spend is paid directly to the ad platforms and is separate from our fee. One-off projects, such as a website build or an audit, are quoted individually.',
    },
    {
        question: 'Is there a long-term contract?',
        answer: 'You can work with us month to month, or choose a 12-month plan at a lower monthly rate. Either way, your accounts, data, and creative assets remain yours.',
    },
    startFaq,
];

export const faqGroups = [
    { group: 'Digital marketing basics', items: basicsFaqs },
    { group: 'Our services', items: serviceFaqs },
    {
        group: 'Results and reporting',
        items: [
            ...timingFaqs,
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
        group: 'Working with us',
        items: [
            {
                question: 'What does your process look like?',
                answer: 'Every engagement moves through five stages: discovery and research, strategy development, implementation, measurement and optimization, and scaling growth. You get a clear plan, with agreed success measures, before anything goes live.',
            },
            {
                question: 'How involved will our team need to be?',
                answer: 'Most at the start, when we need access to your analytics and ad accounts and input on goals, customers, and brand. After launch, a short regular check-in and timely feedback on creative is usually enough.',
            },
        ],
    },
    { group: 'Pricing and getting started', items: pricingFaqs },
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

/*
 | Home page copy. Sections appear in this order on the page; see pages/Home.jsx.
 */
export const home = {
    hero: {
        eyebrow: 'Digital Marketing Agency in USA',
        title: 'Digital Marketing Agency That Turns Traffic Into',
        accent: 'Revenue',
        text: `Your business doesn't need just any clicks — it needs the kind that bring in money. ${BRAND} is a USA digital marketing agency that helps brands increase their visibility, reach the right target audience, drive leads, and convert digital traffic into measurable business growth.`,
        cta: 'Get Your Free Strategy Consultation',
        formTitle: 'Ready to Scale Your Business?',
        formText: 'Get your free strategy consultation today.',
        formSubmit: 'Get Free Consultation',
    },
    intro: {
        title: 'A USA digital marketing agency that turns',
        accent: 'marketing into growth',
        paragraphs: [
            'With so many businesses having websites these days, companies need more than just a website. They need a results-oriented digital marketing agency that can provide visibility, qualified leads, and sales.',
            'From startups and local businesses to eCommerce stores and established companies, our team designs and executes a marketing plan specific to your business — across SEO, PPC advertising, social media, content marketing, website building, and conversion-focused campaigns — to boost your online visibility and maximize your return on investment (ROI).',
            "We don't rely on intuition. We believe in measurable growth, data-driven decisions, and marketing tactics that deliver real business outcomes. Partner with a digital marketing agency known for driving more traffic, leads, and revenue.",
        ],
    },
    goals: {
        title: 'A Digital Marketing Agency Built Around',
        accent: 'Your Business Goals',
        paragraphs: [
            'No single marketing strategy will work for all businesses. A local service company needs a different strategy than a Shopify store. A SaaS business may need a different acquisition funnel than an eCommerce brand. Growing startups might be looking to raise awareness and acquire customers, while established businesses might want to cut acquisition costs and boost customer lifetime value.',
            `That's why ${BRAND} begins with your business, audience, market, competitors, and goals. We build one cohesive strategy rather than a separate strategy for each channel — across search rankings, paid campaigns, social media, content, website optimization, and performance marketing. The outcome is a marketing ecosystem that draws in the ideal visitors, clearly conveys your worth, and urges visitors to take action.`,
        ],
    },
    audience: {
        title: 'Who We Help',
        text: `${BRAND} partners with companies looking to make their digital presence more strategic and commercially effective. Our approach can support:`,
        items: [
            'Startups and emerging brands',
            'Small and medium-sized businesses',
            'eCommerce companies',
            'Shopify businesses',
            'Professional service providers',
            'Local businesses',
            'Technology and SaaS companies',
            'B2B businesses',
            'Consumer brands',
            'Established companies seeking digital growth',
        ],
        note: 'Agencies and organizations can also use our white label marketing services or white label advertising agency partner solution to complement their existing marketing functions, without compromising their own clients or marketing team.',
    },
    services: {
        title: 'Our Digital Marketing',
        accent: 'Agency Services',
        text: "We are a full-service digital marketing agency, offering a range of services that help you attract, engage, and convert customers. Whether it's search engine optimization or paid advertising campaigns, we design marketing systems that deliver measurable business growth.",
    },
    website: {
        title: 'A Website Marketing Strategy Designed for',
        accent: 'Conversions',
        paragraphs: [
            "Your website is where marketing activity most often turns into a business opportunity. You can have strong advertising, great social media reach, and growing organic traffic, but if your website doesn't deliver value and isn't strategically designed around a call to action, those opportunities will be lost.",
            'We take the entire customer journey into account: messaging, page structure, search intent, calls to action, content hierarchy, trust signals, user experience, and conversion opportunities are all analysed. The goal is simple — make it easier for the right visitors to understand your offer and take the next step.',
        ],
    },
    discovery: {
        title: 'Marketing Built for Search, AI, and',
        accent: 'Modern Discovery',
        paragraphs: [
            "Users are finding businesses through traditional search engines, social media, voice commands, and AI-powered answer engines. That means today's marketing content should be easily digestible not just by search engines, but by the humans and artificial intelligence consuming it.",
            "For instance, rather than developing a page that repeats 40 times that it's a digital marketing agency, we build useful content around the services, problems, industries, processes, questions, and outcomes of digital marketing. This helps build a more complete digital footprint that can be surfaced in various discovery contexts.",
        ],
        channelsTitle: 'Where customers find businesses today',
        channels: [
            { icon: 'Search', label: 'Traditional search engines' },
            { icon: 'Share2', label: 'Social media' },
            { icon: 'Mic', label: 'Voice commands' },
            { icon: 'Bot', label: 'AI-powered answer engines' },
        ],
        pillarsTitle: 'What our SEO and GEO strategy is built on',
        pillars: [
            'Clear entities',
            'Topical authority',
            'Natural language',
            'Structured information',
            'Helpful answers',
            'Internal relationships between topical pages',
            'Content that clearly meets user intent',
        ],
    },
    process: {
        title: 'Our Proven',
        accent: 'Growth Process',
        text: 'Our approach to digital growth runs in five stages — from learning about your business to scaling what works.',
    },
    alignment: {
        title: 'What Makes a Digital Marketing Strategy',
        accent: 'Effective?',
        paragraphs: [
            "The first step to an effective strategy is alignment. That's why we don't subject clients to a one-size-fits-all approach when a better-tailored approach suits them.",
            "For some businesses, gaining more organic visibility is the priority. Others require paid acquisition. Some need to improve the website conversion journey; others need stronger content or social media positioning. It's our job to figure out the mix that will work for you, your stage of growth, and your market.",
        ],
        chain: [
            { label: 'Business goals', text: 'Marketing goals should be based on your business goals.' },
            { label: 'Channels', text: 'The channels you use should be based on your marketing objectives.' },
            { label: 'Content & campaigns', text: "The channel you're on should dictate the content and campaigns you run." },
            { label: 'Data', text: 'Your campaign data should drive your next steps.' },
        ],
    },
    results: {
        title: 'Results That',
        accent: 'Matter',
        text: `At ${BRAND}, there are no vanity metrics and no chasing impressions. We measure what matters to your bottom line.`,
        label: 'Our clients experience',
        items: [
            { icon: 'TrendingUp', title: 'Increased Organic Traffic' },
            { icon: 'Search', title: 'Better Search Rankings' },
            { icon: 'Users', title: 'More Qualified Leads' },
            { icon: 'MousePointerClick', title: 'Higher Conversion Rates' },
            { icon: 'UserPlus', title: 'Improved Customer Acquisition' },
            { icon: 'CircleDollarSign', title: 'Greater Return On Investment' },
        ],
        promise: 'Our promise is measurable results that directly add to the growth of your business.',
    },
    usa: {
        title: 'Looking for Marketing Agencies',
        accent: 'in the USA?',
        paragraphs: [
            "The key issue isn't just the number of services an agency offers. The real question is whether the agency grasps your business model, your customers, your competitive landscape, and the commercial goals you hope to accomplish.",
            `At ${BRAND}, we believe marketing must be clearly defined and have a purpose. Each campaign, page, piece of content, and optimization should play a part in winning better customers and building a better digital brand.`,
            "If you're looking for a low-cost marketing agency, you might compare a few based on their rates. But when it comes to sustainable growth, the wider consideration is the value of the strategy, execution, optimization, and the results it supports.",
        ],
    },
    cta: {
        eyebrow: 'Ready to grow your business?',
        title: 'Start Building Your',
        accent: 'Digital Growth Strategy',
        paragraphs: [
            'You already compete with your rivals for attention on search engines, social media platforms, advertising networks, marketplaces, and AI-powered discovery. The opportunity is not to be everywhere just for the sake of it — it is to be there with the right message, in front of the right people, at the right time.',
            `Whether you're seeking a digital marketing agency, PPC agency, local SEO agency, Shopify SEO agency, content marketing agency, website design company, website building services, a web app development agency, or ecommerce web development experts, ${BRAND} has the answers you're searching for. We integrate SEO, PPC, social media, content marketing, eCommerce marketing, and growth strategy — as an all-in-one solution or for one specific channel — and help you find the opportunities that matter for your business.`,
            "Don't spend more money on marketing methods that aren't effective. Begin building a growth-minded digital brand with real-world business impact.",
        ],
        button: 'Get Started Today',
    },
    faq: {
        text: 'Clear answers to the questions businesses ask most about digital marketing, SEO, PPC, and working with an agency.',
    },
};

/**
 * Services described on the home page. `slug` links a service to its
 * admin-managed detail page when one with that slug is published.
 */
export const serviceCatalog = [
    {
        key: 'seo',
        icon: 'Search',
        slug: 'seo-services',
        name: 'Search Engine Optimization (SEO)',
        tagline: 'SEO that builds long-term search visibility',
        paragraphs: [
            "Optimizing your website for search engines and becoming visible on page one of Google is vital to your business's long-term success. When executed properly, search visibility can be one of the most powerful and sustainable sources of traffic to your website.",
            'Our SEO professionals create data-driven strategies that boost visibility in search engines and raise organic traffic and qualified leads. Our approach is based on technical maturity, search intent, topical relevance, content quality, on-page optimization, internal linking, local search opportunities, and authority building. Rather than developing pages for keywords, we develop pages that address customer questions and make your website valuable to the market.',
        ],
        listTitle: 'Our SEO Services Include',
        items: ['Technical SEO Audits', 'On-Page SEO Optimization', 'Keyword Research', 'Content Optimization', 'Link Building Campaigns', 'Local SEO Services', 'SEO Reporting & Analysis'],
        outro: `Whether you're evaluating the best SEO companies, need a local SEO agency or enterprise-level SEO, or want your website to rank for valuable commercial searches, ${BRAND} builds an SEO strategy that meshes with your targets, boosts your rankings, and speeds up growth.`,
    },
    {
        key: 'ppc',
        icon: 'MousePointerClick',
        slug: 'pay-per-click-advertising',
        name: 'Performance Marketing & PPC',
        tagline: 'PPC agency services',
        paragraphs: [
            'Looking for immediate traffic and faster results? Our PPC agency specialists build highly effective advertising campaigns that deliver leads without busting your advertising budget.',
            "Our PPC and performance marketing solutions link ads to tangible business results. The top PPC agency for your business doesn't only work on the number of clicks — your campaigns should relate to leads, sales, cost per click, and business metrics.",
        ],
        listTitle: 'PPC Marketing Services',
        items: ['Google Ads Management', 'Search Advertising', 'Display Advertising', 'Retargeting Campaigns', 'Shopping Ads', 'Conversion Tracking', 'Landing Page Optimization'],
        outro: 'As one of the leading PPC marketing agencies, our goal is simple: generate more conversions at a lower cost.',
    },
    {
        key: 'social',
        icon: 'Share2',
        slug: 'social-media-marketing',
        name: 'Social Media Marketing',
        tagline: 'Social marketing agency solutions',
        paragraphs: [
            "Social media is about more than likes and followers. It is about relationships, increased brand awareness, and revenue. Your customers are using social sites, and your brand can't just post from time to time and expect to hold their attention.",
            "When we meet businesses considering social media agencies or social media management companies, we don't just want to create a social account — we want to build a social presence that supports their overall marketing goals. Our social media experts craft campaigns that put your brand on the right platforms, with consistent communication, brand recognition, more engaged people, and opportunities to convert.",
        ],
        listTitle: 'Social Media Services',
        items: ['Facebook Marketing', 'Instagram Advertising', 'LinkedIn Marketing', 'Social Media Management', 'Community Engagement', 'Paid Social Campaigns', 'Content Creation'],
        outro: 'With our proven social marketing capabilities, we help you develop more vibrant online communities and boost customer engagement.',
    },
    {
        key: 'content',
        icon: 'PenLine',
        slug: 'content-marketing',
        name: 'Content Marketing',
        tagline: 'Content marketing agency services',
        paragraphs: [
            'Content continues to be one of the greatest assets when it comes to establishing trust and authority. Our content marketing agency creates strategic content that aims to attract, educate, and convert your target audience.',
            'Good marketing material should not only occupy a web page — it should serve a purpose: answer questions, prove knowledge, address objections, work towards visibility in search, and help prospects make decisions. Service pages, landing pages, blog content, educational resources, product content, comparison pages, and conversion-focused website copy are all part of our approach. Customers increasingly turn to both traditional search engines and AI tools to find content, so we organize it around real questions and answers.',
        ],
        listTitle: 'Content Marketing Solutions',
        items: ['SEO Content Writing', 'Blog Content Creation', 'Website Content', 'Landing Page Copywriting', 'Email Marketing Content', 'Lead Generation Content'],
        outro: "All content is optimized for your SEO objectives and is genuinely worth your audience's time.",
    },
    {
        key: 'ecommerce-marketing',
        icon: 'ShoppingCart',
        slug: 'ecommerce-marketing',
        name: 'eCommerce Marketing',
        tagline: 'Shopify marketing agency & ecommerce agency',
        paragraphs: [
            'Online stores face challenges that are unique to selling online, and each one needs its own answer.',
            `Whether you're looking for a Shopify marketing agency or an ecommerce agency that can help you create a strategy around your products, audience, margins, and growth goals, ${BRAND} can help you along the way.`,
        ],
        listTitle: 'Challenges We Help Online Stores Overcome',
        items: ['Competition', 'Customer Acquisition', 'Product Discovery', 'Conversion Rate', 'Customer Retention', 'Cart Abandonment'],
    },
    {
        key: 'growth',
        icon: 'Rocket',
        slug: 'growth-marketing',
        name: 'Growth Marketing',
        tagline: 'Acquisition, conversion, retention, and optimization',
        paragraphs: [
            "Growth doesn't happen overnight — it's usually the result of a series of campaigns. It comes from continuously discovering opportunities, testing assumptions, analysing data, and improving the customer journey. Our growth marketing method blends acquisition, conversion, retention, and optimization.",
        ],
        listTitle: 'Questions Growth Marketing Answers',
        items: [
            'Which channels generate qualified prospects?',
            'Which pages produce the strongest conversions?',
            'Where are potential customers dropping off?',
            'Which audiences respond to your offer?',
            'Which campaigns produce sustainable returns?',
            'What should be tested next?',
        ],
        outro: 'This approach to marketing relies on data, enabling decisions that grow with your business.',
    },
    {
        key: 'web-design',
        icon: 'Palette',
        slug: 'web-development',
        name: 'Website Design',
        tagline: 'Website design company solutions',
        paragraphs: [
            "A customer's first impression of your business usually comes from your website. Not having a well-designed website can mean the loss of leads and sales.",
            'Our website design company solutions focus on creating appealing, mobile-friendly, and conversion-optimized websites.',
        ],
        listTitle: 'Website Design Services',
        items: ['Custom Website Design', 'Responsive Development', 'UX/UI Design', 'Landing Page Design', 'Business Websites', 'Corporate Websites'],
        outro: 'Our websites are not only professional in appearance — they are also high-performing.',
    },
    {
        key: 'web-building',
        icon: 'LayoutTemplate',
        slug: 'web-development',
        name: 'Website Building Services',
        tagline: 'Sleek, fast, and scalable online platforms',
        paragraphs: [
            'Need a totally fresh website? Our website building services are tailored for companies looking for sleek, fast, and scalable online platforms.',
            'Our web design solutions reflect your brand and support your goals for the long term.',
        ],
        listTitle: 'Benefits of Our Website Building Services',
        items: ['Mobile Optimization', 'Fast Loading Speed', 'SEO-Friendly Architecture', 'User-Focused Design', 'Easy Content Management', 'Secure Infrastructure'],
    },
    {
        key: 'shopify-seo',
        icon: 'Store',
        slug: 'shopify-seo',
        name: 'Shopify SEO',
        tagline: 'Shopify SEO agency services',
        paragraphs: [
            "Your Shopify eCommerce store isn't going to succeed with amazing products alone. You need visibility.",
            'Our Shopify SEO agency experts help eCommerce businesses improve their rankings, drive more traffic, and increase sales.',
        ],
        listTitle: 'Shopify SEO Includes',
        items: ['Product Page Optimization', 'Collection Page SEO', 'Technical Shopify SEO', 'Content Strategy', 'Link Building', 'Keyword Optimization'],
        outro: 'We drive traffic to Shopify stores from people who are looking for the products you offer.',
    },
    {
        key: 'ecommerce-development',
        icon: 'ShoppingBag',
        slug: 'ecommerce-web-development',
        name: 'Ecommerce Web Development',
        tagline: 'Online stores built with growth in mind',
        paragraphs: [
            'Your eCommerce solution must be built with growth in mind.',
            'We offer ecommerce web development services for online stores that enhance user experience and conversions while staying scalable.',
        ],
        listTitle: 'Ecommerce Development Features',
        items: ['Custom Store Development', 'Product Management Systems', 'Secure Payment Integration', 'Mobile Commerce Optimization', 'Inventory Management', 'Advanced Analytics'],
        outro: 'Our team builds solutions that help grow the business and customer satisfaction.',
    },
    {
        key: 'web-apps',
        icon: 'AppWindow',
        slug: 'web-app-development',
        name: 'Web App Development',
        tagline: 'Web app development agency',
        paragraphs: [
            'Need a custom-built web application? Our web app development agency designs and builds scalable web apps, so you can rest assured that you are getting the best we have to offer.',
        ],
        listTitle: 'Web Application Services',
        items: ['Custom Web Applications', 'SaaS Platforms', 'CRM Systems', 'Customer Portals', 'Business Automation Solutions', 'Enterprise Applications'],
        outro: 'Our applications are driven by efficiency and growth, using innovative technologies and user-focused design.',
    },
];

/**
 * Services mega menu: columns of groups, each linking to admin-managed service
 * pages by slug. Items whose service isn't published are hidden, and published
 * services not listed here are added under "More Services" automatically.
 */
export const serviceMenu = [
    [
        {
            title: 'Digital Marketing',
            items: [
                { label: 'Search Engine Optimization', slug: 'seo-services' },
                { label: 'Local SEO Services', slug: 'local-seo-services' },
                { label: 'Search Engine Marketing', slug: 'search-engine-marketing-services' },
                { label: 'Pay-Per-Click Advertising', slug: 'pay-per-click-advertising' },
                { label: 'Social Media Marketing', slug: 'social-media-marketing' },
                { label: 'Content Marketing', slug: 'content-marketing' },
                { label: 'Email Marketing', slug: 'email-marketing' },
            ],
        },
    ],
    [
        {
            title: 'Web Development',
            items: [
                { label: 'Website Design & Development', slug: 'web-development' },
                { label: 'Custom Website Development', slug: 'custom-website-development-services' },
                { label: 'Business Website Development', slug: 'business-website-development' },
                { label: 'E-Commerce Web Development', slug: 'ecommerce-web-development' },
                { label: 'Web Application Development', slug: 'web-app-development' },
            ],
        },
        {
            title: 'Branding',
            items: [
                { label: 'Brand Identity & Strategy', slug: 'branding' },
                { label: 'Graphic Design', slug: 'creative-graphic-design-services' },
            ],
        },
    ],
    [
        {
            title: 'eCommerce & Growth',
            items: [
                { label: 'eCommerce Marketing', slug: 'ecommerce-marketing' },
                { label: 'Shopify SEO', slug: 'shopify-seo' },
                { label: 'Growth Marketing', slug: 'growth-marketing' },
            ],
        },
    ],
];
