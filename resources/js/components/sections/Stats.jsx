import { Clock, Globe2, Layers, Route } from 'lucide-react';
import { stats } from '../../content/site';
import { useSite } from '../../lib/site';
import Reveal from '../ui/Reveal';

const ICONS = [Layers, Route, Clock, Globe2];

export default function Stats() {
    const { services } = useSite();

    return (
        <section className="py-10 md:py-20">
            <div className="container-site">
                <div className="mx-auto grid max-w-6xl grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4 lg:gap-8">
                    {stats(services.length).map((stat, index) => {
                        const IconComponent = ICONS[index % ICONS.length];

                        return (
                            <Reveal
                                key={stat.label}
                                delay={index * 80}
                                className="group rounded-2xl border bg-card/50 p-6 backdrop-blur-sm transition-[background-color,border-color,box-shadow] duration-300 hover:border-brand hover:bg-card hover:shadow-xl lg:min-h-72"
                            >
                                <div className="mb-4 size-12 rounded-xl bg-linear-to-br from-yellow-500 to-orange-500 p-0.5 transition-transform group-hover:scale-110">
                                    <div className="flex size-full items-center justify-center rounded-[10px] bg-background">
                                        <IconComponent className="size-5 text-brand" aria-hidden="true" />
                                    </div>
                                </div>
                                <div className="mb-2 text-3xl font-bold lg:text-4xl">{stat.value}</div>
                                <p className="font-medium md:text-lg">{stat.label}</p>
                                <p className="mt-2 leading-relaxed text-muted-foreground">{stat.text}</p>
                            </Reveal>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
