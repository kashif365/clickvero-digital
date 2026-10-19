import { ArrowRight, ChevronDown, Mail, Menu, Phone, X } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { Link, NavLink, useLocation } from 'react-router-dom';
import { useScrolled } from '../../lib/hooks';
import { serviceMenu } from '../../content/site';
import { useSite } from '../../lib/site';
import Button from '../ui/Button';
import Logo from '../ui/Logo';

const COMPANY_LINKS = [
    { to: '/about', label: 'About Us', text: 'Who we are and how we work' },
    { to: '/team', label: 'Our Team', text: 'The people behind the campaigns' },
    { to: '/faq', label: 'FAQ', text: 'Answers to common questions' },
    { to: '/blog', label: 'Blog', text: 'Insights on SEO and growth' },
    { to: '/contact', label: 'Contact', text: 'Start a conversation with us' },
];

/**
 * Resolves the mega menu config against the published services: unpublished
 * items are hidden, empty groups and columns are dropped, and any published
 * service the config doesn't mention is listed under "More Services".
 */
function buildServiceMenu(services) {
    const published = new Set(services.map((service) => service.slug));
    const listed = new Set(serviceMenu.flat().flatMap((group) => group.items.map((item) => item.slug)));

    const columns = serviceMenu
        .map((column) =>
            column
                .map((group) => ({ ...group, items: group.items.filter((item) => published.has(item.slug)) }))
                .filter((group) => group.items.length > 0),
        )
        .filter((column) => column.length > 0);

    const extra = services.filter((service) => !listed.has(service.slug)).map((service) => ({ label: service.name, slug: service.slug }));

    if (extra.length > 0) {
        if (columns.length === 0) {
            columns.push([]);
        }

        columns[columns.length - 1].push({ title: 'More Services', items: extra });
    }

    return columns;
}

const NAV_ITEM = 'group relative flex h-full items-center gap-1 text-lg font-medium text-white transition-colors hover:text-gray-200';

function Underline({ active = false }) {
    return (
        <span
            className={`absolute bottom-0 left-0 h-1 w-full origin-left bg-brand transition-transform duration-300 group-hover:scale-x-100 ${active ? 'scale-x-100' : 'scale-x-0'}`}
        />
    );
}

function NavItem({ to, children }) {
    return (
        <NavLink to={to} end={to === '/'} className={NAV_ITEM}>
            {({ isActive }) => (
                <>
                    {children}
                    <Underline active={isActive} />
                </>
            )}
        </NavLink>
    );
}

/**
 * Desktop dropdown: opens on hover, focus, or click, and closes on Escape or
 * navigation. A `mega` panel is centred under the whole header instead of the
 * trigger, so a wide menu never runs off the edge of the screen.
 */
function Dropdown({ id, label, open, onOpen, onClose, active, mega = false, panelClassName, children }) {
    return (
        <div className={`h-full ${mega ? '' : 'relative'}`} onMouseEnter={() => onOpen(id)} onMouseLeave={onClose}>
            <button
                type="button"
                className={NAV_ITEM}
                aria-expanded={open}
                aria-controls={`nav-${id}`}
                onClick={() => (open ? onClose() : onOpen(id))}
            >
                {label}
                <ChevronDown className={`size-4 transition-transform duration-300 ${open ? 'rotate-180' : ''}`} aria-hidden="true" />
                <Underline active={open || active} />
            </button>
            <div
                id={`nav-${id}`}
                className={`absolute top-full pt-2 transition-all duration-200 ${mega ? 'inset-x-0 flex justify-center px-4' : 'left-1/2 -translate-x-1/2'} ${open ? 'visible opacity-100' : 'invisible -translate-y-1 opacity-0'}`}
            >
                <div className={`rounded-2xl border bg-card shadow-[0_24px_60px_rgba(0,0,0,0.6)] ${mega ? '' : 'p-3'} ${panelClassName}`}>{children}</div>
            </div>
        </div>
    );
}

function MenuLink({ to, icon: IconComponent, label, text }) {
    return (
        <Link to={to} className="group/item flex items-start gap-3 rounded-xl p-3 transition-colors hover:bg-white/5">
            {IconComponent && (
                <span className="flex size-10 shrink-0 items-center justify-center rounded-xl border border-brand/30 bg-brand/10 text-brand">
                    <IconComponent className="size-5" aria-hidden="true" />
                </span>
            )}
            <span className="min-w-0">
                <span className="block font-semibold text-white transition-colors group-hover/item:text-brand">{label}</span>
                {text && <span className="mt-0.5 line-clamp-2 block text-sm text-muted-foreground">{text}</span>}
            </span>
        </Link>
    );
}

