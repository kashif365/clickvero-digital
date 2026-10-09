<?php

namespace App\Services;

use App\Models\Service;
use App\Models\SiteSetting;

/**
 * Public, non-sensitive site data shared with the React frontend: branding,
 * contact details, and the active services used by the navigation. Embedded in
 * the SPA shell on first load and exposed at /api/v1/site.
 */
class SitePayload
{
    public function toArray(): array
    {
        $settings = SiteSetting::current();

        return [
            'name' => $settings->site_name ?: config('app.name'),
            'email' => $settings->contact_email,
            'phone' => $settings->contact_phone,
            'address' => $settings->contact_address,
            'social_links' => $settings->social_links ?? [],
            'services' => Service::active()->ordered()
                ->get(['id', 'name', 'slug', 'short_description', 'banner_image'])
                ->toArray(),
        ];
    }
}
