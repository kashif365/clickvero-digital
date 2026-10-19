import { createContext, useContext } from 'react';
import {
    Code2,
    Mail,
    Megaphone,
    MapPin,
    MousePointerClick,
    Palette,
    PenLine,
    Search,
    Share2,
    Sparkles,
} from 'lucide-react';

const fallbackSite = { name: 'Clickvora Digital', email: null, phone: null, address: null, social_links: [], services: [] };

// Embedded by Laravel in the SPA shell (resources/views/spa.blade.php).
const SiteContext = createContext(window.__APP__?.site ?? fallbackSite);

export const useSite = () => useContext(SiteContext);

const SERVICE_ICONS = [
    [/local-seo/, MapPin],
    [/search-engine-marketing/, MousePointerClick],
    [/seo|search/, Search],
    [/social/, Share2],
    [/ppc|pay-per-click|ads|advertis/, MousePointerClick],
    [/web|develop/, Code2],
    [/content|copy/, PenLine],
    [/brand|design/, Palette],
    [/email/, Mail],
    [/market/, Megaphone],
];

/** Picks an icon for a service from its slug; services are admin-managed, so this is a best-effort match. */
export function serviceIcon(slug = '') {
    return SERVICE_ICONS.find(([pattern]) => pattern.test(slug))?.[1] ?? Sparkles;
}

export function formatDate(value) {
    if (!value) {
        return '';
    }

    return new Date(`${value}T00:00:00`).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
}
