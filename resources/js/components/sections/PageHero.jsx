import { ChevronRight } from 'lucide-react';
import { Link } from 'react-router-dom';
import { ArrowLink } from '../ui/Button';

/**
 * Full-bleed hero with a darkened background image. The home page passes a
 * second column (`children`); inner pages use the shorter single-column form
 * with breadcrumbs.
 */
export default function PageHero({ eyebrow, title, accent, text, image, cta, breadcrumbs, tall = false, children }) {
    return (
        <section className={`relative flex items-center justify-center overflow-hidden ${tall ? 'min-h-[min(80vh,960px)] md:min-h-[min(90vh,960px)]' : 'min-h-[min(52vh,560px)]'}`}>
            <div className="absolute inset-0 z-0 bg-black">
                {image && <img src={image} alt="" className="absolute inset-0 size-full object-cover" fetchPriority="high" />}
                <div className="absolute inset-0 bg-linear-to-b from-black/90 to-black/60" />
            </div>

            <div className="container-site relative z-10 pb-12 pt-28 lg:pb-20 lg:pt-32">
                <div className={`grid items-center gap-12 lg:gap-20 ${children ? 'lg:grid-cols-2' : ''}`}>
                    <div className={`animate-fade-up space-y-6 ${children ? '' : 'max-w-4xl'}`}>
                        {breadcrumbs && (
                            <nav aria-label="Breadcrumb" className="flex flex-wrap items-center gap-1.5 text-sm text-white/70">
                                <Link to="/" className="hover:text-brand">
                                    Home
                                </Link>
                                {breadcrumbs.map((crumb) => (
                                    <span key={crumb.label} className="flex items-center gap-1.5">
                                        <ChevronRight className="size-3.5" aria-hidden="true" />
                                        {crumb.to ? (
                                            <Link to={crumb.to} className="hover:text-brand">
                                                {crumb.label}
                                            </Link>
                                        ) : (
                                            <span aria-current="page" className="text-brand">
                                                {crumb.label}
                                            </span>
                                        )}
                                    </span>
                                ))}
                            </nav>
                        )}
                        {eyebrow && <p className="font-medium text-brand">{eyebrow}</p>}
                        <h1 className="text-3xl font-bold leading-tight text-white md:text-4xl 2xl:text-5xl">
                            {title} {accent && <span className="text-brand">{accent}</span>}
                        </h1>
                        {text && <p className="max-w-2xl leading-relaxed text-white">{text}</p>}
                        {cta && <ArrowLink to={cta.to}>{cta.label}</ArrowLink>}
                    </div>
                    {children}
                </div>
            </div>
        </section>
    );
}
