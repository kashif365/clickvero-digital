<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;

class PageSchema extends Model
{
    public const CACHE_KEY = 'page_schemas.active';

    public const SCOPES = ['global', 'route', 'model'];

    public const SCHEMA_TYPES = [
        'Organization', 'LocalBusiness', 'WebSite', 'WebPage', 'Article', 'BlogPosting',
        'BreadcrumbList', 'FAQPage', 'Product', 'Service', 'Person', 'Review',
        'AggregateRating', 'Custom',
    ];

    protected $table = 'page_schemas';

    protected $fillable = [
        'name', 'schema_type', 'scope', 'route_name', 'seoable_type', 'seoable_id',
        'schema_json', 'is_active', 'priority', 'notes',
    ];

    protected $casts = [
        'schema_json' => 'array',
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::flushCache());
        static::deleted(fn () => static::flushCache());
    }

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * The JSON-LD document ready to output: guarantees "@context" is present
     * without requiring the admin to type it, and injects "@type" from the
     * selected schema type if the stored JSON omitted it.
     */
    public function ldJson(): array
    {
        $data = $this->schema_json ?? [];

        if (! isset($data['@context'])) {
            $data = ['@context' => 'https://schema.org'] + $data;
        }

        if (! isset($data['@type']) && $this->schema_type !== 'Custom') {
            $data['@type'] = $this->schema_type;
        }

        return $data;
    }

    /**
     * All active schemas applicable to the current request: sitewide "global"
     * schemas, plus any scoped to the given route name or bound model, ordered
     * by priority. Cached as raw attribute arrays (not model instances, to avoid
     * unserialize issues across processes/deployments) and invalidated on write.
     */
    public static function applicableTo(?string $routeName, ?Model $model = null): array
    {
        $rows = Cache::rememberForever(static::CACHE_KEY, function () {
            return static::query()->active()->orderBy('priority')->get()
                ->map(fn (PageSchema $schema) => $schema->getAttributes())
                ->all();
        });

        $all = collect($rows)->map(fn (array $attributes) => (new static())->newFromBuilder($attributes));

        return $all->filter(function (PageSchema $schema) use ($routeName, $model) {
            if ($schema->scope === 'global') {
                return true;
            }

            if ($schema->scope === 'route') {
                return $routeName !== null && $schema->route_name === $routeName;
            }

            if ($schema->scope === 'model' && $model !== null) {
                return $schema->seoable_type === $model::class && (int) $schema->seoable_id === (int) $model->getKey();
            }

            return false;
        })->values()->all();
    }

    public static function flushCache(): void
    {
        Cache::forget(static::CACHE_KEY);
    }
}
