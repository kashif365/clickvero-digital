import { useState } from 'react';
import ContactSection from '../components/sections/ContactSection';
import PageHero from '../components/sections/PageHero';
import ProjectsGrid from '../components/sections/ProjectsGrid';
import ServiceMarquee from '../components/sections/ServiceMarquee';
import Testimonials from '../components/sections/Testimonials';
import { images, projects } from '../content/site';

const CATEGORIES = ['All', ...new Set(projects.map((project) => project.category))];

export default function Portfolio() {
    const [category, setCategory] = useState('All');
    const visible = category === 'All' ? projects : projects.filter((project) => project.category === category);

    return (
        <>
            <PageHero
                image={images.campaign}
                eyebrow="Our work"
                title="Playbooks Built With"
                accent="Purpose and Performance"
                text="How we approach the situations growing businesses bring to us most often — the problem, the plan, and the numbers we use to judge success."
                breadcrumbs={[{ label: 'Portfolio' }]}
                cta={{ to: '/contact', label: 'Book A Discovery Call' }}
            />

            <ServiceMarquee />

            <section className="py-12 md:py-20">
                <div className="container-site">
                    <div
                        role="group"
                        aria-label="Filter by category"
                        className="-mx-4 mb-10 flex gap-2 overflow-x-auto px-4 pb-2 [scrollbar-width:none] sm:mx-0 sm:flex-wrap sm:justify-center sm:px-0 [&::-webkit-scrollbar]:hidden"
                    >
                        {CATEGORIES.map((item) => (
                            <button
                                key={item}
                                type="button"
                                aria-pressed={item === category}
                                onClick={() => setCategory(item)}
                                className={`shrink-0 rounded-full border px-5 py-2.5 text-sm font-medium transition-colors ${item === category ? 'border-brand bg-brand text-black' : 'bg-card hover:border-brand/60 hover:text-brand'}`}
                            >
                                {item}
                            </button>
                        ))}
                    </div>
                    <ProjectsGrid key={category} items={visible} columns="md:grid-cols-2 lg:grid-cols-3" />
                </div>
            </section>

            <Testimonials />
            <ContactSection />
        </>
    );
}
