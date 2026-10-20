import { Check } from 'lucide-react';
import ContactForm from '../components/sections/ContactForm';
import ContactSection from '../components/sections/ContactSection';
import CtaBanner from '../components/sections/CtaBanner';
import FaqSection from '../components/sections/FaqSection';
import FeatureBanner from '../components/sections/FeatureBanner';
import LatestBlogs from '../components/sections/LatestBlogs';
import Outcomes from '../components/sections/Outcomes';
import PageHero from '../components/sections/PageHero';
import ProcessPanels from '../components/sections/ProcessPanels';
import ProseSplit from '../components/sections/ProseSplit';
import ServiceMarquee from '../components/sections/ServiceMarquee';
import ServicesShowcase from '../components/sections/ServicesShowcase';
import Testimonials from '../components/sections/Testimonials';
import ToolStack from '../components/sections/ToolStack';
import WhyChoose from '../components/sections/WhyChoose';
import WorkGallery from '../components/sections/WorkGallery';
import Icon from '../components/ui/Icon';
import SectionHeading from '../components/ui/SectionHeading';
import { home, homeFaqs, images } from '../content/site';
import { useSite } from '../lib/site';

const PANEL = 'rounded-[30px] border border-white/10 bg-[#111111] p-6 md:p-8';
const PANEL_LABEL = 'text-sm font-semibold uppercase tracking-widest text-brand';

export default function Home() {
    const site = useSite();
    const brand = site.name.split(' ')[0];
    const { hero, intro, goals, audience, website, discovery, alignment, usa, cta, faq } = home;

    return (
        <>
            <PageHero
                tall
                image={images.hero}
                eyebrow={hero.eyebrow}
                title={hero.title}
                accent={hero.accent}
                text={hero.text}
                cta={{ to: '/contact', label: hero.cta }}
            >
                <div className="animate-fade-up rounded-2xl border border-white/15 bg-black/55 p-6 backdrop-blur-md md:p-8">
                    <h2 className="text-2xl font-bold text-white">{hero.formTitle}</h2>
                    <p className="mb-6 mt-2 text-white/80">{hero.formText}</p>
                    <ContactForm submitLabel={hero.formSubmit} />
                </div>
            </PageHero>

            <ServiceMarquee />

            <FeatureBanner
                heading={
                    <h2 className="mb-6 text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">
                        Grow Faster With <span className="text-brand">{brand}</span>
                    </h2>
                }
                title={intro.title}
                accent={intro.accent}
                text={intro.paragraphs}
                image={images.about}
                imageAlt="Our team collaborating on a campaign plan"
                cta={{ to: '/contact', label: hero.cta }}
            />

            <ProseSplit title={goals.title} accent={goals.accent} paragraphs={goals.paragraphs}>
                <div className={PANEL}>
                    <h3 className="text-xl font-bold md:text-2xl">{audience.title}</h3>
                    <p className="mt-3 leading-relaxed text-white/75">{audience.text}</p>
                    <ul className="mt-6 grid gap-x-6 gap-y-3 sm:grid-cols-2">
                        {audience.items.map((item) => (
                            <li key={item} className="flex items-start gap-3">
                                <span className="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-brand text-black">
                                    <Check className="size-3" strokeWidth={3} aria-hidden="true" />
                                </span>
                                {item}
                            </li>
                        ))}
                    </ul>
                    <p className="mt-7 border-t border-white/10 pt-6 leading-relaxed text-white/75">{audience.note}</p>
                </div>
            </ProseSplit>

            <WhyChoose />
            <ServicesShowcase />

            <FeatureBanner
                title={website.title}
                accent={website.accent}
                text={website.paragraphs}
                image={images.analytics}
                imageAlt="Analytics dashboard showing website and campaign performance"
                cta={{ to: '/contact', label: 'Book A Discovery Call' }}
            />

            <ProseSplit reverse title={discovery.title} accent={discovery.accent} paragraphs={discovery.paragraphs}>
                <div className={PANEL}>
                    <h3 className={PANEL_LABEL}>{discovery.channelsTitle}</h3>
                    <ul className="mt-5 grid grid-cols-2 gap-3">
                        {discovery.channels.map((channel) => (
                            <li key={channel.label} className="flex flex-col gap-3 rounded-2xl border border-white/10 bg-black p-4 font-medium leading-snug">
                                <span className="flex size-10 items-center justify-center rounded-xl border border-brand/30 bg-brand/10 text-brand">
                                    <Icon name={channel.icon} className="size-5" />
                                </span>
                                {channel.label}
                            </li>
                        ))}
                    </ul>
                    <h3 className={`mt-8 ${PANEL_LABEL}`}>{discovery.pillarsTitle}</h3>
                    <ul className="mt-5 flex flex-wrap gap-2">
                        {discovery.pillars.map((pillar) => (
                            <li key={pillar} className="rounded-full border border-white/15 bg-black px-4 py-2 text-sm text-white/90">
                                {pillar}
                            </li>
                        ))}
                    </ul>
                </div>
            </ProseSplit>

            <ProcessPanels />

            <ProseSplit title={alignment.title} accent={alignment.accent} paragraphs={alignment.paragraphs}>
                <ol className="relative space-y-4 before:absolute before:bottom-8 before:left-[19px] before:top-8 before:w-px before:bg-white/15">
                    {alignment.chain.map((link, index) => (
                        <li key={link.label} className="relative flex gap-4">
                            <span className="relative z-10 flex size-10 shrink-0 items-center justify-center rounded-full bg-brand font-bold text-black">
                                {index + 1}
                            </span>
                            <div className="flex-1 rounded-2xl border border-white/10 bg-[#111111] p-5">
                                <h3 className={PANEL_LABEL}>{link.label}</h3>
                                <p className="mt-2 leading-relaxed">{link.text}</p>
                            </div>
                        </li>
                    ))}
                </ol>
            </ProseSplit>

            <Outcomes />

            <section className="py-10 md:py-20">
                <div className="container-site">
                    <SectionHeading
                        title="Our Recent"
                        accent="Work"
                        text="Websites, online stores, brand identities, social media designs, and Google Ads campaigns we've delivered for growing businesses. Open any project to see it in full."
                    />
                    <WorkGallery pageSize={6} moreTo="/project" />
                </div>
            </section>

            <ProseSplit reverse title={usa.title} accent={usa.accent} paragraphs={usa.paragraphs}>
                <img
                    src={images.strategy}
                    alt="A brand strategy session with the marketing team"
                    loading="lazy"
                    className="aspect-[4/3] w-full rounded-[30px] object-cover"
                />
            </ProseSplit>

            <Testimonials />
            <ToolStack />

            <CtaBanner
                eyebrow={cta.eyebrow}
                title={cta.title}
                accent={cta.accent}
                paragraphs={cta.paragraphs}
                cta={{ to: '/contact', label: cta.button }}
            />

            <FaqSection columns items={homeFaqs} text={faq.text} />
            <LatestBlogs />
            <ContactSection />
        </>
    );
}
