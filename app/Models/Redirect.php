<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    public const TYPES = [301, 302, 307, 308];

    public const CACHE_KEY = 'redirects.active_map';

    /**
     * Path prefixes that may never be used as a redirect source, so this feature
     * can't accidentally (or maliciously) hijack system/framework routes.
     */
    public const PROTECTED_PREFIXES = [
        '/admin', '/api', '/storage', '/build', '/assets', '/login', '/logout', '/sanctum', '/up',
    ];

    public const PROTECTED_EXACT = ['/robots.txt', '/sitemap.xml'];

    protected $fillable = [
        'name', 'source_path', 'destination', 'type', 'is_active', 'notes', 'created_by',
    ];

    protected $casts = [
        'type' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Redirect $redirect) {
            $redirect->source_path = static::normalizePath($redirect->source_path);
        });

        static::saved(fn () => static::flushCache());
        static::deleted(fn () => static::flushCache());
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Normalizes a path for consistent matching: ensures a single leading slash,
     * strips a trailing slash (except for the root path), and collapses repeated
     * slashes. Query strings are not part of the stored source path.
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

    public static function isProtectedPath(string $path): bool
    {
        $path = static::normalizePath($path);

        if (in_array($path, static::PROTECTED_EXACT, true)) {
            return true;
        }

        foreach (static::PROTECTED_PREFIXES as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                return true;
            }
        }

        return false;
    }

    /**
     * A destination is safe if it's an internal path or an http(s) URL —
     * never javascript:, data:, vbscript:, file:, or other dangerous schemes.
     */
    public static function isSafeDestination(string $destination): bool
    {
        $destination = trim($destination);

        if ($destination === '') {
            return false;
        }

        if (str_starts_with($destination, '/') && ! str_starts_with($destination, '//')) {
            return true;
        }

        return (bool) preg_match('#^https?://#i', $destination);
    }

    /**
     * The full active-redirects map, cached indefinitely and invalidated whenever
     * a redirect is created, updated, deleted, activated, or deactivated. Avoids
     * a database query on every request beyond this single cached read.
     */
    public static function activeMap(): array
    {
        return Cache::rememberForever(static::CACHE_KEY, function () {
            return static::query()
                ->active()
                ->get(['source_path', 'destination', 'type'])
                ->mapWithKeys(fn (Redirect $redirect) => [
                    $redirect->source_path => [
                        'destination' => $redirect->destination,
                        'type' => $redirect->type,
                    ],
                ])
                ->all();
        });
    }

    public static function flushCache(): void
    {
        Cache::forget(static::CACHE_KEY);
    }
}
