import { Globe, Mail, MapPin, Phone } from 'lucide-react';
import { Link } from 'react-router-dom';
import { useSite } from '../../lib/site';
import Logo from '../ui/Logo';

const COMPANY = [
    { to: '/about', label: 'About Us' },
    { to: '/team', label: 'Our Team' },
    { to: '/project', label: 'Portfolio' },
    { to: '/pricing', label: 'Pricing' },
];

const RESOURCES = [
    { to: '/blog', label: 'Blogs' },
    { to: '/faq', label: 'FAQ' },
    { to: '/contact', label: 'Contact Us' },
    { to: '/service', label: 'All Services' },
];

const LINK = 'leading-relaxed text-white/70 transition-colors duration-300 hover:text-brand';

function Column({ title, children }) {
    return (
        <div>
            <h3 className="mb-[22px] text-[22px] font-semibold tracking-[-0.04em] text-white">{title}</h3>
            <ul className="space-y-3">{children}</ul>
        </div>
    );
}

/** Social links are stored by the admin as either a plain list of URLs or a platform → URL map. */
function socialEntries(links) {
    return Object.entries(links ?? {})
        .map(([key, value]) => ({ label: Number.isNaN(Number(key)) ? key : hostLabel(value), url: value }))
        .filter((entry) => typeof entry.url === 'string' && /^https?:\/\//.test(entry.url));
}

function hostLabel(url) {
    try {
        return new URL(url).hostname.replace(/^www\./, '').split('.')[0];
    } catch {
        return 'link';
    }
}

export default function Footer() {
    const site = useSite();
    const socials = socialEntries(site.social_links);

    return (
        <footer className="w-full bg-background px-3 py-3">
            <div className="overflow-hidden rounded-[28px] border border-white/[0.04] bg-[#151515] px-6 py-9 text-white md:px-12 xl:px-[105px]">
                <div className="flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
                    <Logo />
                    <div className="flex flex-wrap gap-3">
                        {site.services.slice(0, 4).map((service) => (
                            <Link
                                key={service.slug}
                                to={`/services/${service.slug}`}
                                className="flex h-[52px] items-center justify-center rounded-[16px] border border-white/[0.05] bg-[#1b1b1b] px-5 text-sm font-semibold tracking-[-0.02em] transition hover:border-brand/30 hover:bg-[#202020]"
                            >
                                {service.name}
                            </Link>
                        ))}
                    </div>
                </div>

                <div className="my-8 h-px w-full bg-white/10" />

                <div className="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-[1.2fr_1fr_1fr_1.45fr]">
                    <Column title="Services">
                        {site.services.map((service) => (
                            <li key={service.slug}>
                                <Link to={`/services/${service.slug}`} className={LINK}>
                                    {service.name}
                                </Link>
                            </li>
                        ))}
                    </Column>

                    <Column title="Company">
                        {COMPANY.map((link) => (
                            <li key={link.to}>
                                <Link to={link.to} className={LINK}>
                                    {link.label}
                                </Link>
                            </li>
                        ))}
                    </Column>

                    <Column title="Resources">
                        {RESOURCES.map((link) => (
                            <li key={link.to}>
                                <Link to={link.to} className={LINK}>
                                    {link.label}
                                </Link>
                            </li>
                        ))}
                    </Column>

                    <Column title="Get in Touch">
                        <li className="leading-relaxed text-white/70">
                            Tell us about your project — we&rsquo;ll follow up within one business day.
                        </li>
                        {site.email && (
                            <li>
                                <a href={`mailto:${site.email}`} className={`flex items-center gap-2 break-all ${LINK}`}>
                                    <Mail className="size-4 shrink-0 text-brand" aria-hidden="true" />
                                    {site.email}
                                </a>
                            </li>
                        )}
                        {site.phone && (
                            <li>
                                <a href={`tel:${site.phone.replace(/[^+\d]/g, '')}`} className={`flex items-center gap-2 ${LINK}`}>
                                    <Phone className="size-4 shrink-0 text-brand" aria-hidden="true" />
                                    {site.phone}
                                </a>
                            </li>
                        )}
                        {site.address && (
                            <li className="flex items-start gap-2 leading-relaxed text-white/70">
                                <MapPin className="mt-1 size-4 shrink-0 text-brand" aria-hidden="true" />
                                {site.address}
                            </li>
                        )}
                    </Column>
                </div>

                <div className="my-8 h-px w-full bg-white/10" />

                <div className="flex flex-col items-center justify-between gap-5 md:flex-row">
                    <p className="text-center leading-relaxed text-white/70 md:text-left">
                        Copyright © {new Date().getFullYear()}, {site.name}. All rights reserved
                    </p>
                    {socials.length > 0 && (
                        <div className="flex justify-center gap-3">
                            {socials.map((social) => (
                                <a
                                    key={social.url}
                                    href={social.url}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label={social.label}
                                    title={social.label}
                                    className="flex size-10 items-center justify-center rounded-full border border-white/20 text-white/80 transition hover:border-brand hover:bg-brand hover:text-black"
                                >
                                    <Globe className="size-4" aria-hidden="true" />
                                </a>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </footer>
    );
}
