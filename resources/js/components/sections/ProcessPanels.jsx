import { useState } from 'react';
import { home, processSteps } from '../../content/site';
import Accordion from '../ui/Accordion';
import SectionHeading from '../ui/SectionHeading';

/**
 * Horizontal expanding panels: collapsed panels show a number and a vertical
 * title; the active one opens to reveal its description. Becomes an accordion
 * on small screens.
 */
export default function ProcessPanels() {
    const [active, setActive] = useState(0);

    return (
        <section className="relative overflow-hidden py-10 lg:py-20">
            <div className="container-site">
                <SectionHeading title={home.process.title} accent={home.process.accent} text={home.process.text} />

                <div className="hidden h-[560px] w-full gap-2 overflow-hidden rounded-lg md:flex">
                    {processSteps.map((step, index) => {
                        const open = index === active;

                        return (
                            <button
                                key={step.title}
                                type="button"
                                aria-expanded={open}
                                onClick={() => setActive(index)}
                                onMouseEnter={() => setActive(index)}
                                onFocus={() => setActive(index)}
                                className={`relative overflow-hidden rounded-lg text-left transition-all duration-500 ${open ? 'flex-[5]' : 'flex-1'}`}
                            >
                                <img src={step.image} alt="" loading="lazy" className="absolute inset-0 size-full object-cover" />
                                <span className={`absolute inset-0 transition-colors duration-500 ${open ? 'bg-black/70' : 'bg-black/80'}`} />

                                <span className="absolute left-1/2 top-6 -translate-x-1/2 text-3xl font-extrabold tracking-widest text-white/70">
                                    {String(index + 1).padStart(2, '0')}
                                </span>

                                {open ? (
                                    <span className="relative z-10 flex h-full animate-fade-up flex-col justify-center gap-4 p-8 lg:p-12">
                                        <span className="text-sm font-semibold uppercase tracking-widest text-white/70">Step {String(index + 1).padStart(2, '0')}</span>
                                        <span className="text-2xl font-bold text-brand lg:text-4xl">{step.title}</span>
                                        <span className="max-w-lg leading-relaxed text-white">{step.text}</span>
                                    </span>
                                ) : (
                                    <span className="relative z-10 flex h-full items-center justify-center px-4 pb-6 pt-20">
                                        <span className="vertical-text max-h-full rotate-180 text-center text-xl font-bold leading-tight text-white lg:text-2xl">
                                            {step.title}
                                        </span>
                                    </span>
                                )}
                            </button>
                        );
                    })}
                </div>

                <div className="md:hidden">
                    <Accordion items={processSteps.map((step, index) => ({ question: `${index + 1}. ${step.title}`, answer: step.text }))} />
                </div>
            </div>
        </section>
    );
}
