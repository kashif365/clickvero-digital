<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\PageMeta;
use App\Models\PageSchema;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Resolves all public-facing SEO data for the current request in one place, so
 * markup is only ever rendered once (in partials.seo-meta) instead of being spread
 * across templates. Priority per field: page-specific PageMeta record, then
 * model-level data (e.g. a Blog's own title/excerpt/image), then site-wide
 * defaults, then whatever the page template itself set via @section(), then a
 * hard-coded last resort.
 */
class SeoResolver
{
    public function resolve(): array
    {
        return $this->resolveFor(Route::currentRouteName(), $this->currentBoundModel(), url()->current());
    }

    /**
     * Same resolution as resolve(), but for an explicitly given route/model/URL
     * rather than the current request — used by the API to serve SEO data for
     * client-side navigations in the React frontend.
     */
    public function resolveFor(?string $routeName, ?Model $model, string $currentUrl): array
    {
        $pageMeta = $this->findPageMeta($routeName, $model);
        $settings = SiteSetting::current();

        $modelTitle = $this->modelTitle($model);
        $modelDescription = $this->modelDescription($model);
        $modelImage = $this->modelImage($model);
        $modelKeywords = $model instanceof Service ? $model->keywordsArray() : [];

        $sectionTitle = trim((string) view()->yieldContent('title')) ?: null;
        $sectionDescription = trim((string) view()->yieldContent('description')) ?: null;

        $title = $pageMeta?->title
            ?: $modelTitle
            ?: $settings->default_title
            ?: $sectionTitle
            ?: $settings->site_name
            ?: config('app.name', 'Website');

        if ($settings->title_suffix && ! Str::endsWith($title, $settings->title_suffix)) {
            $title = trim($title).' '.$settings->title_suffix;
        }

        $description = $pageMeta?->description
            ?: $modelDescription
            ?: $settings->default_description
            ?: $sectionDescription;

        $canonicalBase = rtrim($settings->canonical_base_url ?: config('app.url'), '/');
        $canonical = $pageMeta?->canonical_url;
        if ($canonical && str_starts_with($canonical, '/')) {
            $canonical = $canonicalBase.$canonical;
        }
        $canonical = $canonical ?: $currentUrl;

        $robotsIndex = $pageMeta?->robots_index ?? $settings->default_robots_index ?? true;
        $robotsFollow = $pageMeta?->robots_follow ?? $settings->default_robots_follow ?? true;

        $keywords = ($pageMeta?->allKeywords() ?: null) ?: ($modelKeywords ?: ($settings->default_keywords ?? []));

        $ogTitle = ($pageMeta?->resolvedOgTitle()) ?: $title;
        $ogDescription = ($pageMeta?->resolvedOgDescription()) ?: $description;
        $ogImage = $pageMeta?->og_image ?: $modelImage ?: $settings->default_og_image;

        $twitterTitle = ($pageMeta?->resolvedTwitterTitle()) ?: $ogTitle;
        $twitterDescription = ($pageMeta?->resolvedTwitterDescription()) ?: $ogDescription;
        $twitterImage = $pageMeta?->resolvedTwitterImage() ?: $ogImage;

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'canonical' => $canonical,
            'robotsIndex' => (bool) $robotsIndex,
            'robotsFollow' => (bool) $robotsFollow,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription,
            'ogImage' => $ogImage,
            'twitterTitle' => $twitterTitle,
            'twitterDescription' => $twitterDescription,
            'twitterImage' => $twitterImage,
            'siteName' => $settings->site_name ?: config('app.name'),
            'schemas' => array_merge(
                PageSchema::applicableTo($routeName, $model),
                $this->autoSchemasFor($model, $canonical)
            ),
        ];
    }

    private function modelTitle(?Model $model): ?string
    {
        if ($model instanceof Service) {
            return $model->effectiveSeoTitle();
        }

        return $model?->title;
    }

    private function modelDescription(?Model $model): ?string
    {
        if ($model instanceof Blog) {
            return $model->excerpt ?: (Str::limit(trim(strip_tags((string) $model->content)), 160) ?: null);
        }

        if ($model instanceof Service) {
            return $model->effectiveSeoDescription();
        }

        return null;
    }

    private function modelImage(?Model $model): ?string
    {
        if ($model instanceof Blog) {
            return $model->image;
        }

        if ($model instanceof Service) {
            return $model->banner_image;
        }

        return null;
    }

    /**
     * Structured data that doesn't require a manually-created PageSchema record:
     * a Service page automatically gets a Service schema (and a FAQPage schema
     * when it has FAQs), built from the model's own current data every request
     * so it never goes stale.
     */
    private function autoSchemasFor(?Model $model, string $canonical): array
    {
        if (! $model instanceof Service) {
            return [];
        }

        $schemas = [
            new PageSchema([
                'schema_type' => 'Service',
                'schema_json' => array_filter([
                    'name' => $model->name,
                    'description' => $model->effectiveSeoDescription(),
                    'url' => $canonical,
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => SiteSetting::current()->organization_name ?: SiteSetting::current()->site_name,
                    ],
                ]),
            ]),
        ];

        $faqs = $model->faqList();

        if ($faqs) {
            $schemas[] = new PageSchema([
                'schema_type' => 'FAQPage',
                'schema_json' => [
                    'mainEntity' => array_map(fn (array $faq) => [
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['answer'],
                        ],
                    ], $faqs),
                ],
            ]);
        }

        return $schemas;
    }

    private function currentBoundModel(): ?Model
    {
        $route = Route::current();

        if (! $route) {
            return null;
        }

        foreach ($route->parameters() as $parameter) {
            if ($parameter instanceof Model) {
                return $parameter;
            }
        }

        return null;
    }

    private function findPageMeta(?string $routeName, ?Model $model): ?PageMeta
    {
        if ($model) {
            $record = PageMeta::where('seoable_type', $model::class)
                ->where('seoable_id', $model->getKey())
                ->active()
                ->first();

            if ($record) {
                return $record;
            }
        }

        if ($routeName) {
            return PageMeta::where('route', $routeName)->active()->first();
        }

        return null;
    }
}
