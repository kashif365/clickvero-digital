<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    public const CACHE_KEY = 'site_settings.current';

    protected $fillable = [
        'site_name', 'title_suffix', 'default_title', 'default_description', 'default_keywords',
        'default_og_image', 'canonical_base_url', 'default_robots_index', 'default_robots_follow',
        'organization_name', 'organization_logo', 'contact_email', 'contact_phone',
        'contact_address', 'social_links',
    ];

    protected $casts = [
        'default_keywords' => 'array',
        'default_robots_index' => 'boolean',
        'default_robots_follow' => 'boolean',
        'social_links' => 'array',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::flushCache());
    }

    /**
     * The single settings row, created with sensible defaults on first access.
     * Cached as raw attributes (not the model instance) to avoid unserialize
     * issues across processes/deployments with object-based cache stores.
     */
    public static function current(): self
    {
        $attributes = Cache::rememberForever(static::CACHE_KEY, function () {
            return static::query()->firstOrCreate(['id' => 1], [
                'site_name' => config('app.name', 'Website'),
                'default_robots_index' => true,
                'default_robots_follow' => true,
            ])->getAttributes();
        });

        return (new static())->newFromBuilder($attributes);
    }

    public static function flushCache(): void
    {
        Cache::forget(static::CACHE_KEY);
    }
}
