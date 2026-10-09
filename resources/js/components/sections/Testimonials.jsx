import { Quote } from 'lucide-react';
import { api } from '../../lib/api';
import { useAsync } from '../../lib/hooks';
import SectionHeading from '../ui/SectionHeading';

function initials(name) {
    return name
        .split(' ')
        .map((part) => part[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();
}

function Card({ item, className = '' }) {
    return (
        <figure className={`flex flex-col rounded-2xl border bg-card p-6 transition-shadow duration-300 hover:shadow-lg md:p-8 ${className}`}>
            <Quote className="mb-4 size-7 text-brand" aria-hidden="true" />
            <blockquote className="mb-8 flex-1 leading-relaxed text-foreground/90">&ldquo;{item.quote}&rdquo;</blockquote>
            <figcaption className="flex items-center gap-4">
                <span className="flex size-12 shrink-0 items-center justify-center rounded-full bg-brand font-bold text-black" aria-hidden="true">
                    {initials(item.name)}
                </span>
                <span>
                    <span className="block font-bold">{item.name}</span>
                    {item.role && <span className="block text-sm text-muted-foreground">{item.role}</span>}
                </span>
            </figcaption>
        </figure>
    );
}

/**
 * Client testimonials managed in the admin panel. The whole section stays
 * hidden until at least one is published. Three or more scroll as a marquee;
 * fewer are shown as a static row.
 */
export default function Testimonials() {
    const { data } = useAsync((signal) => api.testimonials(signal), []);
    const items = data?.data ?? [];

    if (items.length === 0) {
        return null;
    }

    const scrolling = items.length >= 3;
    // Two identical halves let the track loop seamlessly at -50%.
    const half = scrolling ? [...items, ...items] : items;

    return (
        <section className="overflow-hidden bg-[#D9D9D9]/[0.06] py-16 md:py-24">
            <div className="container-site">
                <SectionHeading title="What clients say" accent="about working with us" />
                {!scrolling && (
                    <div className="mx-auto grid max-w-5xl gap-6 md:grid-cols-2">
                        {items.map((item) => (
                            <Card key={item.id} item={item} />
                        ))}
                    </div>
                )}
            </div>
            {scrolling && (
                <div className="marquee-track flex w-max animate-marquee">
                    {[0, 1].map((copy) => (
                        <div key={copy} className="flex shrink-0 gap-4 pr-4 md:gap-6 md:pr-6" aria-hidden={copy === 1}>
                            {half.map((item, index) => (
                                <Card key={`${item.id}-${index}`} item={item} className="w-[300px] shrink-0 md:w-[520px]" />
                            ))}
                        </div>
                    ))}
                </div>
            )}
        </section>
    );
}
