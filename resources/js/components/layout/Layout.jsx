import { ArrowUp, MessageCircle } from 'lucide-react';
import { useEffect } from 'react';
import { Link, Outlet, useLocation } from 'react-router-dom';
import { api } from '../../lib/api';
import { useAsync, useScrolled } from '../../lib/hooks';
import Footer from './Footer';
import Header from './Header';

function setMeta(selector, attribute, value) {
    const element = document.head.querySelector(selector);

    if (element && value) {
        element.setAttribute(attribute, value);
    }
}

/**
 * Keeps <head> in sync after client-side navigations using the same SEO values
 * Laravel renders on a full page load, and returns the admin-managed
 * "additional content" block for the current path.
 */
function usePageData(pathname) {
    const { data } = useAsync((signal) => api.page(pathname, signal), [pathname]);
    const page = data?.data;

    useEffect(() => {
        if (!page?.seo) {
            return;
        }

        document.title = page.seo.title;
        setMeta('meta[name="description"]', 'content', page.seo.description);
        setMeta('link[rel="canonical"]', 'href', page.seo.canonical);
        setMeta('meta[name="robots"]', 'content', page.seo.robots);
    }, [page]);

    return page?.additional_content ?? null;
}

function AdditionalContent({ block }) {
    return (
        <section className="py-10 md:py-16">
            <div className="container-site">
                {block.title && <h2 className="mb-8 text-center text-2xl font-bold md:text-3xl lg:text-4xl">{block.title}</h2>}
                <div className="max-h-[640px] overflow-y-auto rounded-2xl border bg-card/50 p-6 md:p-10">
                    {/* Sanitized server-side (HTMLPurifier) before it is stored. */}
                    <div className="rich-content" dangerouslySetInnerHTML={{ __html: block.content }} />
                </div>
            </div>
        </section>
    );
}

function FloatingActions() {
    const visible = useScrolled(600);

    return (
        <>
            <Link
                to="/contact"
                aria-label="Contact us"
                className="fixed bottom-6 left-4 z-40 flex size-12 items-center justify-center rounded-full bg-brand text-black shadow-lg transition-transform hover:scale-110"
            >
                <MessageCircle className="size-5" aria-hidden="true" />
            </Link>
            <button
                type="button"
                aria-label="Back to top"
                onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
                className={`fixed bottom-6 right-4 z-40 flex size-12 items-center justify-center rounded-full border border-white/15 bg-card text-white shadow-lg transition-all hover:border-brand hover:text-brand ${visible ? 'opacity-100' : 'pointer-events-none opacity-0'}`}
            >
                <ArrowUp className="size-5" aria-hidden="true" />
            </button>
        </>
    );
}

export default function Layout() {
    const { pathname } = useLocation();
    const additionalContent = usePageData(pathname);

    useEffect(() => {
        window.scrollTo({ top: 0, behavior: 'instant' });
    }, [pathname]);

    return (
        <>
            <a
                href="#main"
                className="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-md focus:bg-brand focus:px-4 focus:py-2 focus:font-semibold focus:text-black"
            >
                Skip to content
            </a>
            <Header />
            <main id="main" className="min-h-[80vh]">
                <div key={pathname} className="animate-fade-in">
                    <Outlet />
                </div>
                {additionalContent && <AdditionalContent block={additionalContent} />}
            </main>
            <Footer />
            <FloatingActions />
        </>
    );
}
