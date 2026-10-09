import Button from '../components/ui/Button';

export default function NotFound() {
    return (
        <section className="flex min-h-[80vh] items-center justify-center px-4 pt-24 text-center">
            <div>
                <p className="text-[110px] font-bold leading-none text-brand md:text-[160px]">404</p>
                <h1 className="mt-4 text-2xl font-bold md:text-4xl">This page could not be found</h1>
                <p className="mx-auto mt-4 max-w-md leading-relaxed text-muted-foreground">
                    The page you are looking for may have been moved, renamed, or is no longer available.
                </p>
                <div className="mt-8 flex flex-col justify-center gap-4 sm:flex-row">
                    <Button to="/">Back to Home</Button>
                    <Button to="/contact" variant="outline">
                        Contact Us
                    </Button>
                </div>
            </div>
        </section>
    );
}
