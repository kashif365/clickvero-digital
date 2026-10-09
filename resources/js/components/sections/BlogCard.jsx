import { ArrowUpRight } from 'lucide-react';
import { Link } from 'react-router-dom';
import { formatDate, useSite } from '../../lib/site';
import { Skeleton } from '../ui/States';

export default function BlogCard({ blog }) {
    const site = useSite();

    return (
        <Link to={`/blog-details/${blog.slug}`} className="group block h-full">
            <article className="relative flex h-full flex-col overflow-hidden rounded-2xl border bg-card transition-colors duration-300 hover:border-brand/60">
                <div className="absolute right-4 top-4 z-10 flex size-10 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur-sm transition-all duration-300 group-hover:-translate-y-1 group-hover:translate-x-1 group-hover:bg-brand group-hover:text-black">
                    <ArrowUpRight className="size-5" aria-hidden="true" />
                </div>
                <div className="relative h-48 w-full overflow-hidden bg-gray-800 md:h-56">
                    {blog.image && (
                        <img
                            src={blog.image}
                            alt=""
                            loading="lazy"
                            className="size-full object-cover transition-transform duration-300 group-hover:scale-105"
                        />
                    )}
                </div>
                <div className="flex flex-1 flex-col p-6 md:p-8">
                    {blog.category && <p className="mb-4 text-sm text-brand">{blog.category}</p>}
                    <h3 className="mb-4 line-clamp-2 text-lg font-semibold leading-tight md:text-xl">{blog.title}</h3>
                    {blog.excerpt && <p className="mb-6 line-clamp-3 flex-1 text-sm leading-relaxed text-foreground/80">{blog.excerpt}</p>}
                    <div className="mt-auto flex flex-wrap items-center gap-x-6 gap-y-1 border-t pt-4 text-sm">
                        <span className="font-medium text-brand">{blog.author || site.name}</span>
                        <time dateTime={blog.published_at} className="text-muted-foreground">
                            {formatDate(blog.published_at)}
                        </time>
                    </div>
                </div>
            </article>
        </Link>
    );
}

export function BlogCardSkeleton() {
    return (
        <div className="overflow-hidden rounded-2xl border bg-card">
            <Skeleton className="h-48 rounded-none md:h-56" />
            <div className="space-y-4 p-6 md:p-8">
                <Skeleton className="h-4 w-24" />
                <Skeleton className="h-6 w-full" />
                <Skeleton className="h-4 w-5/6" />
                <Skeleton className="h-4 w-2/3" />
            </div>
        </div>
    );
}
