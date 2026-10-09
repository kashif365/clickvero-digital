import { Check } from 'lucide-react';
import ContactSection from '../components/sections/ContactSection';
import FaqSection from '../components/sections/FaqSection';
import LatestBlogs from '../components/sections/LatestBlogs';
import PageHero from '../components/sections/PageHero';
import Reasons from '../components/sections/Reasons';
import ServiceMarquee from '../components/sections/ServiceMarquee';
import Stats from '../components/sections/Stats';
import Testimonials from '../components/sections/Testimonials';
import Button from '../components/ui/Button';
import { aboutValues, faqs, images } from '../content/site';
import { useSite } from '../lib/site';

const PRINCIPLES = [
    { title: 'Strategic Thinking', text: 'We align design, development, and marketing around one commercial objective.' },
    { title: 'Reliable Delivery', text: 'Our teams ship on schedule, communicate clearly, and measure what matters.' },
];

export default function About() {
    const site = useSite();

    return (
        <>
            <PageHero
                image={images.discussion}
                eyebrow="ABOUT US"
                title="We Don't Just Run Campaigns."
                accent="We Build Growth."
                text={`${site.name} is a remote-first digital marketing agency helping brands grow online with SEO, PPC, social media, content, and web development — wherever in the world you're based.`}
                breadcrumbs={[{ label: 'About' }]}
                cta={{ to: '/contact', label: "Let's Talk" }}
            />

            <ServiceMarquee />

            <section className="py-12 md:py-20">
                <div className="container-site grid items-center gap-10 lg:grid-cols-2 lg:gap-20">
                    <div className="relative">
                        <img src={images.about} alt="The team collaborating" loading="lazy" className="aspect-[4/3] w-full rounded-[30px] object-cover" />
                        <div className="absolute -bottom-6 right-4 rounded-2xl bg-brand px-5 py-3 text-black shadow-xl sm:right-6 sm:px-6 sm:py-4">
                            <p className="text-3xl font-bold">100%</p>
                            <p className="text-sm font-medium">Remote-first, worldwide clients</p>
                        </div>
                    </div>
                    <div>
                        <h2 className="text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">
                            Built for modern <span className="text-brand">digital growth</span>
                        </h2>
                        <p className="mt-5 leading-relaxed text-muted-foreground">
                            We partner with businesses that need sharper digital marketing, clearer messaging, and steady, measurable growth. Search, paid media, social, content, email, branding, and web development are planned together, so every channel supports the same commercial goal.
                        </p>
                        <ul className="mt-8 space-y-6">
                            {PRINCIPLES.map((principle) => (
                                <li key={principle.title} className="flex gap-4">
                                    <span className="mt-1 flex size-8 shrink-0 items-center justify-center rounded-full bg-brand text-black">
                                        <Check className="size-4" aria-hidden="true" />
                                    </span>
                                    <div>
                                        <h3 className="text-lg font-semibold">{principle.title}</h3>
                                        <p className="mt-1 leading-relaxed text-muted-foreground">{principle.text}</p>
                                    </div>
                                </li>
                            ))}
                        </ul>
                        <div className="mt-10">
                            <Button to="/contact">Book a Call</Button>
                        </div>
                    </div>
                </div>
            </section>

            <Stats />
            <Reasons title="Marketing that" accent="moves you forward" items={aboutValues} />
            <Testimonials />
            <FaqSection items={faqs.slice(0, 4)} />
            <LatestBlogs />
            <ContactSection />
        </>
    );
}
