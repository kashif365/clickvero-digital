import { useState } from 'react';
import { toolStack } from '../../content/site';

/** Tabbed grid of the channels and tools the team works with. */
export default function ToolStack() {
    const [active, setActive] = useState(0);

    const onKeyDown = (event) => {
        const step = { ArrowRight: 1, ArrowLeft: -1 }[event.key];

        if (step) {
            const next = (active + step + toolStack.length) % toolStack.length;

            setActive(next);
            document.getElementById(`tools-tab-${next}`)?.focus();
        }
    };

    return (
        <section className="relative overflow-hidden bg-background py-16 text-white md:py-24">
            <div className="pointer-events-none absolute left-1/2 top-[-250px] h-[500px] w-[900px] -translate-x-1/2 rounded-full bg-brand/[0.04] blur-[150px]" />
            <div className="pointer-events-none absolute bottom-[-200px] right-[-150px] size-[450px] rounded-full bg-brand/[0.025] blur-[130px]" />

            <div className="container-site relative">
                <div className="mx-auto mb-12 max-w-[950px] text-center md:mb-16">
                    <h2 className="text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">
                        Channels &amp; Tools <span className="text-brand">We Work With</span>
                    </h2>
                    <p className="mx-auto mt-5 max-w-[820px] text-[14px] leading-[1.7] sm:text-[16px] lg:text-[18px]">
                        We use proven, production-tested platforms across every part of your marketing — from search and paid media to analytics,
                        email, and the website they all point to.
                    </p>
                </div>

                <div className="mb-10 overflow-hidden rounded-[16px] border border-[#292929] bg-[#111111] shadow-[0_20px_60px_rgba(0,0,0,0.35)] md:mb-14">
                    <div role="tablist" aria-label="Tool categories" className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6" onKeyDown={onKeyDown}>
                        {toolStack.map((group, index) => {
                            const selected = index === active;

                            return (
                                <button
                                    key={group.tab}
                                    id={`tools-tab-${index}`}
                                    type="button"
                                    role="tab"
                                    aria-selected={selected}
                                    aria-controls="tools-panel"
                                    tabIndex={selected ? 0 : -1}
                                    onClick={() => setActive(index)}
                                    className={`relative min-h-[60px] border-[#292929] px-3 py-4 text-[12px] font-medium transition-colors duration-300 sm:text-[14px] lg:min-h-[70px] lg:text-[15px] ${selected ? 'bg-[#181818] text-white' : 'bg-[#111111] text-[#777777] hover:bg-[#151515] hover:text-white'}`}
                                >
                                    {group.tab}
                                    {selected && <span className="absolute inset-x-0 bottom-0 h-[3px] bg-brand" />}
                                </button>
                            );
                        })}
                    </div>
                </div>

                <div
                    id="tools-panel"
                    role="tabpanel"
                    aria-labelledby={`tools-tab-${active}`}
                    key={active}
                    className="grid animate-fade-up grid-cols-2 gap-4 sm:grid-cols-3 sm:gap-5 lg:grid-cols-6"
                >
                    {toolStack[active].items.map((item) => (
                        <div
                            key={item}
                            className="group relative flex min-h-[150px] flex-col items-center justify-center overflow-hidden rounded-[18px] border border-[#292929] bg-[#111111] p-5 transition-colors duration-300 hover:border-brand/60 hover:bg-[#171717] sm:min-h-[170px]"
                        >
                            <div className="pointer-events-none absolute inset-x-[20%] top-0 h-px bg-linear-to-r from-transparent via-white/10 to-transparent" />
                            <span
                                className="flex size-14 items-center justify-center rounded-2xl border border-brand/30 bg-brand/10 text-xl font-bold text-brand transition-transform duration-300 group-hover:scale-110"
                                aria-hidden="true"
                            >
                                {item[0]}
                            </span>
                            <span className="mt-5 text-center text-[13px] font-medium text-[#D8D8D8] transition-colors duration-300 group-hover:text-brand sm:text-[15px]">
                                {item}
                            </span>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
