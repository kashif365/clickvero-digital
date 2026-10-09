import Reveal from './Reveal';

/**
 * Section title in the site's two-tone style: plain text followed by a
 * yellow-accented phrase, with an optional supporting paragraph.
 */
export default function SectionHeading({ title, accent, text, align = 'center', as: Tag = 'h2', className = '' }) {
    const alignment = align === 'center' ? 'mx-auto items-center text-center' : 'items-start text-left';

    return (
        <Reveal className={`mb-10 flex max-w-4xl flex-col gap-4 lg:mb-16 ${alignment} ${className}`}>
            <Tag className="text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">
                {title} {accent && <span className="text-brand">{accent}</span>}
            </Tag>
            {text && <p className="max-w-3xl leading-relaxed text-muted-foreground">{text}</p>}
        </Reveal>
    );
}
