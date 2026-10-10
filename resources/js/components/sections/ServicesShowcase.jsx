import { ArrowRight, Check, ChevronDown } from 'lucide-react';
import { useState } from 'react';
import { Link } from 'react-router-dom';
import { home, serviceCatalog } from '../../content/site';
import { useSite } from '../../lib/site';
import Icon from '../ui/Icon';
import SectionHeading from '../ui/SectionHeading';

/** Copy, checklist, and link for one service; shared by the desktop panel and the mobile accordion. */
function ServiceBody({ service, to }) {
    return (
        <>
            <div className="space-y-4">
                {service.paragraphs.map((paragraph) => (
                    <p key={paragraph} className="leading-relaxed text-white/85">
                        {paragraph}
                    </p>
                ))}
            </div>

            <h4 className="mb-4 mt-7 text-sm font-semibold uppercase tracking-widest text-brand">{service.listTitle}</h4>
            <ul className="grid gap-x-6 gap-y-3 sm:grid-cols-2">
                {service.items.map((item) => (
                    <li key={item} className="flex items-start gap-3 text-white">
                        <span className="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-brand text-black">
                            <Check className="size-3" strokeWidth={3} aria-hidden="true" />
                        </span>
                        {item}
                    </li>
                ))}
            </ul>

            {service.outro && <p className="mt-7 border-l-2 border-brand pl-4 leading-relaxed text-white/85">{service.outro}</p>}

            <Link to={to} className="mt-7 inline-flex items-center gap-2 font-semibold text-brand hover:text-brand-soft">
                {to === '/contact' ? 'Talk to us about this service' : 'Explore this service'}
                <ArrowRight className="size-4" aria-hidden="true" />
            </Link>
        </>
    );
}

/**
 * Interactive services list: picking a service on the left reveals its detail
 * panel on the right. On small screens it becomes an accordion, so the long
 * copy stays one tap away instead of stacking into a wall of text.
 */
export default function ServicesShowcase() {
    const { services } = useSite();
    const [active, setActive] = useState(0);
    const [open, setOpen] = useState(0);

    // Services without a published detail page send visitors to the contact form.
    const published = new Set(services.map((service) => service.slug));
    const linkFor = (service) => (service.slug && published.has(service.slug) ? `/services/${service.slug}` : '/contact');

    const current = serviceCatalog[active];

    return (
        <section className="bg-background py-12 text-white md:py-20">
            <div className="container-site">
                <SectionHeading title={home.services.title} accent={home.services.accent} text={home.services.text} />

                {/* Desktop: list + detail panel */}
                <div className="hidden grid-cols-[0.62fr_1.38fr] items-start gap-8 lg:grid xl:gap-14">
                    <div
                        role="tablist"
                        aria-label="Services"
                        aria-orientation="vertical"
                        className="sticky top-28 border-l border-white/15"
                    >
                        {serviceCatalog.map((service, index) => {
                            const selected = index === active;

                            return (
                                <button
                                    key={service.key}
                                    type="button"
                                    role="tab"
                                    id={`service-tab-${service.key}`}
                                    aria-selected={selected}
                                    aria-controls="service-panel"
                                    onClick={() => setActive(index)}
                                    className="group relative flex w-full items-center gap-3 rounded-r-lg py-2.5 pl-5 pr-3 text-left"
                                >
                                    <span
                                        className={`absolute -left-px bottom-1 top-1 w-[3px] rounded-full transition-colors ${selected ? 'bg-brand' : 'bg-transparent'}`}
                                    />
                                    <Icon
                                        name={service.icon}
                                        className={`size-[18px] shrink-0 transition-colors ${selected ? 'text-brand' : 'text-white/35 group-hover:text-white/70'}`}
                                    />
                                    <span
                                        className={`block text-[16px] font-bold transition-all duration-200 xl:text-[17px] ${selected ? 'translate-x-1 text-brand' : 'text-white/55 group-hover:text-white'}`}
                                    >
                                        {service.name}
                                    </span>
                                </button>
                            );
                        })}
                    </div>

                    <div
                        id="service-panel"
                        role="tabpanel"
                        aria-labelledby={`service-tab-${current.key}`}
                        className="relative flex min-h-[600px] flex-col justify-center overflow-hidden rounded-[30px] border border-white/10 bg-[#111111] p-10 xl:p-14"
                    >
                        <div className="pointer-events-none absolute inset-0 bg-[linear-gradient(rgba(253,199,0,0.5)_1px,transparent_1px),linear-gradient(90deg,rgba(253,199,0,0.5)_1px,transparent_1px)] bg-[size:72px_72px] opacity-[0.04]" />
                        <div className="pointer-events-none absolute left-1/2 top-0 h-[180px] w-[65%] -translate-x-1/2 rounded-full bg-brand opacity-[0.08] blur-[70px]" />
                        <Icon
                            key={`art-${current.key}`}
                            name={current.icon}
                            className="pointer-events-none absolute -right-6 -top-6 size-56 animate-fade-up text-brand/[0.07] xl:size-72"
                            strokeWidth={1}
                        />

                        <div key={current.key} className="relative z-10 animate-fade-up">
                            <div className="mb-5 flex items-center gap-4">
                                <span className="flex size-11 shrink-0 items-center justify-center rounded-[9px] border-2 border-brand bg-black/10 text-brand">
                                    <Icon name={current.icon} className="size-5" />
                                </span>
                                <p className="text-sm font-medium uppercase tracking-widest text-white/60">{current.tagline}</p>
                            </div>
                            <h3 className="mb-5 text-[32px] font-bold leading-[1.1] tracking-[-0.03em] xl:text-[40px]">{current.name}</h3>
                            <ServiceBody service={current} to={linkFor(current)} />
                        </div>
                    </div>
                </div>

                {/* Mobile / tablet: accordion */}
                <div className="space-y-3 lg:hidden">
                    {serviceCatalog.map((service, index) => {
                        const isOpen = index === open;
                        const panelId = `service-mobile-${service.key}`;

                        return (
                            <div
                                key={service.key}
                                className={`rounded-2xl border bg-[#111111] transition-colors ${isOpen ? 'border-brand/50' : 'border-white/10'}`}
                            >
                                <h3>
                                    <button
                                        type="button"
                                        aria-expanded={isOpen}
                                        aria-controls={panelId}
                                        onClick={() => setOpen(isOpen ? -1 : index)}
                                        className="flex w-full items-center gap-4 p-4 text-left sm:p-5"
                                    >
                                        <span
                                            className={`flex size-11 shrink-0 items-center justify-center rounded-[9px] border-2 transition-colors ${isOpen ? 'border-brand bg-brand text-black' : 'border-brand text-brand'}`}
                                        >
                                            <Icon name={service.icon} className="size-5" />
                                        </span>
                                        <span className="min-w-0 flex-1">
                                            <span className="block text-lg font-bold leading-snug">{service.name}</span>
                                            <span className="mt-0.5 block text-sm text-white/60">{service.tagline}</span>
                                        </span>
                                        <ChevronDown
                                            className={`size-5 shrink-0 text-brand transition-transform duration-300 ${isOpen ? 'rotate-180' : ''}`}
                                            aria-hidden="true"
                                        />
                                    </button>
                                </h3>
                                <div
                                    id={panelId}
                                    role="region"
                                    className={`grid transition-[grid-template-rows] duration-300 ${isOpen ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'}`}
                                >
                                    <div className={`overflow-hidden ${isOpen ? '' : 'invisible'}`}>
                                        <div className="px-4 pb-6 pt-1 sm:px-5">
                                            <ServiceBody service={service} to={linkFor(service)} />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
