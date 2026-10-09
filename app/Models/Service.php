<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class Service extends Model
{
    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'banner_image', 'faqs',
        'seo_title', 'seo_description', 'keywords', 'status', 'sort_order',
    ];

    protected $casts = [
        'faqs' => 'array',
        'status' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Sanitizes rich-text HTML from CKEditor before it is persisted, since the
     * frontend renders it raw ({!! !!}).
     */
    protected function description(): Attribute
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /** SEO title fallback used by SeoResolver: explicit seo_title, else the service name. */
    public function effectiveSeoTitle(): string
    {
        return $this->seo_title ?: $this->name;
    }

    /** SEO description fallback used by SeoResolver: explicit seo_description, else the short description. */
    public function effectiveSeoDescription(): ?string
    {
        return $this->seo_description ?: $this->short_description;
    }

    public function keywordsArray(): array
    {
        if (! $this->keywords) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->keywords))));
    }

    /** Valid, non-empty FAQ question/answer pairs, in the order stored. */
    public function faqList(): array
    {
        return collect($this->faqs ?? [])
            ->filter(fn ($faq) => ! empty($faq['question']) && ! empty($faq['answer']))
            ->values()
            ->all();
    }
}
