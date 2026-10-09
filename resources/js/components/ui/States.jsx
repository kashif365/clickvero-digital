import { CircleAlert, Inbox } from 'lucide-react';

export function Skeleton({ className = '' }) {
    return <div className={`animate-pulse rounded-xl bg-muted ${className}`} aria-hidden="true" />;
}

export function ErrorState({ message = 'We could not load this content.', onRetry }) {
    return (
        <div role="alert" className="flex flex-col items-center gap-4 rounded-2xl border border-red-500/30 bg-red-500/5 px-6 py-12 text-center">
            <CircleAlert className="size-8 text-red-400" aria-hidden="true" />
            <p className="text-foreground/90">{message}</p>
            {onRetry && (
                <button
                    type="button"
                    onClick={onRetry}
                    className="rounded-md border border-white/20 px-5 py-2 text-sm font-semibold transition-colors hover:border-brand hover:text-brand"
                >
                    Try again
                </button>
            )}
        </div>
    );
}

export function EmptyState({ title, text }) {
    return (
        <div className="flex flex-col items-center gap-3 rounded-2xl border border-dashed px-6 py-14 text-center">
            <Inbox className="size-8 text-muted-foreground" aria-hidden="true" />
            <p className="text-lg font-semibold">{title}</p>
            {text && <p className="max-w-md text-muted-foreground">{text}</p>}
        </div>
    );
}
