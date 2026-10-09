import ContactSection from '../components/sections/ContactSection';
import PageHero from '../components/sections/PageHero';
import Accordion from '../components/ui/Accordion';
import Reveal from '../components/ui/Reveal';
import { faqGroups, images } from '../content/site';

const anchor = (group) => group.toLowerCase().replace(/[^a-z0-9]+/g, '-');

export default function Faq() {
    return (
        <>
            <PageHero
                image={images.discussion}
                eyebrow="Help center"
                title="Frequently Asked"
                accent="Questions"
                text="Quick, clear answers about our process, results, and pricing."
                breadcrumbs={[{ label: 'FAQ' }]}
            />

            <section className="py-12 md:py-20">
                <div className="container-site grid gap-8 lg:grid-cols-[260px_minmax(0,1fr)] lg:gap-14">
                    <nav aria-label="FAQ topics" className="lg:sticky lg:top-28 lg:self-start">
                        <p className="mb-3 hidden text-sm font-semibold uppercase tracking-widest text-muted-foreground lg:block">Topics</p>
                        <ul className="-mx-4 flex gap-2 overflow-x-auto px-4 pb-2 [scrollbar-width:none] lg:mx-0 lg:flex-col lg:gap-1 lg:px-0 [&::-webkit-scrollbar]:hidden">
                            {faqGroups.map((group) => (
                                <li key={group.group} className="shrink-0">
                                    <a
                                        href={`#${anchor(group.group)}`}
                                        className="block rounded-full border bg-card px-5 py-2.5 text-sm font-medium transition-colors hover:border-brand/60 hover:text-brand lg:rounded-xl lg:border-transparent lg:bg-transparent lg:px-3 lg:text-base"
                                    >
                                        {group.group}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </nav>

                    <div className="space-y-12">
                        {faqGroups.map((group) => (
                            <Reveal key={group.group} id={anchor(group.group)} className="scroll-mt-28">
                                <h2 className="mb-5 text-2xl font-bold md:text-3xl">{group.group}</h2>
                                <Accordion items={group.items} defaultOpen={-1} />
                            </Reveal>
                        ))}
                    </div>
                </div>
            </section>

            <ContactSection />
        </>
    );
}
