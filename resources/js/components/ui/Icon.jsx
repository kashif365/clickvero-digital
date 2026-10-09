import {
    CalendarCheck,
    Cpu,
    Headset,
    Layers,
    LifeBuoy,
    Lightbulb,
    LineChart,
    Sparkles,
    Target,
    Trophy,
    Users,
    Zap,
} from 'lucide-react';

const ICONS = { CalendarCheck, Cpu, Headset, Layers, LifeBuoy, Lightbulb, LineChart, Target, Trophy, Users, Zap };

/** Resolves an icon by the name used in content/site.js. */
export default function Icon({ name, ...props }) {
    const Component = ICONS[name] ?? Sparkles;

    return <Component aria-hidden="true" {...props} />;
}
