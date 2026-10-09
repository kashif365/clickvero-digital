import Icon from '../ui/Icon';
import Reveal from '../ui/Reveal';
import SectionHeading from '../ui/SectionHeading';

/** Four tall feature cards. `items` come from content/site.js. */
export default function Reasons({ title, accent, text, items }) {
    return (
        <section className="w-full bg-background py-16 lg:py-24">
            <div className="container-site">
                <SectionHeading title={title} accent={accent} text={text} />
                <div className="mx-auto grid max-w-6xl grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                    {items.map((item, index) => (
                        <Reveal
                            key={item.title}
                            delay={index * 80}
                            className="group relative flex min-h-[240px] flex-col overflow-hidden rounded-[30px] border border-white/10 bg-black p-6 transition-colors duration-300 hover:border-brand/60 lg:min-h-[400px]"
                        >
                            <div className="pointer-events-none absolute left-1/2 top-10 size-40 -translate-x-1/2 rounded-full bg-brand/0 blur-[60px] transition-colors duration-500 group-hover:bg-brand/15" />
                            <span className="absolute right-6 top-5 text-5xl font-bold text-white/[0.06]">{String(index + 1).padStart(2, '0')}</span>
                            <div className="mb-auto mt-6 flex size-14 lg:mt-10 items-center justify-center rounded-full bg-white text-black shadow-lg transition-colors duration-300 group-hover:bg-brand">
                                <Icon name={item.icon} className="size-6" />
                            </div>
                            <h3 className="mt-6 text-xl font-bold text-white">{item.title}</h3>
                            <p className="mt-3 leading-relaxed text-white/75">{item.text}</p>
                        </Reveal>
                    ))}
                </div>
            </div>
        </section>
    );
}
