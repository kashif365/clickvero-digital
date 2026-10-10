import Button from '../ui/Button';
import Reveal from '../ui/Reveal';

/** Large rounded banner: copy and a call-to-action on the left, a framed image on the right. `text` is a string or an array of paragraphs. */
export default function FeatureBanner({ heading, title, accent, text, image, imageAlt, cta }) {
    return (
        <section className="py-10 md:py-20">
            <div className="container-site">
                {heading}
                <Reveal className="relative flex min-h-[400px] w-full flex-col items-stretch overflow-hidden rounded-[30px] border border-white/10 bg-[linear-gradient(120deg,#1c1a10_0%,#111111_45%,#0a0a0a_100%)] lg:flex-row xl:min-h-[520px]">
                    <div className="pointer-events-none absolute -left-32 -top-32 size-[420px] rounded-full bg-brand/15 blur-[140px]" />

                    <div className="relative z-10 flex flex-1 flex-col justify-center px-6 pb-2 pt-10 sm:px-8 lg:max-w-[50%] lg:px-16 lg:py-10">
                        <h3 className="mb-6 text-2xl font-bold leading-tight text-white md:text-3xl lg:text-4xl">
                            {title} {accent && <span className="text-brand">{accent}</span>}
                        </h3>
                        <div className="mb-8 max-w-2xl space-y-4">
                            {[text].flat().map((paragraph, index) => (
                                <p key={paragraph} className={`leading-relaxed ${index === 0 ? 'text-white' : 'text-white/75'}`}>
                                    {paragraph}
                                </p>
                            ))}
                        </div>
                        {cta && (
                            <div>
                                <Button to={cta.to}>{cta.label}</Button>
                            </div>
                        )}
                    </div>

                    <div className="relative z-10 flex flex-1 items-center justify-center p-6 lg:p-10">
                        <img
                            src={image}
                            alt={imageAlt}
                            loading="lazy"
                            className="aspect-[4/3] w-full max-w-[620px] rounded-[24px] object-cover shadow-2xl"
                        />
                    </div>
                </Reveal>
            </div>
        </section>
    );
}
