import { home } from '../../content/site';
import Icon from '../ui/Icon';
import Reveal from '../ui/Reveal';
import SectionHeading from '../ui/SectionHeading';

/** "Results that matter": the outcomes clients experience, as a grid of icon tiles. */
export default function Outcomes() {
    const { results } = home;

    return (
        <section className="relative overflow-hidden py-12 md:py-20">
            <div className="pointer-events-none absolute -right-52 top-10 size-[460px] rounded-full bg-brand/10 blur-[170px]" />
            <div className="container-site relative">
                <SectionHeading title={results.title} accent={results.accent} text={results.text} />

                <p className="mb-6 text-center text-sm font-semibold uppercase tracking-widest text-brand">{results.label}</p>
                <div className="mx-auto grid max-w-6xl grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-3 lg:gap-6">
                    {results.items.map((item, index) => (
                        <Reveal
                            key={item.title}
                            delay={index * 60}
                            className="group flex flex-col gap-4 rounded-2xl border bg-card/50 p-4 transition-[background-color,border-color] duration-300 hover:border-brand hover:bg-card sm:flex-row sm:items-center sm:p-6"
                        >
                            <div className="size-12 shrink-0 rounded-xl bg-linear-to-br from-yellow-500 to-orange-500 p-0.5 transition-transform group-hover:scale-110">
                                <div className="flex size-full items-center justify-center rounded-[10px] bg-background">
                                    <Icon name={item.icon} className="size-5 text-brand" />
                                </div>
                            </div>
                            <h3 className="font-semibold leading-snug sm:text-lg">{item.title}</h3>
                        </Reveal>
                    ))}
                </div>

                <Reveal as="p" className="mx-auto mt-10 max-w-3xl text-center text-lg font-medium leading-relaxed text-white md:mt-14 md:text-xl">
                    {results.promise}
                </Reveal>
            </div>
        </section>
    );
}
