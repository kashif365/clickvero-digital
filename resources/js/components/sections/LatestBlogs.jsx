import { useState } from 'react';
import { api } from '../../lib/api';
import { useAsync } from '../../lib/hooks';
import Button from '../ui/Button';
import { EmptyState, ErrorState } from '../ui/States';
import BlogCard, { BlogCardSkeleton } from './BlogCard';

/** The three most recent posts, loaded from the API. */
export default function LatestBlogs() {
    const [attempt, setAttempt] = useState(0);
    const { data, error, loading } = useAsync((signal) => api.blogs({ per_page: 3 }, signal), [attempt]);
    const blogs = data?.data ?? [];

    return (
        <section className="py-16 md:py-20">
            <div className="container-site">
                <div className="mb-12 flex flex-col items-start justify-between gap-6 md:mb-16 md:flex-row md:items-center">
                    <div className="max-w-2xl">
                        <h2 className="mb-4 text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">Blogs</h2>
                        <p className="leading-relaxed text-muted-foreground">
                            From SEO fundamentals to campaigns that convert, our blog breaks down digital marketing into actionable insights for
                            growing brands.
                        </p>
                    </div>
                    <Button to="/blog">Get Industry Insights</Button>
                </div>

                {error ? (
                    <ErrorState message={error.message} onRetry={() => setAttempt((value) => value + 1)} />
                ) : loading ? (
                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                        {[0, 1, 2].map((key) => (
                            <BlogCardSkeleton key={key} />
                        ))}
                    </div>
                ) : blogs.length === 0 ? (
                    <EmptyState title="No articles yet" text="New posts will appear here as soon as they are published." />
                ) : (
                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                        {blogs.map((blog) => (
                            <BlogCard key={blog.id} blog={blog} />
                        ))}
                    </div>
                )}
            </div>
        </section>
    );
}
