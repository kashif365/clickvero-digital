import { ChevronDown, CircleCheck } from 'lucide-react';
import { useId, useState } from 'react';
import { api } from '../../lib/api';
import { useSite } from '../../lib/site';
import Button from '../ui/Button';

const EMPTY = { name: '', email: '', phone: '', subject: '', message: '' };
const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

const FIELD =
    'w-full rounded-lg border border-white/15 bg-black/40 px-4 py-3 text-white placeholder:text-white/40 transition-[border-color,box-shadow] focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/25 aria-[invalid=true]:border-red-400';

/** Mirrors the server's rules (StoreQuoteRequest) for instant feedback; the server remains the source of truth. */
function validate(values) {
    const errors = {};

    if (!values.name.trim()) {
        errors.name = 'Please enter your name.';
    }

    if (!values.email.trim()) {
        errors.email = 'Please enter your email address.';
    } else if (!EMAIL_PATTERN.test(values.email.trim())) {
        errors.email = 'Please enter a valid email address.';
    }
    if (!values.phone.trim()){
        errors.phone = 'Please enter your phone number'
    }

    if (!values.message.trim()) {
        errors.message = 'Please tell us a little about your project.';
    } else if (values.message.length > 5000) {
        errors.message = 'Please keep your message under 5,000 characters.';
    }

    return errors;
}

function Field({ id, label, error, required = false, children }) {
    return (
        <div>
            <label htmlFor={id} className="mb-2 block text-sm font-medium">
                {label} {required && <span className="text-brand">*</span>}
            </label>
            {children}
            {error && (
                <p id={`${id}-error`} className="mt-1.5 text-sm text-red-400">
                    {error}
                </p>
            )}
        </div>
    );
}

/**
 * Quote / contact form posting to POST /api/v1/quotes. `defaultSubject`
 * preselects a service (used on service pages).
 */
export default function ContactForm({ defaultSubject = '', submitLabel = 'Send Message' }) {
    const { services } = useSite();
    const uid = useId();
    const [values, setValues] = useState({ ...EMPTY, subject: defaultSubject });
    const [errors, setErrors] = useState({});
    const [status, setStatus] = useState({ state: 'idle', message: '' });

    const id = (name) => `${uid}-${name}`;

    const bind = (name) => ({
        id: id(name),
        name,
        value: values[name],
        'aria-invalid': Boolean(errors[name]),
        'aria-describedby': errors[name] ? `${id(name)}-error` : undefined,
        onChange: (event) => {
            setValues((current) => ({ ...current, [name]: event.target.value }));
            setErrors((current) => ({ ...current, [name]: undefined }));
        },
    });

    const onSubmit = async (event) => {
        event.preventDefault();

        const clientErrors = validate(values);

        if (Object.keys(clientErrors).length > 0) {
            setErrors(clientErrors);
            setStatus({ state: 'idle', message: '' });
            document.getElementById(id(Object.keys(clientErrors)[0]))?.focus();

            return;
        }

        setStatus({ state: 'submitting', message: '' });

        try {
            const response = await api.createQuote({
                name: values.name.trim(),
                email: values.email.trim(),
                phone: values.phone.trim(),
                subject: values.subject || null,
                message: values.message.trim(),
            });

            setValues({ ...EMPTY, subject: defaultSubject });
            setErrors({});
            setStatus({ state: 'success', message: response.message });
        } catch (error) {
            // Laravel returns { errors: { field: [messages] } } on HTTP 422.
            setErrors(Object.fromEntries(Object.entries(error.errors ?? {}).map(([field, messages]) => [field, messages[0]])));
            setStatus({ state: 'error', message: error.status === 422 ? 'Please fix the highlighted fields and try again.' : error.message });
        }
    };

    return (
        <form onSubmit={onSubmit} noValidate className="space-y-5">
            <div className="grid gap-5 sm:grid-cols-2">
                <Field id={id('name')} label="Your Name" error={errors.name} required>
                    <input type="text" autoComplete="name" maxLength={255} placeholder="Jane Doe" className={FIELD} {...bind('name')} />
                </Field>
                <Field id={id('email')} label="Your Email" error={errors.email} required>
                    <input type="email" autoComplete="email" maxLength={255} placeholder="jane@company.com" className={FIELD} {...bind('email')} />
                </Field>
                <Field id={id('phone')} label="Phone Number" error={errors.phone} required>
                    <input type="tel" placeholder="(123) 456-7890" className={FIELD} {...bind('phone')} />

                </Field>
            </div>

            <Field id={id('subject')} label="Service" error={errors.subject}>
                <div className="relative">
                <select className={`${FIELD} appearance-none pr-11`} {...bind('subject')}>
                    <option value="">Select a service</option>
                    {services.map((service) => (
                        <option key={service.slug} value={service.name}>
                            {service.name}
                        </option>
                    ))}
                    <option value="Other">Something else</option>
                </select>
                <ChevronDown className="pointer-events-none absolute right-4 top-1/2 size-4 -translate-y-1/2 text-brand" aria-hidden="true" />
                </div>
            </Field>

            <Field id={id('message')} label="Project Details" error={errors.message} required>
                <textarea rows={5} maxLength={5000} placeholder="Tell us about your goals, timeline, and budget." className={FIELD} {...bind('message')} />
            </Field>

            <div aria-live="polite">
                {status.state === 'success' && (
                    <p className="flex items-start gap-2 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300">
                        <CircleCheck className="mt-0.5 size-4 shrink-0" aria-hidden="true" />
                        {status.message}
                    </p>
                )}
                {status.state === 'error' && (
                    <p role="alert" className="rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        {status.message}
                    </p>
                )}
            </div>

            <Button type="submit" loading={status.state === 'submitting'}>
                {status.state === 'submitting' ? 'Sending…' : submitLabel}
            </Button>
        </form>
    );
}
