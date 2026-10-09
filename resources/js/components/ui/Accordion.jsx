import { ChevronDown } from 'lucide-react';
import { useId, useState } from 'react';

/** Single-open accordion; the open item inverts to a black panel. */
export default function Accordion({ items, defaultOpen = 0 }) {
    const [open, setOpen] = useState(defaultOpen);
    const baseId = useId();

    return (
        <div className="space-y-4">
            {items.map((item, index) => {
                const isOpen = open === index;
                const panelId = `${baseId}-panel-${index}`;

                return (
                    <div
                        key={item.question}
                        className={`rounded-lg border px-6 transition-colors ${isOpen ? 'border-brand/40 bg-black text-white' : 'bg-card/40'}`}
                    >
                        <h3>
                            <button
                                type="button"
                                aria-expanded={isOpen}
                                aria-controls={panelId}
                                onClick={() => setOpen(isOpen ? -1 : index)}
                                className="flex w-full items-start justify-between gap-4 py-5 text-left text-lg font-medium md:text-xl"
                            >
                                {item.question}
                                <ChevronDown
                                    className={`mt-1 size-5 shrink-0 text-brand transition-transform duration-300 ${isOpen ? 'rotate-180' : ''}`}
                                    aria-hidden="true"
                                />
                            </button>
                        </h3>
                        <div
                            id={panelId}
                            role="region"
                            className={`grid transition-[grid-template-rows] duration-300 ${isOpen ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'}`}
                        >
                            <div className="overflow-hidden">
                                <p className="pb-6 pt-1 leading-relaxed text-foreground/85">{item.answer}</p>
                            </div>
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
