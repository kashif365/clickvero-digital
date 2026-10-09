<?php

namespace App\Models;

use App\Services\SitemapGenerator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'author', 'image', 'excerpt', 'content', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::regenerateSitemap());
        static::deleted(fn () => static::regenerateSitemap());
    }

    /**
     * Keeps sitemap.xml current whenever a blog post is published, edited, or removed.
     * Silently ignored on failure (e.g. disk unavailable) so it never blocks saving a post.
     */
    private static function regenerateSitemap(): void
    {
        try {
            app(SitemapGenerator::class)->regenerate();
        } catch (\Throwable) {
            // Non-critical: the admin "Regenerate Sitemap" button remains available.
        }
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
        
    }

    /**
     * Sanitizes rich-text HTML from the CKEditor field before it is persisted,
     * since $blog->content is rendered raw ({!! !!}) on the public blog page.
     */
    protected function content(): Attribute
    {
        return Attribute::make(
            set: function (?string $value) {
                if ($value === null || trim($value) === '') {
                    return $value;
                }

                return static::markExternalLinks(Purifier::clean($value, 'blog_content'));
            },
        );
    }

    private static function markExternalLinks(string $html): string
    {
        if (! str_contains($html, '<a ') && ! str_contains($html, '<a>')) {
            return $html;
        }

        $appHost = parse_url(config('app.url'), PHP_URL_HOST);

        $document = new \DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML(
            '<?xml encoding="UTF-8"><div>'.$html.'</div>',
            LIBXML_NOERROR | LIBXML_NOWARNING
        );
        libxml_clear_errors();

        foreach ($document->getElementsByTagName('a') as $link) {
            $href = $link->getAttribute('href');
            $host = parse_url($href, PHP_URL_HOST);

            if ($host && $host !== $appHost) {
                $link->setAttribute('target', '_blank');
                $link->setAttribute('rel', 'noopener noreferrer');
            }
        }

        $container = $document->getElementsByTagName('div')->item(0);
        $inner = '';
        foreach ($container->childNodes as $child) {
            $inner .= $document->saveHTML($child);
        }

        return $inner;
    }
}