export default function Header() {
    const site = useSite();
    const location = useLocation();
    const scrolled = useScrolled();
    const [openMenu, setOpenMenu] = useState(null);
    const [mobileOpen, setMobileOpen] = useState(false);
    const [mobileSection, setMobileSection] = useState(null);

    const contact = site.phone
        ? { href: `tel:${site.phone.replace(/[^+\d]/g, '')}`, label: site.phone, icon: Phone }
        : site.email
          ? { href: `mailto:${site.email}`, label: site.email, icon: Mail }
          : null;

    useEffect(() => {
        setOpenMenu(null);
        setMobileOpen(false);
    }, [location.pathname]);

    useEffect(() => {
        const onKeyDown = (event) => {
            if (event.key === 'Escape') {
                setOpenMenu(null);
                setMobileOpen(false);
            }
        };

        window.addEventListener('keydown', onKeyDown);

        return () => window.removeEventListener('keydown', onKeyDown);
    }, []);

    useEffect(() => {
        document.body.style.overflow = mobileOpen ? 'hidden' : '';

        return () => {
            document.body.style.overflow = '';
        };
    }, [mobileOpen]);

    const serviceColumns = useMemo(() => buildServiceMenu(site.services), [site.services]);
    const solid = scrolled || mobileOpen;
    const servicesActive = location.pathname.startsWith('/service');
    const companyActive = COMPANY_LINKS.some((link) => location.pathname.startsWith(link.to));

    return (
        <header
            className={`fixed inset-x-0 top-0 z-50 transition-all duration-300 ${solid ? 'border-b border-white/10 bg-background/90 backdrop-blur-md' : 'bg-transparent'}`}
        >
            <div className="container-site">
                <div className="flex h-20 items-center justify-between gap-6">
                    <Logo />

                    <nav aria-label="Primary" className="hidden h-full items-center space-x-8 lg:flex">
                        <NavItem to="/">Home</NavItem>

                        <Dropdown
                            id="services"
                            label="Services"
                            open={openMenu === 'services'}
                            onOpen={setOpenMenu}
                            onClose={() => setOpenMenu(null)}
                            active={servicesActive}
                            mega
                            panelClassName="w-full max-w-[880px]"
                        >
                            {serviceColumns.length > 0 ? (
                                <div
                                    className="grid divide-x divide-white/10"
                                    style={{ gridTemplateColumns: `repeat(${serviceColumns.length}, minmax(0, 1fr))` }}
                                >
                                    {serviceColumns.map((column, index) => (
                                        // eslint-disable-next-line react/no-array-index-key
                                        <div key={index} className="space-y-8 px-7 py-7">
                                            {column.map((group) => (
                                                <div key={group.title}>
                                                    <p className="mb-3 font-semibold text-brand">{group.title}</p>
                                                    <ul className="space-y-2.5">
                                                        {group.items.map((item) => (
                                                            <li key={item.slug}>
                                                                <Link
                                                                    to={`/services/${item.slug}`}
                                                                    className="inline-block text-[15px] leading-snug text-white/75 transition-colors hover:text-white"
                                                                >
                                                                    {item.label}
                                                                </Link>
                                                            </li>
                                                        ))}
                                                    </ul>
                                                </div>
                                            ))}
                                            {index === serviceColumns.length - 1 && (
                                                <Link
                                                    to="/service"
                                                    className="group/all inline-flex items-center gap-1.5 font-semibold text-brand hover:text-brand-soft"
                                                >
                                                    View All Services
                                                    <ArrowRight className="size-4 transition-transform group-hover/all:translate-x-1" aria-hidden="true" />
                                                </Link>
                                            )}
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="p-6 text-sm text-muted-foreground">Services will appear here once they are published.</p>
                            )}
                        </Dropdown>

                        <NavItem to="/project">Portfolio</NavItem>
                        <NavItem to="/pricing">Pricing</NavItem>

                        <Dropdown
                            id="company"
                            label="Company"
                            open={openMenu === 'company'}
                            onOpen={setOpenMenu}
                            onClose={() => setOpenMenu(null)}
                            active={companyActive}
                            panelClassName="w-[320px]"
                        >
                            {COMPANY_LINKS.map((link) => (
                                <MenuLink key={link.to} {...link} />
                            ))}
                        </Dropdown>
                    </nav>

                    <div className="flex items-center gap-4">
                        {contact && (
                            <a
                                href={contact.href}
                                className="hidden items-center gap-2 text-base font-semibold text-white transition-colors hover:text-brand xl:flex"
                            >
                                <contact.icon className="size-4 text-brand" aria-hidden="true" />
                                {contact.label}
                            </a>
                        )}
                        <div className="hidden sm:block lg:hidden xl:block">
                            <Button to="/contact" className="!py-2.5 !text-base">
                                Schedule a Call
                            </Button>
                        </div>
                        <button
                            type="button"
                            className="flex size-11 items-center justify-center rounded-md border border-white/15 text-white lg:hidden"
                            aria-label={mobileOpen ? 'Close menu' : 'Open menu'}
                            aria-expanded={mobileOpen}
                            aria-controls="mobile-menu"
                            onClick={() => setMobileOpen((value) => !value)}
                        >
                            {mobileOpen ? <X className="size-5" /> : <Menu className="size-5" />}
                        </button>
                    </div>
                </div>
            </div>

            {mobileOpen && (
                <nav
                    id="mobile-menu"
                    aria-label="Mobile"
                    className="h-[calc(100dvh-5rem)] animate-fade-in overflow-y-auto overscroll-contain border-t border-white/10 bg-background px-4 pb-10 pt-4 sm:px-6 lg:hidden"
                >
                    <MobileLink to="/">Home</MobileLink>

                    <MobileGroup
                        label="Services"
                        open={mobileSection === 'services'}
                        onToggle={() => setMobileSection(mobileSection === 'services' ? null : 'services')}
                    >
                        {serviceColumns.flat().map((group) => (
                            <div key={group.title}>
                                <p className="pb-1 pl-4 pt-5 text-sm font-semibold uppercase tracking-widest text-brand">{group.title}</p>
                                {group.items.map((item) => (
                                    <MobileLink key={item.slug} to={`/services/${item.slug}`} nested>
                                        {item.label}
                                    </MobileLink>
                                ))}
                            </div>
                        ))}
                        <MobileLink to="/service" nested>
                            View All Services
                        </MobileLink>
                    </MobileGroup>

                    <MobileLink to="/project">Portfolio</MobileLink>
                    <MobileLink to="/pricing">Pricing</MobileLink>

                    <MobileGroup
                        label="Company"
                        open={mobileSection === 'company'}
                        onToggle={() => setMobileSection(mobileSection === 'company' ? null : 'company')}
                    >
                        {COMPANY_LINKS.map((link) => (
                            <MobileLink key={link.to} to={link.to} nested>
                                {link.label}
                            </MobileLink>
                        ))}
                    </MobileGroup>

                    <div className="mt-6 space-y-4">
                        <Button to="/contact">Schedule a Call</Button>
                        {contact && (
                            <a href={contact.href} className="flex items-center justify-center gap-2 font-semibold text-white">
                                <contact.icon className="size-4 text-brand" aria-hidden="true" />
                                {contact.label}
                            </a>
                        )}
                    </div>
                </nav>
            )}
        </header>
    );
}

function MobileLink({ to, nested = false, children }) {
    return (
        <NavLink
            to={to}
            end={to === '/'}
            className={({ isActive }) =>
                `block border-b border-white/10 py-4 font-medium transition-colors ${nested ? 'pl-4 text-base' : 'text-lg'} ${isActive ? 'text-brand' : 'text-white hover:text-brand'}`
            }
        >
            {children}
        </NavLink>
    );
}

function MobileGroup({ label, open, onToggle, children }) {
    return (
        <div>
            <button
                type="button"
                aria-expanded={open}
                onClick={onToggle}
                className="flex w-full items-center justify-between border-b border-white/10 py-4 text-lg font-medium text-white"
            >
                {label}
                <ChevronDown className={`size-5 text-brand transition-transform duration-300 ${open ? 'rotate-180' : ''}`} aria-hidden="true" />
            </button>
            {open && <div>{children}</div>}
        </div>
    );
}
