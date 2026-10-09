import { useEffect, useState } from 'react';

/**
 * Runs an async loader and tracks its lifecycle. The loader receives an
 * AbortSignal so in-flight requests are cancelled when deps change or the
 * component unmounts.
 */
export function useAsync(loader, deps) {
    const [state, setState] = useState({ data: null, error: null, loading: true });

    useEffect(() => {
        const controller = new AbortController();

        setState({ data: null, error: null, loading: true });

        loader(controller.signal)
            .then((data) => setState({ data, error: null, loading: false }))
            .catch((error) => {
                if (error.name !== 'AbortError') {
                    setState({ data: null, error, loading: false });
                }
            });

        return () => controller.abort();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, deps);

    return state;
}

/** Debounces a fast-changing value (e.g. a search input). */
export function useDebounced(value, delay = 350) {
    const [debounced, setDebounced] = useState(value);

    useEffect(() => {
        const timer = setTimeout(() => setDebounced(value), delay);

        return () => clearTimeout(timer);
    }, [value, delay]);

    return debounced;
}

/** True once the page has been scrolled past `offset` pixels. */
export function useScrolled(offset = 24) {
    const [scrolled, setScrolled] = useState(false);

    useEffect(() => {
        const onScroll = () => setScrolled(window.scrollY > offset);

        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        return () => window.removeEventListener('scroll', onScroll);
    }, [offset]);

    return scrolled;
}
