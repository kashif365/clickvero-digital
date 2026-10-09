import { Search, X } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useSearchParams } from 'react-router-dom';
import BlogCard, { BlogCardSkeleton } from '../components/sections/BlogCard';
import ContactSection from '../components/sections/ContactSection';
import PageHero from '../components/sections/PageHero';
import ServiceMarquee from '../components/sections/ServiceMarquee';
import Pagination from '../components/ui/Pagination';
import { EmptyState, ErrorState } from '../components/ui/States';
import { images } from '../content/site';
import { api } from '../lib/api';
import { useAsync, useDebounced } from '../lib/hooks';

const PER_PAGE = 6;

/** Filters live in the query string (?search=&category=&page=) so results are linkable and survive a refresh. */
export default function Blog() {
    const [params, setParams] = useSearchParams();
    const category = params.get('category') ?? '';
    const search = params.get('search') ?? '';
    const page = Math.max(1, Number(params.get('page')) || 1);

    const [searchInput, setSearchInput] = useState(search);
    const debouncedSearch = useDebounced(searchInput.trim());
    const [attempt, setAttempt] = useState(0);
    const [categories, setCategories] = useState([]);

    const update = (changes) => {
        const next = new URLSearchParams(params);

        Object.entries(changes).forEach(([key, value]) => (value ? next.set(key, value) : next.delete(key)));
        setParams(next, { preventScrollReset: true });
    };

    useEffect(() => {
        if (debouncedSearch !== search) {
            update({ search: debouncedSearch, page: null });
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [debouncedSearch]);

    const { data, error, loading } = useAsync(
        (signal) => api.blogs({ search, category, page, per_page: PER_PAGE }, signal),
        [search, category, page, attempt],
    );

    useEffect(() => {
        if (data?.categories) {
            setCategories(data.categories);
        }
    }, [data]);

    const blogs = data?.data ?? [];
    const meta = data?.meta;
    const filtered = Boolean(search || category);

    const changePage = (next) => {
        update({ page: next > 1 ? String(next) : null });
        document.getElementById('blog-list')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    const clearFilters = () => {
        setSearchInput('');
        setParams({}, { preventScrollReset: true });
    };

    return (
        <>
            <PageHero
                image={images.analytics}
                title="Blogs"
                text="Discover our newest ideas and insights on SEO, paid media, content, and online growth."
                breadcrumbs={[{ label: 'Blog' }]}
            />

            <ServiceMarquee />

            <section id="blog-list" className="scroll-mt-24 py-16 md:py-24">
                <div className="container-site">
                    <div className="mb-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div
                            role="group"
                            aria-label="Filter by category"
                            className="-mx-4 flex gap-2 overflow-x-auto px-4 pb-1 [scrollbar-width:none] sm:mx-0 sm:flex-wrap sm:px-0 [&::-webkit-scrollbar]:hidden"
                        >
                            {['', ...categories].map((item) => {
                                const selected = item === category;

                                return (
                                    <button
                                        key={item || 'all'}
                                        type="button"
                                        aria-pressed={selected}
                                        onClick={() => update({ category: item, page: null })}
                                        className={`shrink-0 rounded-full border px-5 py-2.5 text-sm font-medium transition-colors ${selected ? 'border-brand bg-brand text-black' : 'bg-card hover:border-brand/60 hover:text-brand'}`}
                                    >
                                        {item || 'All'}
                                    </button>
                                );
                            })}
                        </div>

                        <div className="relative w-full lg:max-w-sm">
                            <label htmlFor="blog-search" className="sr-only">
                                Search articles
                            </label>
                            <Search className="pointer-events-none absolute left-4 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" aria-hidden="true" />
                            <input
                                id="blog-search"
                                type="search"
                                value={searchInput}
                                maxLength={100}
                                onChange={(event) => setSearchInput(event.target.value)}
                                placeholder="Search articles…"
                                className="w-full rounded-full border bg-card py-3 pl-11 pr-11 text-white placeholder:text-white/40 focus:border-brand focus:outline-none [&::-webkit-search-cancel-button]:hidden"
                            />
                            {searchInput && (
                                <button
                                    type="button"
                                    aria-label="Clear search"
                                    onClick={() => setSearchInput('')}
                                    className="absolute right-3 top-1/2 flex size-7 -translate-y-1/2 items-center justify-center rounded-full text-muted-foreground hover:text-white"
                                >
                                    <X className="size-4" aria-hidden="true" />
                                </button>
                            )}
                        </div>
                    </div>

                    <p className="mb-6 text-sm text-muted-foreground" aria-live="polite">
                        {!loading && !error && meta && `${meta.total} ${meta.total === 1 ? 'article' : 'articles'}${filtered ? ' found' : ''}`}
                    </p>

                    {error ? (
                        <ErrorState message={error.message} onRetry={() => setAttempt((value) => value + 1)} />
                    ) : loading ? (
                        <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                            {Array.from({ length: PER_PAGE }, (_, key) => (
                                <BlogCardSkeleton key={key} />
                            ))}
                        </div>
                    ) : blogs.length === 0 ? (
                        <div className="space-y-6 text-center">
                            <EmptyState
                                title={filtered ? 'No articles match your filters' : 'No articles yet'}
                                text={filtered ? 'Try a different search term or category.' : 'New posts will appear here as soon as they are published.'}
                            />
                            {filtered && (
                                <button type="button" onClick={clearFilters} className="font-semibold text-brand hover:text-brand-soft">
                                    Clear filters
                                </button>
                            )}
                        </div>
                    ) : (
                        <>
                            <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                                {blogs.map((blog) => (
                                    <BlogCard key={blog.id} blog={blog} />
                                ))}
                            </div>
                            <Pagination current={meta.current_page} last={meta.last_page} onChange={changePage} />
                        </>
                    )}
                </div>
            </section>

            <ContactSection />
        </>
    );
}
