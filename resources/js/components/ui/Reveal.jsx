import { useEffect, useRef, useState } from 'react';

/**
 * Fades content up the first time it scrolls into view. `delay` (ms) staggers
 * siblings. Styles live in app.css (.reveal) and are disabled for visitors who
 * prefer reduced motion.
 */
export default function Reveal({ as: Tag = 'div', delay = 0, className = '', children, ...props }) {
    const ref = useRef(null);
    const [visible, setVisible] = useState(false);

    useEffect(() => {
        const element = ref.current;

        if (!element || !('IntersectionObserver' in window)) {
            setVisible(true);

            return undefined;
        }

        // Content that mounts already on screen (e.g. after an API response) is
        // shown straight away rather than waiting for an observer callback.
        const rect = element.getBoundingClientRect();

        if (rect.top < window.innerHeight && rect.bottom > 0) {
            setVisible(true);

            return undefined;
        }

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setVisible(true);
                    observer.disconnect();
                }
            },
            { rootMargin: '0px 0px -6% 0px', threshold: 0.05 },
        );

        observer.observe(element);

        return () => observer.disconnect();
    }, []);

    return (
        <Tag
            ref={ref}
            className={`reveal ${visible ? 'is-visible' : ''} ${className}`}
            style={delay ? { transitionDelay: `${delay}ms` } : undefined}
            {...props}
        >
            {children}
        </Tag>
    );
}
