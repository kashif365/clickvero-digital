import { Link } from 'react-router-dom';
import { useSite } from '../../lib/site';

/** Text wordmark: the first word of the site name in white, the rest in the accent color. */
export default function Logo({ className = '' }) {
    const { name } = useSite();
    const [first, ...rest] = name.split(' ');

    return (
        <Link to="/" aria-label={`${name} — home`} className={`flex items-center gap-2.5 ${className}`}>
            <svg viewBox="0 0 64 64" className="size-9 shrink-0" aria-hidden="true">
                <rect width="64" height="64" rx="14" fill="#fdc700" />
                <path d="M43 22.5A14 14 0 1 0 43 41.5" fill="none" stroke="#0a0a0a" strokeWidth="7" strokeLinecap="round" />
                <circle cx="46" cy="32" r="4.5" fill="#0a0a0a" />
            </svg>
            <span className="whitespace-nowrap text-xl font-bold tracking-tight text-white">
                {first}
                {rest.length > 0 && <span className="font-medium text-brand"> {rest.join(' ')}</span>}
            </span>
        </Link>
    );
}
