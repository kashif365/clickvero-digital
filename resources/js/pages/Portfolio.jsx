import ContactSection from '../components/sections/ContactSection';
import PageHero from '../components/sections/PageHero';
import ProjectsGrid from '../components/sections/ProjectsGrid';
import ServiceMarquee from '../components/sections/ServiceMarquee';
import Testimonials from '../components/sections/Testimonials';
import WorkGallery from '../components/sections/WorkGallery';
import SectionHeading from '../components/ui/SectionHeading';
import { images, projects } from '../content/site';

export default function Portfolio() {
    return (
        <>
            <PageHero
                image={images.campaign}
                eyebrow="Our work"
                title="A Portfolio Built With"
                accent="Purpose and Performance"
                text="Websites, online stores, brand identities, and mobile apps we've designed and built for businesses across the USA — each one made to look sharp and drive results."
                breadcrumbs={[{ label: 'Portfolio' }]}
                cta={{ to: '/contact', label: 'Start Your Project' }}
            />

            <ServiceMarquee />

            <section className="py-12 md:py-20">
                <div className="container-site">
                    <SectionHeading
                        title="Establishing a Strong"
                        accent="Digital Portfolio"
                        text="Browse by category and open any project to see the full design — website screenshots scroll top to bottom so you can see every section."
                    />
                    <WorkGallery />
                </div>
            </section>

            <section className="py-12 md:py-20">
                <div className="container-site">
                    <SectionHeading
                        title="Growth"
                        accent="Playbooks"
                        text="How we approach the situations growing businesses bring to us most often — the problem, the plan, and the numbers we use to judge success."
                    />
                    <ProjectsGrid items={projects} columns="md:grid-cols-2 lg:grid-cols-3" />
                </div>
            </section>

            <Testimonials />
            <ContactSection />
        </>
    );
}
