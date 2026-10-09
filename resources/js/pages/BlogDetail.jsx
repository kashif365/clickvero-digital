import { ArrowLeft, CalendarDays, UserRound } from 'lucide-react';
import { useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import BlogCard from '../components/sections/BlogCard';
import ContactSection from '../components/sections/ContactSection';
import { ErrorState, Skeleton } from '../components/ui/States';
import { api } from '../lib/api';
import { useAsync } from '../lib/hooks';
import { formatDate, useSite } from '../lib/site';
import NotFound from './NotFound';

export default function BlogDetail() {
    const { slug } = useParams();
    const site = useSite();
    const [attempt, setAttempt] = useState(0);
    const { data, error, loading } = useAsync((signal) => api.blog(slug, signal), [slug, attempt]);
    const blog = data?.data;
    const related = data?.related ?? [];

    if (error?.status === 404) {
        return <NotFound />;
    }

    return (
        <>
            <article className="pb-12 pt-28 md:pb-16 md:pt-32">
                <div className="container-site">
                    <div className="mx-auto max-w-4xl">
                        <Link to="/blog" className="mb-6 inline-flex items-center gap-2 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-brand">
                            <ArrowLeft className="size-4" aria-hidden="true" />
                            Back to all articles
                        </Link>

                        {error ? (
                            <ErrorState message={error.message} onRetry={() => setAttempt((value) => value + 1)} />
                        ) : loading ? (
                            <div className="space-y-5">
                                <Skeleton className="h-4 w-32" />
                                <Skeleton className="h-10 w-full" />
                                <Skeleton className="h-10 w-2/3" />
                                <Skeleton className="aspect-[16/9] w-full" />
                                <Skeleton className="h-4 w-full" />
                                <Skeleton className="h-4 w-full" />
                                <Skeleton className="h-4 w-4/5" />
                            </div>
                        ) : (
                            <>
                                <header>
                                    {blog.category && (
                                        <Link
                                            to={`/blog?category=${encodeURIComponent(blog.category)}`}
                                            className="inline-block rounded-full border border-brand/40 bg-brand/10 px-4 py-1.5 text-sm font-medium text-brand hover:bg-brand/20"
                                        >
                                            {blog.category}
                                        </Link>
                                    )}
                                    <h1 className="mt-5 text-3xl font-bold leading-tight md:text-4xl lg:text-5xl">{blog.title}</h1>
                                    <div className="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-muted-foreground">
                                        <span className="flex items-center gap-2">
                                            <UserRound className="size-4 text-brand" aria-hidden="true" />
                                            {blog.author || site.name}
                                        </span>
                                        <time dateTime={blog.published_at} className="flex items-center gap-2">
                                            <CalendarDays className="size-4 text-brand" aria-hidden="true" />
                                            {formatDate(blog.published_at)}
                                        </time>
                                    </div>
                                </header>

                                {blog.image && (
                                    <img src={blog.image} alt="" className="mt-8 aspect-[16/9] w-full rounded-2xl object-cover" fetchPriority="high" />
                                )}

                                {/* Sanitized server-side (HTMLPurifier) before it is stored. */}
                                <div className="rich-content mt-10" dangerouslySetInnerHTML={{ __html: blog.content }} />
                            </>
                        )}
                    </div>
                </div>
            </article>

            {related.length > 0 && (
                <section className="py-12 md:py-16">
                    <div className="container-site">
                        <h2 className="mb-8 text-2xl font-bold md:text-3xl">
                            Keep <span className="text-brand">reading</span>
                        </h2>
                        <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                            {related.map((item) => (
                                <BlogCard key={item.id} blog={item} />
                            ))}
                        </div>
                    </div>
                </section>
            )}

            <ContactSection />
        </>
    );
}
