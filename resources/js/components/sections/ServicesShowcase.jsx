import { ArrowRight } from 'lucide-react';
import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { serviceIcon, useSite } from '../../lib/site';
import { EmptyState } from '../ui/States';

const ROTATE_MS = 6000;

/**
 * Interactive services list: picking a service on the left reveals its detail
 * panel on the right. Auto-advances until the visitor interacts. On small
 * screens it becomes a simple stack of cards.
 */
export default function ServicesShowcase() {
    const { services } = useSite();
    const [active, setActive] = useState(0);
    const [paused, setPaused] = useState(false);

    useEffect(() => {
        if (paused || services.length < 2) {
            return undefined;
        }

        const timer = setInterval(() => setActive((index) => (index + 1) % services.length), ROTATE_MS);

        return () => clearInterval(timer);
    }, [paused, services.length]);

    const heading = (
        <>
            <h2 className="mb-5 text-3xl font-bold leading-tight xl:text-4xl">
                Digital services <span className="text-brand">built to convert</span>
            </h2>
            <p className="max-w-[440px] leading-relaxed text-white">
                Every service we deliver is connected by a single goal: marketing that actually moves your business forward.
            </p>
        </>
    );

    if (services.length === 0) {
        return (
            <section className="bg-background py-16">
                <div className="container-site">
                    {heading}
                    <div className="mt-10">
                        <EmptyState title="No services published yet" text="Services added in the admin panel will appear here." />
                    </div>
                </div>
            </section>
        );
    }

    const current = services[Math.min(active, services.length - 1)];
    const CurrentIcon = serviceIcon(current.slug);

    return (
        <section className="bg-background text-white">
            {/* Desktop: list + detail panel */}
            <div className="container-site hidden py-20 lg:block" onMouseEnter={() => setPaused(true)} onMouseLeave={() => setPaused(false)}>
                <div className="grid grid-cols-[0.68fr_1.32fr] items-center gap-8 xl:gap-14">
                    <div className="flex flex-col justify-center">
                        {heading}
                        <div role="tablist" aria-label="Services" aria-orientation="vertical" className="relative mt-6 border-l border-white/15 xl:mt-8">
                            {services.map((service, index) => {
                                const selected = index === active;

                                return (
                                    <button
                                        key={service.slug}
                                        type="button"
                                        role="tab"
                                        aria-selected={selected}
                                        aria-controls="service-panel"
                                        onClick={() => {
                                            setActive(index);
                                            setPaused(true);
                                        }}
                                        className="group relative block w-full rounded-r-lg py-2 pl-5 pr-3 text-left xl:py-2.5"
                                    >
                                        <span
                                            className={`absolute -left-px bottom-1 top-1 w-[3px] rounded-full transition-colors ${selected ? 'bg-brand' : 'bg-transparent'}`}
                                        />
                                        <span
                                            className={`block text-[16px] font-bold transition-all duration-200 xl:text-[18px] ${selected ? 'translate-x-1 text-brand' : 'text-white/55 group-hover:text-white'}`}
                                        >
                                            {service.name}
                                        </span>
                                    </button>
                                );
                            })}
                        </div>
                    </div>

                    <div
                        id="service-panel"
                        role="tabpanel"
                        className="relative flex min-h-[520px] flex-col justify-end overflow-hidden rounded-[30px] border border-white/10 bg-[#111111] p-10 xl:p-14"
                    >
                        <div className="pointer-events-none absolute inset-0 bg-[linear-gradient(rgba(253,199,0,0.5)_1px,transparent_1px),linear-gradient(90deg,rgba(253,199,0,0.5)_1px,transparent_1px)] bg-[size:72px_72px] opacity-[0.04]" />
                        <div className="pointer-events-none absolute left-1/2 top-0 h-[180px] w-[65%] -translate-x-1/2 rounded-full bg-brand opacity-[0.08] blur-[70px]" />
                        <CurrentIcon
                            key={`art-${current.slug}`}
                            className="pointer-events-none absolute right-8 top-8 size-56 animate-fade-up text-brand/[0.12] xl:size-72"
                            strokeWidth={1}
                            aria-hidden="true"
                        />

                        <div key={current.slug} className="relative z-10 animate-fade-up">
                            <div className="mb-4 flex size-11 items-center justify-center rounded-[9px] border-2 border-brand bg-black/10 text-brand">
                                <CurrentIcon className="size-5" aria-hidden="true" />
                            </div>
                            <Link to={`/services/${current.slug}`} className="group/title block w-fit">
                                <h3 className="max-w-[650px] text-[35px] font-bold leading-[1.05] tracking-[-0.04em] transition-all duration-300 group-hover/title:translate-x-1 group-hover/title:text-brand xl:text-[45px]">
                                    {current.name}
                                </h3>
                            </Link>
                            {current.short_description && (
                                <p className="mt-4 max-w-[700px] leading-relaxed text-white">{current.short_description}</p>
                            )}
                            <Link
                                to={`/services/${current.slug}`}
                                className="mt-6 inline-flex items-center gap-2 font-semibold text-brand hover:text-brand-soft"
                            >
                                Explore this service <ArrowRight className="size-4" aria-hidden="true" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            {/* Mobile / tablet: stacked cards */}
            <div className="container-site py-12 lg:hidden">
                {heading}
                <div className="mt-8 grid gap-4 sm:grid-cols-2">
                    {services.map((service) => {
                        const IconComponent = serviceIcon(service.slug);

                        return (
                            <Link
                                key={service.slug}
                                to={`/services/${service.slug}`}
                                className="rounded-2xl border border-white/10 bg-[#111111] p-6 transition-colors hover:border-brand/60"
                            >
                                <div className="mb-4 flex size-11 items-center justify-center rounded-[9px] border-2 border-brand text-brand">
                                    <IconComponent className="size-5" aria-hidden="true" />
                                </div>
                                <h3 className="text-xl font-bold">{service.name}</h3>
                                {service.short_description && <p className="mt-2 leading-relaxed text-white/80">{service.short_description}</p>}
                            </Link>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
