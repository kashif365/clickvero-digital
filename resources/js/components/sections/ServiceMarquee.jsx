import { ArrowUpRight } from 'lucide-react';
import { Link } from 'react-router-dom';
import { serviceIcon, useSite } from '../../lib/site';

/** Continuously scrolling strip of service pills; pauses on hover. */
export default function ServiceMarquee() {
    const { services } = useSite();

    if (services.length === 0) {
        return null;
    }

    // Repeat the list so the track is wide enough to loop seamlessly at -50%.
    const repeats = Math.max(2, Math.ceil(12 / services.length));
    const half = Array.from({ length: repeats }, () => services).flat();

    return (
        <section aria-label="Our services" className="w-full overflow-hidden bg-background px-4 py-4 lg:px-8">
            <div className="marquee-track flex w-max animate-marquee">
                {[0, 1].map((copy) => (
                    <div key={copy} className="flex shrink-0 gap-4 pr-4" aria-hidden={copy === 1}>
                        {half.map((service, index) => {
                            const IconComponent = serviceIcon(service.slug);

                            return (
                                <Link
                                    key={`${service.slug}-${index}`}
                                    to={`/services/${service.slug}`}
                                    tabIndex={copy === 1 || index >= services.length ? -1 : undefined}
                                    className="flex h-[66px] w-[342px] shrink-0 items-center justify-between rounded-[24px] bg-[linear-gradient(90deg,#050505_0%,#272727_100%)] px-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(0,0,0,0.35)]"
                                >
                                    <span className="flex min-w-0 items-center gap-[18px]">
                                        <IconComponent className="size-[26px] shrink-0 text-brand" aria-hidden="true" />
                                        <span className="truncate text-[17px] font-medium tracking-[-0.03em] text-white">{service.name}</span>
                                    </span>
                                    <ArrowUpRight className="ml-4 size-5 shrink-0 text-white/60" aria-hidden="true" />
                                </Link>
                            );
                        })}
                    </div>
                ))}
            </div>
        </section>
    );
}
