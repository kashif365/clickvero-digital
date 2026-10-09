import { Check } from 'lucide-react';
import { useState } from 'react';
import ContactSection from '../components/sections/ContactSection';
import FaqSection from '../components/sections/FaqSection';
import PageHero from '../components/sections/PageHero';
import Button from '../components/ui/Button';
import Reveal from '../components/ui/Reveal';
import SectionHeading from '../components/ui/SectionHeading';
import { faqGroups, images, pricing } from '../content/site';

export default function Pricing() {
    const [period, setPeriod] = useState(pricing.periods[0].key);
    const activePeriod = pricing.periods.find((option) => option.key === period);

    return (
        <>
            <PageHero
                image={images.campaign}
                eyebrow="Pricing"
                title="Pricing &"
                accent="Engagement Models"
                text="Good marketing shouldn't require a mystery quote. Choose the level of support that fits where your business is today."
                breadcrumbs={[{ label: 'Pricing' }]}
            />

            <section className="relative overflow-hidden py-12 md:py-24">
                <div className="pointer-events-none absolute -right-52 bottom-0 size-[460px] rounded-full bg-brand/5 blur-[170px]" />
                <div className="container-site relative">
                    <SectionHeading title="Find your" accent="perfect plan" className="!mb-8" />

                    <div className="mb-10 flex flex-col items-center gap-3 md:mb-12">
                        <div role="group" aria-label="Billing commitment" className="flex rounded-full border bg-card p-1">
                            {pricing.periods.map((option) => (
                                <button
                                    key={option.key}
                                    type="button"
                                    aria-pressed={period === option.key}
                                    onClick={() => setPeriod(option.key)}
                                    className={`rounded-full px-4 py-2.5 text-sm font-semibold transition-colors sm:px-7 ${period === option.key ? 'bg-brand text-black' : 'text-white/70 hover:text-white'}`}
                                >
                                    {option.label}
                                </button>
                            ))}
                        </div>
                        <p className="text-sm text-muted-foreground" aria-live="polite">
                            {activePeriod.note}
                        </p>
                    </div>

                    <div className="mx-auto grid max-w-6xl gap-6 lg:grid-cols-3 lg:items-stretch">
                        {pricing.plans.map((plan, index) => (
                            <Reveal
                                key={plan.name}
                                delay={index * 80}
                                className={`relative flex flex-col rounded-[30px] border p-6 transition-colors sm:p-8 ${plan.featured ? 'border-brand bg-[linear-gradient(180deg,rgba(253,199,0,0.12),rgba(253,199,0,0.02))]' : 'bg-card hover:border-brand/50'}`}
                            >
                                {plan.featured && (
                                    <span className="absolute -top-3 left-6 rounded-full bg-brand px-4 py-1 text-xs font-bold uppercase tracking-wide text-black sm:left-8">
                                        Most popular
                                    </span>
                                )}
                                <h2 className="text-xl font-bold">{plan.name}</h2>
                                <p className="mt-2 min-h-12 leading-relaxed text-muted-foreground">{plan.summary}</p>
                                <p className="mt-5 flex items-end gap-1">
                                    <span className="text-5xl font-bold text-brand">${plan.price[period]}</span>
                                    <span className="pb-1.5 text-muted-foreground">/mo</span>
                                </p>
                                <ul className="my-8 flex-1 space-y-4 border-t pt-8">
                                    {plan.features.map((feature) => (
                                        <li key={feature} className="flex items-start gap-3 leading-snug">
                                            <Check className="mt-0.5 size-5 shrink-0 text-brand" aria-hidden="true" />
                                            {feature}
                                        </li>
                                    ))}
                                </ul>
                                <Button to="/contact" variant={plan.featured ? 'primary' : 'outline'} className="!w-full">
                                    Choose {plan.name}
                                </Button>
                            </Reveal>
                        ))}
                    </div>

                    <ul className="mx-auto mt-10 max-w-3xl space-y-2 text-center text-sm leading-relaxed text-muted-foreground">
                        {pricing.notes.map((note) => (
                            <li key={note}>{note}</li>
                        ))}
                    </ul>
                </div>
            </section>

            <FaqSection items={faqGroups[2].items} title="Pricing" accent="questions" text="The practical details of working with us." />
            <ContactSection />
        </>
    );
}
