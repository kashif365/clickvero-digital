import { ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';
import { projects } from '../../content/site';
import Reveal from '../ui/Reveal';

export function ProjectCard({ project }) {
    return (
        <Link to={`/project-details?case=${project.slug}`} className="group block h-full">
            <article className="flex h-full flex-col rounded-2xl border-2 border-transparent bg-card p-5 transition-[border-color,box-shadow] duration-300 hover:border-brand hover:shadow-lg md:p-8">
                <div className="relative mb-6 aspect-[4/3] w-full overflow-hidden rounded-xl">
                    <img
                        src={project.image}
                        alt=""
                        loading="lazy"
                        className="size-full object-cover transition-transform duration-500 group-hover:scale-105"
                    />
                </div>
                <p className="mb-2 text-sm font-medium text-brand">{project.category}</p>
                <h3 className="mb-3 text-xl font-bold md:text-2xl">{project.title}</h3>
                <p className="flex-1 leading-relaxed text-foreground/85">{project.text}</p>
                <span className="mt-5 inline-flex items-center gap-2 font-semibold text-brand">
                    See the playbook
                    <ArrowRight className="size-4 transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" />
                </span>
            </article>
        </Link>
    );
}

export default function ProjectsGrid({ items = projects, columns = 'md:grid-cols-2' }) {
    return (
        <div className={`grid grid-cols-1 gap-6 md:gap-8 ${columns}`}>
            {items.map((project, index) => (
                <Reveal key={project.slug} delay={(index % 3) * 80}>
                    <ProjectCard project={project} />
                </Reveal>
            ))}
        </div>
    );
}
