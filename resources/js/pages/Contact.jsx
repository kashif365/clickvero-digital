import ContactSection from '../components/sections/ContactSection';
import FaqSection from '../components/sections/FaqSection';
import PageHero from '../components/sections/PageHero';
import { faqGroups, images } from '../content/site';

export default function Contact() {
    return (
        <>
            <PageHero
                image={images.strategy}
                eyebrow="Contact us"
                title="Let's Talk About"
                accent="Your Growth"
                text="Get in touch for a free consultation. We work with clients remotely, wherever in the world you're based."
                breadcrumbs={[{ label: 'Contact' }]}
            />
            <ContactSection />
            <FaqSection items={faqGroups[2].items} title="Before you" accent="get in touch" text="A few practical answers about pricing and getting started." />
        </>
    );
}
