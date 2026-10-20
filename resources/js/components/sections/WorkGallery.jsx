import { ArrowRight, ChevronLeft, ChevronRight, ExternalLink, Maximize2, X } from 'lucide-react';
import { useCallback, useEffect, useRef, useState } from 'react';
import { createPortal } from 'react-dom';
import { work, workCategories } from '../../content/work';
import Button from '../ui/Button';
import Reveal from '../ui/Reveal';

const LABELS = Object.fromEntries(workCategories.map((category) => [category.key, category.label]));
const TABS = [{ key: 'all', label: 'All Work' }, ...workCategories];

/** Websites and stores are full-page screenshots, so the viewer scrolls them top to bottom instead of fitting them. */
const isPage = (item) => item.category === 'websites' || item.category === 'ecommerce';

/** Card image treatment per category: logos and ad dashboards sit on white, square social posts are shown whole. */
const CARD_MEDIA = {
    websites: { frame: 'bg-[#111111]', image: 'object-cover object-top' },
    ecommerce: { frame: 'bg-[#111111]', image: 'object-cover object-top' },
    logos: { frame: 'bg-white', image: 'object-contain p-8 sm:p-10' },
    ppc: { frame: 'bg-white', image: 'object-contain p-2' },
    seo: { frame: 'bg-[#6d2bd9]', image: 'object-contain' },
    graphics: { frame: 'bg-[#111111]', image: 'object-contain' },
    apps: { frame: 'bg-[#111111]', image: 'object-cover' },
};

function WorkCard({ item, onOpen, wide = false }) {
    const media = CARD_MEDIA[item.category] ?? CARD_MEDIA.apps;

    return (
        <button
            type="button"
            onClick={onOpen}
            className="group flex h-full w-full flex-col overflow-hidden rounded-2xl border border-white/10 bg-card text-left transition-[border-color,box-shadow] duration-300 hover:border-brand hover:shadow-lg"
        >
            <span className={`relative block w-full overflow-hidden ${wide ? 'aspect-[3/1]' : 'aspect-[4/3]'} ${media.frame}`}>
                <img
                    src={item.thumb}
                    alt={`${item.title} — ${LABELS[item.category]}`}
                    loading="lazy"
                    decoding="async"
                    className={`size-full transition-transform duration-500 group-hover:scale-105 ${media.image}`}
                />
                <span className="absolute inset-0 flex items-center justify-center bg-black/0 opacity-0 transition-all duration-300 group-hover:bg-black/45 group-hover:opacity-100">
                    <span className="flex items-center gap-2 rounded-full bg-brand px-4 py-2 text-sm font-semibold text-black">
                        <Maximize2 className="size-4" aria-hidden="true" />
                        View project
                    </span>
                </span>
            </span>
            <span className="flex flex-1 flex-col gap-1 p-5">
                <span className="text-sm font-medium text-brand">{LABELS[item.category]}</span>
                <span className="text-lg font-bold leading-snug">{item.title}</span>
            </span>
        </button>
    );
}

/**
 * Full-screen project viewer with previous/next navigation, keyboard support,
 * and a scroll lock on the page behind it. Rendered into <body> so it sits
 * above the fixed header regardless of the page's stacking contexts.
 */
function Viewer({ items, index, onClose, onMove }) {
    const item = items[index];
    const closeRef = useRef(null);
    const scrollRef = useRef(null);

    useEffect(() => {
        const previous = document.activeElement;
        const onKeyDown = (event) => {
            if (event.key === 'Escape') {
                onClose();
            } else if (event.key === 'ArrowRight') {
                onMove(1);
            } else if (event.key === 'ArrowLeft') {
                onMove(-1);
            }
        };

        document.body.style.overflow = 'hidden';
        window.addEventListener('keydown', onKeyDown);
        closeRef.current?.focus();

        return () => {
            document.body.style.overflow = '';
            window.removeEventListener('keydown', onKeyDown);
            previous?.focus?.();
        };
    }, [onClose, onMove]);

    useEffect(() => {
        scrollRef.current?.scrollTo({ top: 0 });
    }, [index]);

    const page = isPage(item);
    const logo = item.category === 'logos';

    return createPortal(
        <div role="dialog" aria-modal="true" aria-label={item.title} className="fixed inset-0 z-[60] flex animate-fade-in flex-col bg-black/95 backdrop-blur-sm">
            <div className="flex items-center justify-between gap-4 border-b border-white/10 bg-black px-4 py-3 sm:px-6">
                <div className="min-w-0">
                    <p className="text-sm text-brand">{LABELS[item.category]}</p>
                    <h2 className="truncate text-lg font-bold text-white sm:text-xl">{item.title}</h2>
                </div>
                <div className="flex shrink-0 items-center gap-2">
                    {item.link && (
                        <a
                            href={item.link}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="hidden items-center gap-2 rounded-md border border-white/20 px-4 py-2 text-sm font-semibold text-white transition-colors hover:border-brand hover:text-brand sm:flex"
                        >
                            Visit live site <ExternalLink className="size-4" aria-hidden="true" />
                        </a>
                    )}
                    <span className="hidden text-sm text-white/60 sm:inline">
                        {index + 1} / {items.length}
                    </span>
                    <button
                        ref={closeRef}
                        type="button"
                        onClick={onClose}
                        aria-label="Close"
                        className="flex size-11 items-center justify-center rounded-md border border-white/20 text-white transition-colors hover:border-brand hover:text-brand"
                    >
                        <X className="size-5" aria-hidden="true" />
                    </button>
                </div>
            </div>

            <div ref={scrollRef} className="relative flex-1 overflow-y-auto overscroll-contain" onClick={(event) => event.target === event.currentTarget && onClose()}>
                <div
                    className={`mx-auto px-4 py-6 sm:px-16 ${page ? 'max-w-5xl' : 'flex min-h-full max-w-6xl items-center justify-center'}`}
                    onClick={(event) => event.target === event.currentTarget && onClose()}
                >
                    <img
                        key={item.id}
                        src={item.image}
                        alt={item.title}
                        width={item.width}
                        height={item.height}
                        className={`h-auto animate-fade-in rounded-xl ${page ? 'w-full' : 'max-h-[calc(100dvh-10rem)] w-auto max-w-full object-contain'} ${logo ? 'bg-white p-8 sm:p-14' : ''}`}
                    />
                    {item.link && (
                        <a
                            href={item.link}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="mt-4 flex items-center justify-center gap-2 font-semibold text-brand sm:hidden"
                        >
                            Visit live site <ExternalLink className="size-4" aria-hidden="true" />
                        </a>
                    )}
                </div>
            </div>

            {items.length > 1 && (
                <>
                    <button
                        type="button"
                        onClick={() => onMove(-1)}
                        aria-label="Previous project"
                        className="absolute left-2 top-1/2 flex size-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur transition-colors hover:bg-brand hover:text-black sm:left-4"
                    >
                        <ChevronLeft className="size-5" aria-hidden="true" />
                    </button>
                    <button
                        type="button"
                        onClick={() => onMove(1)}
                        aria-label="Next project"
                        className="absolute right-2 top-1/2 flex size-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur transition-colors hover:bg-brand hover:text-black sm:right-4"
                    >
                        <ChevronRight className="size-5" aria-hidden="true" />
                    </button>
                </>
            )}
        </div>,
        document.body,
    );
}

