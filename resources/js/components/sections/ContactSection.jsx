import { Mail, MapPin, Phone } from 'lucide-react';
import { contactReasons } from '../../content/site';
import { useSite } from '../../lib/site';
import Icon from '../ui/Icon';
import ContactForm from './ContactForm';

/** Lead form with the "Why us?" side cards; closes most pages. */
export default function ContactSection({ defaultSubject, as: Heading = 'h2' }) {
    const site = useSite();
    const brand = site.name.split(' ')[0];

    return (
        <section id="contact" className="overflow-x-hidden py-16 md:py-24">
            <div className="container-site">
                <div className="mb-12 flex flex-col items-start justify-between gap-4 md:mb-16 md:flex-row md:items-center">
                    <Heading className="max-w-2xl text-2xl font-bold leading-tight md:text-3xl lg:text-4xl">
                        Got a Goal? Let&rsquo;s Turn it into <span className="text-brand">Measurable Growth</span>
                    </Heading>
                    <p className="max-w-xl leading-relaxed text-muted-foreground">
                        Share your project details, and our team will get back to you within one business day with the next steps.
                    </p>
                </div>

                <div className="grid grid-cols-1 gap-8 lg:grid-cols-10">
                    <div className="rounded-2xl border bg-card p-6 shadow-lg md:p-8 lg:col-span-6">
                        <h3 className="mb-6 text-2xl font-bold">Send us a message</h3>
                        <ContactForm defaultSubject={defaultSubject} />
                    </div>

                    <div className="flex flex-col gap-6 lg:col-span-4">
                        <div className="rounded-2xl border bg-card p-6 shadow-lg md:p-8">
                            <h3 className="mb-6 text-xl font-bold">Why {brand}?</h3>
                            {contactReasons.map((reason) => (
                                <div key={reason.title} className="flex items-center gap-4 py-2.5">
                                    <span className="flex size-11 shrink-0 items-center justify-center rounded-xl border border-brand/30 bg-brand/10 text-brand">
                                        <Icon name={reason.icon} className="size-5" />
                                    </span>
                                    <div>
                                        <h4 className="mb-1 font-semibold">{reason.title}</h4>
                                        <p className="leading-relaxed text-muted-foreground">{reason.text}</p>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {(site.email || site.phone || site.address) && (
                            <div className="rounded-2xl border bg-card p-6 shadow-lg md:p-8">
                                <h3 className="mb-5 text-xl font-bold">Reach us directly</h3>
                                <ul className="space-y-4">
                                    {site.email && (
                                        <li>
                                            <a href={`mailto:${site.email}`} className="flex items-center gap-3 break-all transition-colors hover:text-brand">
                                                <Mail className="size-5 shrink-0 text-brand" aria-hidden="true" />
                                                {site.email}
                                            </a>
                                        </li>
                                    )}
                                    {site.phone && (
                                        <li>
                                            <a href={`tel:${site.phone.replace(/[^+\d]/g, '')}`} className="flex items-center gap-3 transition-colors hover:text-brand">
                                                <Phone className="size-5 shrink-0 text-brand" aria-hidden="true" />
                                                {site.phone}
                                            </a>
                                        </li>
                                    )}
                                    {site.address && (
                                        <li className="flex items-start gap-3">
                                            <MapPin className="mt-0.5 size-5 shrink-0 text-brand" aria-hidden="true" />
                                            {site.address}
                                        </li>
                                    )}
                                </ul>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}
