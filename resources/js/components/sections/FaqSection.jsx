import Accordion from '../ui/Accordion';
import SectionHeading from '../ui/SectionHeading';

export default function FaqSection({
    items,
    title = 'Frequently Asked',
    accent = 'Questions',
    text = "We've gathered the most common questions clients ask before working with us. These quick, clear answers explain our process, services, and approach.",
}) {
    if (!items?.length) {
        return null;
    }

    return (
        <section className="overflow-hidden py-16 md:py-24">
            <div className="container-site">
                <SectionHeading title={title} accent={accent} text={text} />
                <div className="mx-auto max-w-5xl">
                    <Accordion items={items} />
                </div>
            </div>
        </section>
    );
}
