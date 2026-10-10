import { Check } from 'lucide-react';
import { whyChoose } from '../../content/site';
import { useSite } from '../../lib/site';
import Icon from '../ui/Icon';
import Reveal from '../ui/Reveal';
import SectionHeading from '../ui/SectionHeading';

/** Five reason cards plus a highlighted "what makes us different" checklist, laid out as a six-cell grid. */
export default function WhyChoose() {
    const site = useSite();

    return (
        <section className="w-full bg-background py-12 md:py-20">
            <div className="container-site">
                <SectionHeading title="Why Businesses Choose" accent={site.name} text={whyChoose.text} />

                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
                    {whyChoose.reasons.map((reason, index) => (
                        <Reveal
                            key={reason.title}
                            delay={index * 80}
                            className="group relative flex flex-col overflow-hidden rounded-[30px] border border-white/10 bg-black p-6 transition-colors duration-300 hover:border-brand/60 md:p-8"
                        >
                            <div className="pointer-events-none absolute left-10 top-6 size-40 rounded-full bg-brand/0 blur-[60px] transition-colors duration-500 group-hover:bg-brand/15" />
                            <span className="absolute right-6 top-5 text-5xl font-bold text-white/[0.06]">{String(index + 1).padStart(2, '0')}</span>
                            <div className="relative flex size-14 items-center justify-center rounded-full bg-white text-black shadow-lg transition-colors duration-300 group-hover:bg-brand">
                                <Icon name={reason.icon} className="size-6" />
                            </div>
                            <h3 className="relative mt-6 text-xl font-bold text-white">{reason.title}</h3>
                            <p className="relative mt-3 leading-relaxed text-white/75">{reason.text}</p>
                        </Reveal>
                    ))}

                    <Reveal delay={whyChoose.reasons.length * 80} className="flex flex-col rounded-[30px] bg-brand p-6 text-black md:p-8">
                        <h3 className="text-xl font-bold">What Makes Us Different?</h3>
                        <ul className="mt-5 space-y-3">
                            {whyChoose.differentiators.map((item) => (
                                <li key={item} className="flex items-start gap-3 font-medium">
                                    <span className="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-black text-brand">
                                        <Check className="size-3" strokeWidth={3} aria-hidden="true" />
                                    </span>
                                    {item}
                                </li>
                            ))}
                        </ul>
                    </Reveal>
                </div>

                <Reveal as="p" className="mx-auto mt-10 max-w-3xl text-center text-lg font-medium leading-relaxed text-white md:mt-14 md:text-xl">
                    {whyChoose.goal}
                </Reveal>
            </div>
        </section>
    );
}
