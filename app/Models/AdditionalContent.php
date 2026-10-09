<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class AdditionalContent extends Model
{
    protected $fillable = ['page_url', 'title', 'content', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $content) {
            $content->page_url = static::normalizePath($content->page_url);
        });
    }

    /**
     * Sanitizes rich-text HTML from CKEditor before it is persisted, since the
     * frontend renders it raw ({!! !!}).
     */
    protected function content(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value !== null && trim($value) !== ''
                ? Purifier::clean($value, 'blog_content')
                : $value,
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Normalizes a path for consistent matching: ensures a single leading slash,
     * strips a trailing slash (except for the root path), and collapses repeated
     * slashes. Query strings are not part of the stored path.
     */
    public static function normalizePath(string $path): string
    {
        $path = trim($path);
        $path = parse_url($path, PHP_URL_PATH) ?: $path;
        $path = '/'.ltrim($path, '/');
        $path = preg_replace('#/+#', '/', $path);

        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        return $path;
    }

    /**
     * The active additional-content record for the given (or current) request path,
     * if any. Memoized on the current Request instance's attribute bag (not a static
     * class property) so the cache is correctly scoped to a single HTTP request and
     * never leaks between requests — including sequential requests within a test.
     */
    public static function forCurrentPath(?string $path = null): ?self
    {
        $normalized = static::normalizePath($path ?? request()->getPathInfo());
        $cacheKey = 'additional_content:'.$normalized;

        $attributes = request()->attributes;

        if ($attributes->has($cacheKey)) {
            return $attributes->get($cacheKey);
        }

        $result = static::query()->active()->where('page_url', $normalized)->first();
        $attributes->set($cacheKey, $result);

        return $result;
    }
}
