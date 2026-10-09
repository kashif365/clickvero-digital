<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\PageMeta;
use App\Models\PageSchema;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PageSchemaController extends Controller
{
    /**
     * Minimal set of properties expected for each schema.org type, checked at save
     * time so admins get immediate feedback instead of publishing an incomplete
     * structured-data block.
     */
    private const REQUIRED_PROPERTIES = [
        'Organization' => ['name'],
        'LocalBusiness' => ['name', 'address'],
        'WebSite' => ['name', 'url'],
        'WebPage' => ['name'],
        'Article' => ['headline'],
        'BlogPosting' => ['headline'],
        'BreadcrumbList' => ['itemListElement'],
        'FAQPage' => ['mainEntity'],
        'Product' => ['name'],
        'Service' => ['name'],
        'Person' => ['name'],
        'Review' => ['reviewRating', 'author'],
        'AggregateRating' => ['ratingValue', 'reviewCount'],
    ];

    public const ROUTE_OPTIONS = [
        'home', 'about', 'blog', 'blog-details', 'contact', 'faq', 'pricing',
        'project', 'project-details', 'service', 'service.show', 'team', 'team-details',
    ];

    public function index(Request $request)
    {
        $query = PageSchema::query();

        if ($search = trim((string) $request->input('search'))) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($type = $request->input('schema_type')) {
            $query->where('schema_type', $type);
        }

        if ($status = $request->input('status')) {
            $query->where('is_active', $status === 'active');
        }

        return view('admin.page-schemas.index', [
            'schemas' => $query->orderBy('priority')->orderByDesc('id')->paginate(15)->withQueryString(),
            'filters' => $request->only(['search', 'schema_type', 'status']),
            'schemaTypes' => PageSchema::SCHEMA_TYPES,
        ]);
    }

    public function create()
    {
        return view('admin.page-schemas.create', [
            'schemaTypes' => PageSchema::SCHEMA_TYPES,
            'routeOptions' => self::ROUTE_OPTIONS,
            'blogs' => Blog::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        PageSchema::create($data);

        return redirect()->route('admin.page-schemas.index')->with('success', 'Schema created.');
    }

    public function edit(PageSchema $pageSchema)
    {
        return view('admin.page-schemas.edit', [
            'schema' => $pageSchema,
            'schemaTypes' => PageSchema::SCHEMA_TYPES,
            'routeOptions' => self::ROUTE_OPTIONS,
            'blogs' => Blog::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function update(Request $request, PageSchema $pageSchema)
    {
        $data = $this->validated($request, $pageSchema);

        $pageSchema->update($data);

        return redirect()->route('admin.page-schemas.index')->with('success', 'Schema updated.');
    }

    public function destroy(PageSchema $pageSchema)
    {
        $pageSchema->delete();

        return redirect()->route('admin.page-schemas.index')->with('success', 'Schema deleted.');
    }

    public function toggle(PageSchema $pageSchema)
    {
        $pageSchema->update(['is_active' => ! $pageSchema->is_active]);

        return back()->with('success', 'Schema '.($pageSchema->is_active ? 'activated' : 'deactivated').'.');
    }

    public function duplicate(PageSchema $pageSchema)
    {
        $copy = $pageSchema->replicate();
        $copy->name = $pageSchema->name.' (copy)';
        $copy->is_active = false;
        $copy->save();

        return redirect()->route('admin.page-schemas.edit', $copy)->with('success', 'Schema duplicated. Review and activate it when ready.');
    }

    private function validated(Request $request, ?PageSchema $pageSchema = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'schema_type' => ['required', Rule::in(PageSchema::SCHEMA_TYPES)],
            'scope' => ['required', Rule::in(PageSchema::SCOPES)],
            'route_name' => ['nullable', 'string', Rule::in(self::ROUTE_OPTIONS)],
            'blog_id' => ['nullable', 'integer', 'exists:blogs,id'],
            'schema_json' => ['required', 'string'],
            'priority' => ['nullable', 'integer', 'min:0', 'max:1000'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($data['scope'] === 'route' && empty($data['route_name'])) {
            throw ValidationException::withMessages(['route_name' => 'Select a page for a route-scoped schema.']);
        }

        if ($data['scope'] === 'model' && empty($data['blog_id'])) {
            throw ValidationException::withMessages(['blog_id' => 'Select a blog post for a model-scoped schema.']);
        }

        if (str_contains($data['schema_json'], '<script')) {
            throw ValidationException::withMessages(['schema_json' => 'Schema JSON may not contain script tags.']);
        }

        $decoded = json_decode($data['schema_json'], true);

        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
            throw ValidationException::withMessages(['schema_json' => 'Schema JSON is not valid: '.json_last_error_msg()]);
        }

        $required = self::REQUIRED_PROPERTIES[$data['schema_type']] ?? [];
        $missing = array_filter($required, fn ($field) => ! array_key_exists($field, $decoded));

        if ($missing) {
            throw ValidationException::withMessages([
                'schema_json' => 'The "'.$data['schema_type'].'" schema is missing required propert'.(count($missing) === 1 ? 'y' : 'ies').': '.implode(', ', $missing).'.',
            ]);
        }

        $result = [
            'name' => $data['name'],
            'schema_type' => $data['schema_type'],
            'scope' => $data['scope'],
            'route_name' => $data['scope'] === 'route' ? $data['route_name'] : null,
            'seoable_type' => $data['scope'] === 'model' ? Blog::class : null,
            'seoable_id' => $data['scope'] === 'model' ? $data['blog_id'] : null,
            'schema_json' => $decoded,
            'priority' => $data['priority'] ?? 0,
            'notes' => $data['notes'] ?? null,
        ];

        $result['is_active'] = $request->boolean('is_active', true);

        return $result;
    }
}
