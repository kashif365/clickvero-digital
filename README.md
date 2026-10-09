# Clickvora Digital

Digital marketing agency website: a React single-page frontend served by a Laravel 13 backend.

- **Frontend:** React 19, React Router 7, Tailwind CSS 4, Vite 8 (`resources/js`, `resources/css`)
- **Backend:** Laravel 13 / PHP 8.3, MySQL
- **Admin panel:** server-rendered Blade at `/admin` (session auth)

## Requirements

- PHP 8.3+, Composer
- Node.js 20+
- MySQL 5.7+ / 8

## Setup

```bash
composer install
npm install
cp .env.example .env        # then set DB_* and APP_URL
php artisan key:generate
php artisan migrate --seed  # creates tables, admin user, services, sample blogs
php artisan storage:link
```

## Running locally

```bash
php artisan serve --port=8010   # Laravel (API, admin, SPA shell)
npm run dev                     # Vite dev server with hot reload
```

Open the URL printed by `php artisan serve`. Without `npm run dev`, Laravel serves the last production build from `public/build`.

Production build:

```bash
npm run build
```

## Tests

```bash
php artisan test
```

Tests run against an in-memory SQLite database and never touch the MySQL data.

## Architecture

| Concern | Where |
| --- | --- |
| Public pages | React app in `resources/js` (pages, components, content) |
| SPA shell + server-rendered SEO tags | `resources/views/spa.blade.php`, `partials/seo-meta.blade.php` |
| Public JSON API | `routes/api.php` → `app/Http/Controllers/Api` |
| Admin panel | `routes/web.php` (`/admin`) → `app/Http/Controllers/Admin`, `resources/views/admin` |
| SEO resolution | `app/Services/SeoResolver.php` |

Every public URL keeps its named Laravel route in `routes/web.php`, and each returns the same `spa` view. That keeps server-side meta tags, JSON-LD schemas, redirects, `robots.txt`, and the sitemap working, while React Router renders the page. The React route table in `resources/js/App.jsx` mirrors those routes one-to-one — add a page in both places.

### API (`/api/v1`)

| Method | Endpoint | Purpose |
| --- | --- | --- |
| GET | `/site` | Site name, contact details, active services |
| GET | `/page?path=/about` | SEO tags and admin "additional content" for a path |
| GET | `/services` | Active services |
| GET | `/services/{slug}` | Service detail with description and FAQs |
| GET | `/blogs?search=&category=&page=&per_page=` | Paginated posts and category list |
| GET | `/blogs/{slug}` | Post detail and related posts |
| POST | `/quotes` | Contact / quote form (rate limited: 6 per minute) |

Validation errors use Laravel's standard `422` shape: `{ "message": "...", "errors": { "field": ["..."] } }`.

### Content sources

- **Admin-managed (database):** services, blog posts, testimonials, team members, quotes, page SEO, schemas, redirects, robots, sitemap, additional content, site settings (name, email, phone, address, social links).
- **Static copy:** `resources/js/content/site.js` — process steps, growth playbooks, FAQs, pricing plans, team disciplines.

The testimonials section and the team grid are hidden on the website until at least one active entry exists.

### Seeders

| Seeder | Content | Runs in production |
| --- | --- | --- |
| `AdminUserSeeder` | Admin login | yes |
| `PageMetaSeeder` | SEO titles and descriptions per page | yes |
| `ServiceSeeder` | The seven services with descriptions and FAQs | yes |
| `BlogSeeder` | Nine full-length articles across eight categories | yes |
| `DemoContentSeeder` | Placeholder testimonials and team members for UI review — **not real people** | no |

Seeders use `updateOrCreate`, so they are safe to re-run: `php artisan db:seed --class=BlogSeeder`.

## Admin

Sign in at `/admin/login`. The seeded account is defined in `database/seeders/AdminUserSeeder.php` — change its password before deploying.
