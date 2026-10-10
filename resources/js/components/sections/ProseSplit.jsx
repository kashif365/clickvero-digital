import Reveal from '../ui/Reveal';

/**
 * Two-column editorial section: a heading and paragraphs on one side, and a
 * supporting panel (`children`) on the other. `reverse` swaps the sides on
 * large screens so consecutive sections alternate.
 */
export default function ProseSplit({ title, accent, paragraphs, reverse = false, children }) {
    return (
        <section className="py-12 md:py-20">
            <div className="container-site grid items-center gap-10 lg:grid-cols-2 lg:gap-16 xl:gap-24">
                <Reveal className={reverse ? 'lg:order-2' : ''}>
                    <h2 className="text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">
                        {title} {accent && <span className="text-brand">{accent}</span>}
                    </h2>
                    <div className="mt-6 space-y-4">
                        {paragraphs.map((paragraph) => (
                            <p key={paragraph} className="leading-relaxed text-muted-foreground">
                                {paragraph}
                            </p>
                        ))}
                    </div>
                </Reveal>
                <Reveal delay={100}>{children}</Reveal>
            </div>
        </section>
    );
}
