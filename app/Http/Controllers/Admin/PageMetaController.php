<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\PageMeta;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PageMetaController extends Controller
{
    public function index(Request $request)
    {
        $query = PageMeta::query()->with('seoable');

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('route', 'like', "%{$search}%");
            });
        }

        return view('admin.page-metas.index', [
            'pageMetas' => $query->orderByRaw('route IS NULL')->orderBy('route')->paginate(15)->withQueryString(),
            'filters' => $request->only('search'),
        ]);
    }

    public function create()
    {
        return view('admin.page-metas.create', [
            'availableRoutes' => $this->availableStaticRoutes(),
            'availableBlogs' => $this->availableBlogs(),
        ]);
    }

    public function store(Request $request)
    {
        $target = $this->validatedTarget($request);
        $data = $this->validated($request);

        PageMeta::create(array_merge($data, $target));

        return redirect()->route('admin.page-metas.index')->with('success', 'Page SEO record created.');
    }

    public function edit(PageMeta $pageMeta)
    {
        return view('admin.page-metas.edit', ['pageMeta' => $pageMeta->load('seoable')]);
    }

    public function update(Request $request, PageMeta $pageMeta)
    {
        $data = $this->validated($request, $pageMeta);

        $pageMeta->update($data);

        return redirect()->route('admin.page-metas.index')->with('success', 'Page SEO record updated.');
    }

    public function destroy(PageMeta $pageMeta)
    {
        $pageMeta->delete();

        return redirect()->route('admin.page-metas.index')->with('success', 'Page SEO record deleted.');
    }

    /**
     * Static route names that may receive an SEO record but don't already have one,
     * plus the currently edited record's own route (so it still appears while editing).
     */
    private function availableStaticRoutes(): array
    {
        $used = PageMeta::whereNotNull('route')->pluck('route')->all();

        return array_values(array_diff(PageMeta::STATIC_ROUTES, $used));
    }

    private function availableBlogs()
    {
        $used = PageMeta::where('seoable_type', Blog::class)->pluck('seoable_id')->all();

        return Blog::whereNotIn('id', $used)->orderBy('title')->get(['id', 'title', 'slug']);
    }

    private function validatedTarget(Request $request): array
    {
        $request->validate([
            'target_type' => ['required', Rule::in(['route', 'blog'])],
        ]);

        if ($request->input('target_type') === 'route') {
            $request->validate([
                'route' => ['required', Rule::in(PageMeta::STATIC_ROUTES)],
            ]);

            $route = $request->input('route');

            if (PageMeta::where('route', $route)->exists()) {
                throw ValidationException::withMessages(['route' => 'This page already has an SEO record.']);
            }

            return ['route' => $route, 'seoable_type' => null, 'seoable_id' => null];
        }

        $request->validate([
            'blog_id' => ['required', 'integer', 'exists:blogs,id'],
        ]);

        $blogId = (int) $request->input('blog_id');

        if (PageMeta::where('seoable_type', Blog::class)->where('seoable_id', $blogId)->exists()) {
            throw ValidationException::withMessages(['blog_id' => 'This blog post already has an SEO record.']);
        }

        return ['route' => null, 'seoable_type' => Blog::class, 'seoable_id' => $blogId];
    }

    private function validated(Request $request, ?PageMeta $pageMeta = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'keywords' => ['nullable', 'string'],
            'focus_keyword' => ['nullable', 'string', 'max:100'],
            'secondary_keywords' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:2048'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'twitter_title' => ['nullable', 'string', 'max:255'],
            'twitter_description' => ['nullable', 'string', 'max:500'],
            'twitter_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'notes' => ['nullable', 'string'],
        ]);

        if (! empty($data['canonical_url']) && ! Redirect::isSafeDestination($data['canonical_url'])) {
            throw ValidationException::withMessages([
                'canonical_url' => 'Canonical URL must be an internal path starting with "/" or a valid http(s):// URL.',
            ]);
        }

        $data['robots_index'] = $request->boolean('robots_index', true);
        $data['robots_follow'] = $request->boolean('robots_follow', true);
        $data['is_active'] = $request->boolean('is_active', true);

        $data['keywords'] = $this->splitKeywords($data['keywords'] ?? null);
        $data['secondary_keywords'] = $this->splitKeywords($data['secondary_keywords'] ?? null);

        if ($request->hasFile('og_image_file')) {
            $data['og_image'] = Storage::url(Storage::disk('public')->putFile('seo', $request->file('og_image_file')));
        }
        unset($data['og_image_file']);

        if ($request->hasFile('twitter_image_file')) {
            $data['twitter_image'] = Storage::url(Storage::disk('public')->putFile('seo', $request->file('twitter_image_file')));
        }
        unset($data['twitter_image_file']);

        return $data;
    }

    private function splitKeywords(?string $raw): array
    {
        if (! $raw) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }
}
