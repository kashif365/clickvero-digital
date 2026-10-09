import { ArrowRight } from 'lucide-react';
import { useState } from 'react';
import { Link } from 'react-router-dom';
import ContactSection from '../components/sections/ContactSection';
import PageHero from '../components/sections/PageHero';
import ProcessPanels from '../components/sections/ProcessPanels';
import { EmptyState, ErrorState, Skeleton } from '../components/ui/States';
import { images } from '../content/site';
import { api } from '../lib/api';
import { useAsync } from '../lib/hooks';
import { serviceIcon } from '../lib/site';

export default function Services() {
    const [attempt, setAttempt] = useState(0);
    const { data, error, loading } = useAsync((signal) => api.services(signal), [attempt]);
    const services = data?.data ?? [];

    return (
        <>
            <PageHero
                image={images.campaign}
                eyebrow="What we do"
                title="Digital Marketing Services"
                accent="We Provide"
                text="Our services cover every channel that drives growth — search, paid media, social, content, email, and the website they all point to."
                breadcrumbs={[{ label: 'Services' }]}
            />

            <section className="relative overflow-hidden py-16 md:py-24">
                <div className="pointer-events-none absolute -left-52 top-0 size-[460px] rounded-full bg-brand/10 blur-[170px]" />
                <div className="container-site relative">
                    {error ? (
                        <ErrorState message={error.message} onRetry={() => setAttempt((value) => value + 1)} />
                    ) : loading ? (
                        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            {Array.from({ length: 6 }, (_, key) => (
                                <Skeleton key={key} className="h-64" />
                            ))}
                        </div>
                    ) : services.length === 0 ? (
                        <EmptyState title="No services published yet" text="Please check back soon." />
                    ) : (
                        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            {services.map((service, index) => {
                                const IconComponent = serviceIcon(service.slug);

                                return (
                                    <Link
                                        key={service.id}
                                        to={`/services/${service.slug}`}
                                        className="group relative flex flex-col overflow-hidden rounded-[30px] border bg-card p-8 transition-colors duration-300 hover:border-brand/60"
                                    >
                                        <span className="pointer-events-none absolute -right-2 -top-6 text-[120px] font-bold leading-none text-brand/[0.055]">
                                            {String(index + 1).padStart(2, '0')}
                                        </span>
                                        <span className="mb-6 flex size-16 items-center justify-center rounded-2xl border border-brand/40 bg-brand/10 text-brand transition-colors duration-300 group-hover:bg-brand group-hover:text-black">
                                            <IconComponent className="size-7" aria-hidden="true" />
                                        </span>
                                        <h2 className="text-2xl font-bold leading-tight">{service.name}</h2>
                                        {service.short_description && (
                                            <p className="mt-4 flex-1 leading-relaxed text-muted-foreground">{service.short_description}</p>
                                        )}
                                        <span className="mt-6 inline-flex items-center gap-2 border-t pt-5 font-semibold text-brand">
                                            Learn more
                                            <ArrowRight className="size-4 transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" />
                                        </span>
                                    </Link>
                                );
                            })}
                        </div>
                    )}
                </div>
            </section>

            <ProcessPanels />
            <ContactSection />
        </>
    );
}