/**
 * Filterable portfolio grid. Shows `pageSize` items at a time with a "Load
 * more" button, or — when `moreTo` is set — a link to the full portfolio.
 * `categories` limits it to some categories (e.g. on a service page); the
 * filter tabs are hidden when only one category is shown.
 */
export default function WorkGallery({ pageSize = 12, moreTo, categories }) {
    const [tab, setTab] = useState('all');
    const [shown, setShown] = useState(pageSize);
    const [open, setOpen] = useState(null);

    const pool = categories ? work.filter((item) => categories.includes(item.category)) : work;
    const tabs = categories ? TABS.filter((item) => item.key === 'all' || categories.includes(item.key)) : TABS;
    const items = tab === 'all' ? pool : pool.filter((item) => item.category === tab);
    const visible = items.slice(0, shown);
    // Google Ads dashboards are ~3:1, so a PPC-only grid uses two columns of wide cards.
    const wide = items.length > 0 && items.every((item) => item.category === 'ppc');

    const select = (key) => {
        setTab(key);
        setShown(pageSize);
    };

    const count = items.length;
    const close = useCallback(() => setOpen(null), []);
    const move = useCallback((step) => setOpen((index) => (index + step + count) % count), [count]);

    return (
        <>
            {tabs.length > 2 && (
                <div
                    role="group"
                    aria-label="Filter work by category"
                    className="-mx-4 mb-10 flex gap-2 overflow-x-auto px-4 pb-2 [scrollbar-width:none] sm:mx-0 sm:flex-wrap sm:justify-center sm:px-0 [&::-webkit-scrollbar]:hidden"
                >
                    {tabs.map((item) => {
                        const count = item.key === 'all' ? pool.length : pool.filter((entry) => entry.category === item.key).length;

                        return (
                            <button
                                key={item.key}
                                type="button"
                                aria-pressed={item.key === tab}
                                onClick={() => select(item.key)}
                                className={`flex shrink-0 items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-medium transition-colors ${item.key === tab ? 'border-brand bg-brand text-black' : 'bg-card hover:border-brand/60 hover:text-brand'}`}
                            >
                                {item.label}
                                <span className={`rounded-full px-2 py-0.5 text-xs ${item.key === tab ? 'bg-black/15' : 'bg-white/10'}`}>{count}</span>
                            </button>
                        );
                    })}
                </div>
            )}

            <div key={tab} className={`grid grid-cols-1 gap-5 lg:gap-6 ${wide ? 'md:grid-cols-2' : 'sm:grid-cols-2 lg:grid-cols-3'}`}>
                {visible.map((item, index) => (
                    <Reveal key={item.id} delay={(index % 3) * 60}>
                        <WorkCard item={item} wide={wide} onOpen={() => setOpen(index)} />
                    </Reveal>
                ))}
            </div>

            <div className="mt-10 flex justify-center">
                {moreTo ? (
                    <Button to={moreTo}>
                        View Full Portfolio <ArrowRight className="size-4" aria-hidden="true" />
                    </Button>
                ) : (
                    shown < items.length && (
                        <Button variant="outline" onClick={() => setShown((count) => count + pageSize)}>
                            Load more ({items.length - shown} remaining)
                        </Button>
                    )
                )}
            </div>

            {open !== null && <Viewer items={items} index={open} onClose={close} onMove={move} />}
        </>
    );
}
