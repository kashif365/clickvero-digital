import ContactForm from '../components/sections/ContactForm';
import ContactSection from '../components/sections/ContactSection';
import FaqSection from '../components/sections/FaqSection';
import FeatureBanner from '../components/sections/FeatureBanner';
import LatestBlogs from '../components/sections/LatestBlogs';
import PageHero from '../components/sections/PageHero';
import ProcessPanels from '../components/sections/ProcessPanels';
import ProjectsGrid from '../components/sections/ProjectsGrid';
import Reasons from '../components/sections/Reasons';
import ServiceMarquee from '../components/sections/ServiceMarquee';
import ServicesShowcase from '../components/sections/ServicesShowcase';
import Stats from '../components/sections/Stats';
import Testimonials from '../components/sections/Testimonials';
import ToolStack from '../components/sections/ToolStack';
import Button from '../components/ui/Button';
import { faqs, images, projects, reasons } from '../content/site';
import { useSite } from '../lib/site';

export default function Home() {
    const site = useSite();
    const brand = site.name.split(' ')[0];

    return (
        <>
            <PageHero
                tall
                image={images.hero}
                eyebrow="A remote-first digital marketing agency"
                title="Grow Your Brand's"
                accent="Online Presence"
                text={`${site.name} helps brands grow online with SEO, PPC, social media marketing, content marketing, and web development — serving clients worldwide.`}
                cta={{ to: '/contact', label: 'Book A Discovery Call' }}
            >
                <div className="animate-fade-up rounded-2xl border border-white/15 bg-black/55 p-6 backdrop-blur-md md:p-8">
                    <h2 className="text-2xl font-bold text-white">Get a Free Quote</h2>
                    <p className="mb-6 mt-2 text-white/80">Tell us about your project — we&rsquo;ll follow up within one business day.</p>
                    <ContactForm submitLabel="Get Free Quote" />
                </div>
            </PageHero>

            <ServiceMarquee />
            <Stats />

            <FeatureBanner
                heading={
                    <h2 className="mb-6 text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">
                        Why Brands Choose <span className="text-brand">{brand}</span>
                    </h2>
                }
                title="Built for modern"
                accent="digital growth"
                text={`${site.name} partners with businesses that need sharper digital marketing, clearer messaging, and steady, measurable growth. We align design, development, and marketing around one commercial objective.`}
                image={images.about}
                imageAlt="Our team collaborating on a campaign plan"
                cta={{ to: '/about', label: 'More About Us' }}
            />

            <ServicesShowcase />
            <ProcessPanels />

            <section className="py-10 md:py-20">
                <div className="container-site">
                    <div className="mb-8 grid grid-cols-1 items-center gap-6 md:mb-16 lg:grid-cols-2 lg:gap-16">
                        <h2 className="text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">
                            Growth <span className="text-brand">Playbooks</span>
                        </h2>
                        <p className="leading-relaxed text-muted-foreground">How we approach the situations growing businesses bring to us most often — the problem, the plan, and how success is measured.</p>
                    </div>
                    <ProjectsGrid items={projects.slice(0, 4)} />
                    <div className="mt-10 flex justify-center">
                        <Button to="/project">See All Playbooks</Button>
                    </div>
                </div>
            </section>

            <Reasons
                title="A partner built for delivery,"
                accent="not just presentation"
                text="Before we design or launch anything, we focus on understanding what actually makes your marketing succeed — from audience behavior to channel performance."
                items={reasons}
            />

            <FeatureBanner
                title="Your Brand Deserves More"
                accent="Than Guesswork"
                text="We launch campaigns and continuously test and refine — creative, targeting, and landing pages — as real data comes in, then report performance in plain language every month."
                image={images.analytics}
                imageAlt="Analytics dashboard showing campaign performance"
                cta={{ to: '/contact', label: 'Book A Discovery Call' }}
            />

            <Testimonials />
            <ToolStack />
            <FaqSection items={faqs.slice(0, 6)} />
            <LatestBlogs />
            <ContactSection />
        </>
    );
}
