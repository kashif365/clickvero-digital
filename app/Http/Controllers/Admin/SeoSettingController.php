<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoSettingController extends Controller
{
    public function edit()
    {
        return view('admin.seo-settings.edit', ['settings' => SiteSetting::current()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'title_suffix' => ['nullable', 'string', 'max:100'],
            'default_title' => ['nullable', 'string', 'max:255'],
            'default_description' => ['nullable', 'string', 'max:500'],
            'default_keywords' => ['nullable', 'string'],
            'default_og_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'canonical_base_url' => ['nullable', 'string', 'max:255', 'url'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'organization_logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
        ]);

        $settings = SiteSetting::current();

        $update = [
            'site_name' => $data['site_name'] ?? null,
            'title_suffix' => $data['title_suffix'] ?? null,
            'default_title' => $data['default_title'] ?? null,
            'default_description' => $data['default_description'] ?? null,
            'default_keywords' => ! empty($data['default_keywords'])
                ? array_values(array_filter(array_map('trim', explode(',', $data['default_keywords']))))
                : [],
            'canonical_base_url' => rtrim($data['canonical_base_url'] ?? '', '/') ?: null,
            'organization_name' => $data['organization_name'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
            'contact_address' => $data['contact_address'] ?? null,
            'default_robots_index' => $request->boolean('default_robots_index', true),
            'default_robots_follow' => $request->boolean('default_robots_follow', true),
            'social_links' => array_filter([
                'facebook' => $data['facebook'] ?? null,
                'twitter' => $data['twitter'] ?? null,
                'instagram' => $data['instagram'] ?? null,
                'linkedin' => $data['linkedin'] ?? null,
                'youtube' => $data['youtube'] ?? null,
            ]),
        ];

        if ($request->hasFile('default_og_image_file')) {
            $update['default_og_image'] = Storage::url(Storage::disk('public')->putFile('seo', $request->file('default_og_image_file')));
        }

        if ($request->hasFile('organization_logo_file')) {
            $update['organization_logo'] = Storage::url(Storage::disk('public')->putFile('seo', $request->file('organization_logo_file')));
        }

        $settings->update($update);

        return redirect()->route('admin.seo-settings.edit')->with('success', 'SEO settings updated.');
    }
}
