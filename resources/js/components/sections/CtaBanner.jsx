import Button from '../ui/Button';
import Reveal from '../ui/Reveal';

/** Closing call-to-action: a centered, glowing panel with supporting copy and one button. */
export default function CtaBanner({ eyebrow, title, accent, paragraphs, cta }) {
    return (
        <section className="py-12 md:py-20">
            <div className="container-site">
                <Reveal className="relative overflow-hidden rounded-[30px] border border-brand/30 bg-[linear-gradient(120deg,#1c1a10_0%,#111111_45%,#0a0a0a_100%)] px-6 py-12 text-center sm:px-10 md:py-16 lg:px-16">
                    <div className="pointer-events-none absolute left-1/2 top-0 h-[220px] w-[70%] -translate-x-1/2 rounded-full bg-brand/15 blur-[110px]" />

                    <div className="relative mx-auto max-w-4xl">
                        {eyebrow && <p className="mb-4 text-sm font-semibold uppercase tracking-widest text-brand">{eyebrow}</p>}
                        <h2 className="text-2xl font-bold leading-tight text-white md:text-3xl lg:text-5xl">
                            {title} {accent && <span className="text-brand">{accent}</span>}
                        </h2>
                        <div className="mt-6 space-y-4 text-left sm:text-center">
                            {paragraphs.map((paragraph) => (
                                <p key={paragraph} className="leading-relaxed text-white/80">
                                    {paragraph}
                                </p>
                            ))}
                        </div>
                        <div className="mt-8 flex justify-center">
                            <Button to={cta.to}>{cta.label}</Button>
                        </div>
                    </div>
                </Reveal>
            </div>
        </section>
    );
}
