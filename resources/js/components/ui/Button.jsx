import { ArrowRight, LoaderCircle } from 'lucide-react';
import { Link } from 'react-router-dom';

const VARIANTS = {
    primary: 'border-brand bg-brand text-black hover:bg-black hover:text-white',
    outline: 'border-white/20 bg-transparent text-white hover:border-brand hover:text-brand',
};

const BASE =
    'inline-flex w-full items-center justify-center gap-2 whitespace-nowrap rounded-md border px-6 py-3 text-sm font-semibold transition-colors duration-300 disabled:pointer-events-none disabled:opacity-60 sm:w-auto md:px-8 md:text-base lg:text-lg';

/** Renders a router link when `to` is given, otherwise a real <button>. */
export default function Button({ to, variant = 'primary', loading = false, className = '', children, ...props }) {
    const classes = `${BASE} ${VARIANTS[variant]} ${className}`;

    if (to) {
        return (
            <Link to={to} className={classes} {...props}>
                {children}
            </Link>
        );
    }

    return (
        <button className={classes} disabled={loading || props.disabled} {...props}>
            {loading && <LoaderCircle className="size-4 animate-spin" aria-hidden="true" />}
            {children}
        </button>
    );
}

/** The hero call-to-action: a yellow arrow disc followed by a text label. */
export function ArrowLink({ to, children }) {
    return (
        <Link to={to} className="group flex w-max items-center gap-4">
            <span className="flex size-10 items-center justify-center rounded-full bg-brand text-black shadow-lg transition-all duration-300 group-hover:translate-x-1 group-hover:shadow-2xl">
                <ArrowRight className="size-5" aria-hidden="true" />
            </span>
            <span className="font-medium text-white transition-colors duration-300 group-hover:text-brand">{children}</span>
        </Link>
    );
}
