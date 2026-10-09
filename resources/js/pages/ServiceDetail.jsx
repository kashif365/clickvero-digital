import { useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import ContactSection from '../components/sections/ContactSection';
import FaqSection from '../components/sections/FaqSection';
import PageHero from '../components/sections/PageHero';
import ServiceMarquee from '../components/sections/ServiceMarquee';
import { ErrorState, Skeleton } from '../components/ui/States';
import { images } from '../content/site';
import { api } from '../lib/api';
import { useAsync } from '../lib/hooks';
import { serviceIcon, useSite } from '../lib/site';
import NotFound from './NotFound';

export default function ServiceDetail() {
    const { slug } = useParams();
    const site = useSite();
    const [attempt, setAttempt] = useState(0);
    const { data, error, loading } = useAsync((signal) => api.service(slug, signal), [slug, attempt]);
    const service = data?.data;

    if (error?.status === 404) {
        return <NotFound />;
    }

    const others = site.services.filter((item) => item.slug !== slug);

    return (
        <>
            <PageHero
                image={service?.banner_image || images.campaign}
                eyebrow="Our Services"
                title={service?.name ?? site.services.find((item) => item.slug === slug)?.name ?? 'Service'}
                text={service?.short_description}
                breadcrumbs={[{ label: 'Services', to: '/service' }, { label: service?.name ?? '…' }]}
                cta={{ to: '/contact', label: 'Get a free consultation' }}
            />

            <ServiceMarquee />

            <section className="py-12 md:py-20">
                <div className="container-site grid gap-10 lg:grid-cols-[minmax(0,1fr)_340px] lg:gap-14">
                    <div className="min-w-0">
                        {error ? (
                            <ErrorState message={error.message} onRetry={() => setAttempt((value) => value + 1)} />
                        ) : loading ? (
                            <div className="space-y-4">
                                <Skeleton className="h-8 w-2/3" />
                                <Skeleton className="h-4 w-full" />
                                <Skeleton className="h-4 w-full" />
                                <Skeleton className="h-4 w-5/6" />
                                <Skeleton className="h-64 w-full" />
                            </div>
                        ) : service.description ? (
                            // Sanitized server-side (HTMLPurifier) before it is stored.
                            <div className="rich-content" dangerouslySetInnerHTML={{ __html: service.description }} />
                        ) : (
                            <p className="leading-relaxed text-muted-foreground">{service.short_description}</p>
                        )}
                    </div>

                    <aside className="space-y-6 lg:sticky lg:top-28 lg:self-start">
                        <div className="rounded-2xl border bg-card p-6">
                            <h2 className="mb-4 text-xl font-bold">All Services</h2>
                            <ul className="space-y-1">
                                {site.services.map((item) => {
                                    const IconComponent = serviceIcon(item.slug);
                                    const current = item.slug === slug;

                                    return (
                                        <li key={item.slug}>
                                            <Link
                                                to={`/services/${item.slug}`}
                                                aria-current={current ? 'page' : undefined}
                                                className={`flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold transition-colors ${current ? 'bg-brand text-black' : 'text-white/70 hover:bg-white/5 hover:text-white'}`}
                                            >
                                                <IconComponent className="size-4 shrink-0" aria-hidden="true" />
                                                {item.name}
                                            </Link>
                                        </li>
                                    );
                                })}
                            </ul>
                        </div>

                        <div className="rounded-2xl border border-brand/30 bg-brand/10 p-6">
                            <h2 className="text-xl font-bold">Need help choosing?</h2>
                            <p className="mt-2 leading-relaxed text-foreground/85">
                                Tell us about your goals and we&rsquo;ll recommend the right mix of channels.
                            </p>
                            <a href="#contact" className="mt-4 inline-block font-semibold text-brand hover:text-brand-soft">
                                Talk to our team →
                            </a>
                        </div>
                    </aside>
                </div>
            </section>

            <FaqSection items={service?.faqs} text={service ? `Common questions about our ${service.name.toLowerCase()} work.` : undefined} />

            {others.length > 0 && (
                <section className="py-12 md:py-16">
                    <div className="container-site">
                        <h2 className="mb-8 text-2xl font-bold md:text-3xl">
                            Explore <span className="text-brand">other services</span>
                        </h2>
                        <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            {others.slice(0, 6).map((item) => {
                                const IconComponent = serviceIcon(item.slug);

                                return (
                                    <Link
                                        key={item.slug}
                                        to={`/services/${item.slug}`}
                                        className="flex items-center gap-4 rounded-2xl border bg-card p-5 transition-colors hover:border-brand/60"
                                    >
                                        <span className="flex size-12 shrink-0 items-center justify-center rounded-xl border border-brand/30 bg-brand/10 text-brand">
                                            <IconComponent className="size-5" aria-hidden="true" />
                                        </span>
                                        <span className="font-semibold">{item.name}</span>
                                    </Link>
                                );
                            })}
                        </div>
                    </div>
                </section>
            )}

            <ContactSection defaultSubject={service?.name} key={service?.name ?? 'pending'} />
        </>
    );
}
