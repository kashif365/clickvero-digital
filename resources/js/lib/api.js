const BASE_URL = '/api/v1';

/**
 * Error thrown for any non-2xx API response. `errors` holds Laravel's
 * field-level validation messages (HTTP 422) keyed by field name.
 */
export class ApiError extends Error {
    constructor(message, status, errors = {}) {
        super(message);
        this.name = 'ApiError';
        this.status = status;
        this.errors = errors;
    }
}

async function request(path, { method = 'GET', params, body, signal } = {}) {
    const url = new URL(BASE_URL + path, window.location.origin);

    Object.entries(params ?? {}).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
            url.searchParams.set(key, value);
        }
    });

    let response;

    try {
        response = await fetch(url, {
            method,
            signal,
            headers: {
                Accept: 'application/json',
                ...(body ? { 'Content-Type': 'application/json' } : {}),
            },
            body: body ? JSON.stringify(body) : undefined,
        });
    } catch (error) {
        if (error.name === 'AbortError') {
            throw error;
        }

        throw new ApiError('Network error — please check your connection and try again.', 0);
    }

    const payload = await response.json().catch(() => null);

    if (!response.ok) {
        const fallback =
            response.status === 429
                ? 'Too many requests. Please wait a minute and try again.'
                : 'Something went wrong. Please try again.';

        throw new ApiError(payload?.message || fallback, response.status, payload?.errors ?? {});
    }

    return payload;
}

export const api = {
    page: (path, signal) => request('/page', { params: { path }, signal }),
    services: (signal) => request('/services', { signal }),
    service: (slug, signal) => request(`/services/${encodeURIComponent(slug)}`, { signal }),
    blogs: (params, signal) => request('/blogs', { params, signal }),
    blog: (slug, signal) => request(`/blogs/${encodeURIComponent(slug)}`, { signal }),
    testimonials: (signal) => request('/testimonials', { signal }),
    team: (signal) => request('/team', { signal }),
    createQuote: (data) => request('/quotes', { method: 'POST', body: data }),
};
