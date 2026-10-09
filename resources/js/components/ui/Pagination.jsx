import { ChevronLeft, ChevronRight } from 'lucide-react';

/** Page numbers to show: first, last, and a window around the current page (null = gap). */
function pageWindow(current, last) {
    const pages = [];

    for (let page = 1; page <= last; page += 1) {
        if (page === 1 || page === last || Math.abs(page - current) <= 1) {
            pages.push(page);
        } else if (pages[pages.length - 1] !== null) {
            pages.push(null);
        }
    }

    return pages;
}

const BUTTON = 'flex size-11 items-center justify-center rounded-full border text-sm font-semibold transition-colors disabled:pointer-events-none disabled:opacity-40';

export default function Pagination({ current, last, onChange }) {
    if (last <= 1) {
        return null;
    }

    return (
        <nav aria-label="Pagination" className="mt-12 flex flex-wrap items-center justify-center gap-2">
            <button type="button" aria-label="Previous page" disabled={current <= 1} onClick={() => onChange(current - 1)} className={`${BUTTON} hover:border-brand hover:text-brand`}>
                <ChevronLeft className="size-4" aria-hidden="true" />
            </button>
            {pageWindow(current, last).map((page, index) =>
                page === null ? (
                    // eslint-disable-next-line react/no-array-index-key
                    <span key={`gap-${index}`} className="px-1 text-muted-foreground">
                        …
                    </span>
                ) : (
                    <button
                        key={page}
                        type="button"
                        aria-label={`Page ${page}`}
                        aria-current={page === current ? 'page' : undefined}
                        onClick={() => onChange(page)}
                        className={`${BUTTON} ${page === current ? 'border-brand bg-brand text-black' : 'hover:border-brand hover:text-brand'}`}
                    >
                        {page}
                    </button>
                ),
            )}
            <button type="button" aria-label="Next page" disabled={current >= last} onClick={() => onChange(current + 1)} className={`${BUTTON} hover:border-brand hover:text-brand`}>
                <ChevronRight className="size-4" aria-hidden="true" />
            </button>
        </nav>
    );
}
