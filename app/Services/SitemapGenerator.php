<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\PageMeta;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/**
 * Builds sitemap.xml dynamically from active, indexable pages and blog posts,
 * reusing the same storage location the admin "upload sitemap" screen already
 * serves from — no second/competing sitemap mechanism.
 */
class SitemapGenerator
{
    public const FILENAME = 'sitemap.xml';

    public function regenerate(): void
    {
        Storage::disk('public')->put(self::FILENAME, $this->build());
    }

    public function build(): string
    {
        $urls = collect();

        $staticMetas = PageMeta::whereIn('route', PageMeta::STATIC_ROUTES)->get()->keyBy('route');

        foreach (PageMeta::STATIC_ROUTES as $routeName) {
            if (! Route::has($routeName)) {
                continue;
            }

            $pageMeta = $staticMetas->get($routeName);

            if ($pageMeta && (! $pageMeta->is_active || ! $pageMeta->robots_index)) {
                continue;
            }

            $urls->push([
                'loc' => $this->resolveLoc($pageMeta, fn () => route($routeName)),
                'lastmod' => $pageMeta?->updated_at ?? now(),
            ]);
        }

        $blogMetas = PageMeta::where('seoable_type', Blog::class)->get()->keyBy('seoable_id');

        foreach (Blog::all() as $blog) {
            $pageMeta = $blogMetas->get($blog->id);

            if ($pageMeta && (! $pageMeta->is_active || ! $pageMeta->robots_index)) {
                continue;
            }

            $urls->push([
                'loc' => $this->resolveLoc($pageMeta, fn () => route('blog-details', $blog)),
                'lastmod' => $pageMeta?->updated_at ?? $blog->updated_at,
            ]);
        }

        return $this->toXml($urls);
    }

    private function resolveLoc(?PageMeta $pageMeta, \Closure $default): string
    {
        if ($pageMeta?->canonical_url && str_starts_with($pageMeta->canonical_url, 'http')) {
            return $pageMeta->canonical_url;
        }

        return $default();
    }

    private function toXml($urls): string
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        foreach ($urls as $url) {
            $node = $xml->addChild('url');
            $node->addChild('loc', htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8'));
            $node->addChild('lastmod', $url['lastmod']->toAtomString());
        }

        return $xml->asXML();
    }
}
