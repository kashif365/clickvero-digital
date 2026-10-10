import Accordion from '../ui/Accordion';
import SectionHeading from '../ui/SectionHeading';

export default function FaqSection({
    items,
    columns = false,
    title = 'Frequently Asked',
    accent = 'Questions',
    text = "We've gathered the most common questions clients ask before working with us. These quick, clear answers explain our process, services, and approach.",
}) {
    if (!items?.length) {
        return null;
    }

    // Long lists split into two columns on large screens to halve the scroll.
    const half = Math.ceil(items.length / 2);

    return (
        <section className="overflow-hidden py-16 md:py-24">
            <div className="container-site">
                <SectionHeading title={title} accent={accent} text={text} />
                {columns ? (
                    <div className="grid items-start gap-4 lg:grid-cols-2 lg:gap-6">
                        <Accordion items={items.slice(0, half)} />
                        <Accordion items={items.slice(half)} defaultOpen={-1} />
                    </div>
                ) : (
                    <div className="mx-auto max-w-5xl">
                        <Accordion items={items} />
                    </div>
                )}
            </div>
        </section>
    );
}
