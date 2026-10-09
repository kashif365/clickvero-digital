import { Check } from 'lucide-react';
import { useSearchParams } from 'react-router-dom';
import ContactSection from '../components/sections/ContactSection';
import PageHero from '../components/sections/PageHero';
import ProjectsGrid from '../components/sections/ProjectsGrid';
import { projects } from '../content/site';

function List({ title, items }) {
    return (
        <div className="rounded-2xl border bg-card p-6 md:p-8">
            <h2 className="mb-5 text-xl font-bold">{title}</h2>
            <ul className="space-y-3">
                {items.map((item) => (
                    <li key={item} className="flex items-start gap-3 leading-relaxed">
                        <Check className="mt-1 size-4 shrink-0 text-brand" aria-hidden="true" />
                        {item}
                    </li>
                ))}
            </ul>
        </div>
    );
}

/** Playbook detail, selected with ?case=<slug>; falls back to the first playbook. */
export default function ProjectDetail() {
    const [params] = useSearchParams();
    const project = projects.find((item) => item.slug === params.get('case')) ?? projects[0];
    const others = projects.filter((item) => item.slug !== project.slug).slice(0, 3);

    return (
        <>
            <PageHero
                image={project.image}
                eyebrow={`${project.category} playbook`}
                title={project.title}
                text={project.text}
                breadcrumbs={[{ label: 'Portfolio', to: '/project' }, { label: project.title }]}
            />

            <section className="py-12 md:py-20">
                <div className="container-site grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px] lg:gap-14">
                    <div className="min-w-0">
                        <h2 className="text-2xl font-bold leading-tight md:text-3xl">
                            The <span className="text-brand">situation</span>
                        </h2>
                        <p className="mt-4 text-lg leading-relaxed text-foreground/85">{project.situation}</p>

                        <h2 className="mt-12 text-2xl font-bold leading-tight md:text-3xl">
                            Our <span className="text-brand">approach</span>
                        </h2>
                        <ol className="mt-6 space-y-4">
                            {project.approach.map((step, index) => (
                                <li key={step} className="flex gap-4 rounded-2xl border bg-card/50 p-5">
                                    <span className="flex size-10 shrink-0 items-center justify-center rounded-xl border border-brand/40 bg-brand/10 font-bold text-brand">
                                        {index + 1}
                                    </span>
                                    <span className="pt-1.5 leading-relaxed">{step}</span>
                                </li>
                            ))}
                        </ol>
                    </div>

                    <aside className="space-y-6 lg:sticky lg:top-28 lg:self-start">
                        <List title="What we deliver" items={project.deliverables} />
                        <List title="How we measure success" items={project.measures} />
                    </aside>
                </div>
            </section>

            <section className="py-12 md:py-16">
                <div className="container-site">
                    <h2 className="mb-8 text-2xl font-bold md:text-3xl">
                        More <span className="text-brand">playbooks</span>
                    </h2>
                    <ProjectsGrid key={project.slug} items={others} columns="md:grid-cols-3" />
                </div>
            </section>

            <ContactSection />
        </>
    );
}
