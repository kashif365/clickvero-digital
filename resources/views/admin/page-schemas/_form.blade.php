@php $schema = $schema ?? null; @endphp

<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="name">Internal Name</label>
            <input type="text" id="name" name="name" class="admin-form-control" maxlength="255"
                   value="{{ old('name', $schema->name ?? '') }}" placeholder="e.g. Homepage Organization schema" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="schema_type">Schema Type</label>
            <select id="schema_type" name="schema_type" class="admin-form-control" onchange="applyTemplate()">
                @foreach ($schemaTypes as $type)
                    <option value="{{ $type }}" @selected(old('schema_type', $schema->schema_type ?? '') === $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="admin-form-group">
            <label for="scope">Applies To</label>
            <select id="scope" name="scope" class="admin-form-control" onchange="toggleScopeFields()">
                <option value="global" @selected(old('scope', $schema->scope ?? 'route') === 'global')>Entire Site (global)</option>
                <option value="route" @selected(old('scope', $schema->scope ?? 'route') === 'route')>Specific Page</option>
                <option value="model" @selected(old('scope', $schema->scope ?? 'route') === 'model')>Specific Blog Post</option>
            </select>
        </div>
    </div>
    <div class="col-md-4" id="routeScopeField">
        <div class="admin-form-group">
            <label for="route_name">Page</label>
            <select id="route_name" name="route_name" class="admin-form-control">
                @foreach ($routeOptions as $routeName)
                    <option value="{{ $routeName }}" @selected(old('route_name', $schema->route_name ?? '') === $routeName)>{{ $routeName }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4" id="modelScopeField" style="display:none;">
        <div class="admin-form-group">
            <label for="blog_id">Blog Post</label>
            <select id="blog_id" name="blog_id" class="admin-form-control">
                @foreach ($blogs as $blog)
                    <option value="{{ $blog->id }}" @selected(old('blog_id', $schema->seoable_id ?? '') == $blog->id)>{{ $blog->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4" id="priorityField">
        <div class="admin-form-group">
            <label for="priority">Display Priority</label>
            <input type="number" id="priority" name="priority" class="admin-form-control" min="0" max="1000"
                   value="{{ old('priority', $schema->priority ?? 0) }}">
            <small class="text-muted">Lower numbers render first.</small>
        </div>
    </div>
</div>

<div class="admin-form-group">
    <label for="schema_json">Schema JSON</label>
    <textarea id="schema_json" name="schema_json" class="admin-form-control" rows="12" style="font-family:monospace;" oninput="validateJson()">{{ old('schema_json', isset($schema) ? json_encode($schema->schema_json, JSON_PRETTY_PRINT) : '') }}</textarea>
    <small class="text-muted">"@@context" and "@type" are added automatically if omitted. No script tags allowed.</small>
    <div id="jsonFeedback" class="admin-char-counter" style="text-align:left;"></div>
</div>

<div class="admin-form-group">
    <label for="is_active">Status</label>
    <select id="is_active" name="is_active" class="admin-form-control">
        <option value="1" @selected(old('is_active', $schema->is_active ?? true) == 1)>Active</option>
        <option value="0" @selected(old('is_active', $schema->is_active ?? true) == 0)>Inactive</option>
    </select>
</div>

<div class="admin-form-group">
    <label for="notes">Notes (optional)</label>
    <textarea id="notes" name="notes" class="admin-form-control" rows="2">{{ old('notes', $schema->notes ?? '') }}</textarea>
</div>

<button type="submit" class="admin-btn admin-btn-primary">Save Schema</button>
<a href="{{ route('admin.page-schemas.index') }}" class="admin-btn admin-btn-outline">Cancel</a>

@push('scripts')
    <script>
        const schemaTemplates = {
            Organization: { name: 'Your Company Name', url: '{{ url("/") }}', logo: '{{ url("/assets/img/logo/logo-3rd.png") }}' },
            LocalBusiness: { name: 'Your Business Name', address: { '@type': 'PostalAddress', streetAddress: '', addressLocality: '', addressCountry: '' } },
            WebSite: { name: '{{ config("app.name") }}', url: '{{ url("/") }}' },
            WebPage: { name: 'Page Name', url: '{{ url("/") }}' },
            Article: { headline: 'Article headline', author: { '@type': 'Person', name: 'Author name' }, datePublished: '' },
            BlogPosting: { headline: 'Post headline', author: { '@type': 'Person', name: 'Author name' }, datePublished: '', image: '' },
            BreadcrumbList: { itemListElement: [{ '@type': 'ListItem', position: 1, name: 'Home', item: '{{ url("/") }}' }] },
            FAQPage: { mainEntity: [{ '@type': 'Question', name: 'Question text', acceptedAnswer: { '@type': 'Answer', text: 'Answer text' } }] },
            Product: { name: 'Product name', description: '' },
            Service: { name: 'Service name', description: '' },
            Person: { name: 'Person name' },
            Review: { reviewRating: { '@type': 'Rating', ratingValue: '5' }, author: { '@type': 'Person', name: 'Reviewer name' } },
            AggregateRating: { ratingValue: '4.8', reviewCount: '10' },
            Custom: {},
        };

        function applyTemplate() {
            const textarea = document.getElementById('schema_json');
            if (textarea.value.trim() !== '') {
                return;
            }
            const type = document.getElementById('schema_type').value;
            textarea.value = JSON.stringify(schemaTemplates[type] ?? {}, null, 2);
            validateJson();
        }

        function toggleScopeFields() {
            const scope = document.getElementById('scope').value;
            document.getElementById('routeScopeField').style.display = scope === 'route' ? '' : 'none';
            document.getElementById('modelScopeField').style.display = scope === 'model' ? '' : 'none';
        }

        function validateJson() {
            const feedback = document.getElementById('jsonFeedback');
            const value = document.getElementById('schema_json').value.trim();
            if (value === '') {
                feedback.textContent = '';
                return;
            }
            try {
                JSON.parse(value);
                feedback.textContent = 'Valid JSON';
                feedback.style.color = '#065f46';
            } catch (e) {
                feedback.textContent = 'Invalid JSON: ' + e.message;
                feedback.style.color = '#991b1b';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleScopeFields();
            validateJson();
        });
    </script>
@endpush
