<?php

namespace App\Models;

use App\Services\SitemapGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PageMeta extends Model
{
    public const STATIC_ROUTES = [
        'home', 'about', 'blog', 'contact', 'faq', 'pricing',
        'project', 'project-details', 'service', 'team', 'team-details',
    ];

    protected $fillable = [
        'route', 'seoable_type', 'seoable_id', 'title', 'description', 'keywords',
        'focus_keyword', 'secondary_keywords', 'canonical_url', 'robots_index', 'robots_follow',
        'og_title', 'og_description', 'og_image', 'twitter_title', 'twitter_description',
        'twitter_image', 'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'secondary_keywords' => 'array',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::regenerateSitemap());
        static::deleted(fn () => static::regenerateSitemap());
    }

    private static function regenerateSitemap(): void
    {
        try {
            app(SitemapGenerator::class)->regenerate();
        } catch (\Throwable) {
            // Non-critical: the admin "Regenerate Sitemap" button remains available.
        }
    }

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function robotsContent(): string
    {
        return implode(',', [
            $this->robots_index ? 'index' : 'noindex',
            $this->robots_follow ? 'follow' : 'nofollow',
        ]);
    }

    public function resolvedOgTitle(): ?string
    {
        return $this->og_title ?: $this->title;
    }

    public function resolvedOgDescription(): ?string
    {
        return $this->og_description ?: $this->description;
    }

    public function resolvedTwitterTitle(): ?string
    {
        return $this->twitter_title ?: $this->resolvedOgTitle();
    }

    public function resolvedTwitterDescription(): ?string
    {
        return $this->twitter_description ?: $this->resolvedOgDescription();
    }

    public function resolvedTwitterImage(): ?string
    {
        return $this->twitter_image ?: $this->og_image;
    }

    public function allKeywords(): array
    {
        return array_values(array_unique(array_filter(array_merge(
            $this->keywords ?? [],
            $this->secondary_keywords ?? [],
            $this->focus_keyword ? [$this->focus_keyword] : []
        ))));
    }
}
