@php
    $pageMeta = $pageMeta ?? null;
    $keywordsValue = old('keywords', $pageMeta ? implode(', ', $pageMeta->keywords ?? []) : '');
    $secondaryValue = old('secondary_keywords', $pageMeta ? implode(', ', $pageMeta->secondary_keywords ?? []) : '');
@endphp

<div class="admin-form-group">
    <label for="title">SEO Title</label>
    <input type="text" id="title" name="title" class="admin-form-control" maxlength="255"
           value="{{ old('title', $pageMeta->title ?? '') }}" required oninput="updateSeoPreview()">
    <div class="admin-char-counter"><span id="titleCount">0</span>/60 recommended</div>
</div>

<div class="admin-form-group">
    <label for="description">Meta Description</label>
    <textarea id="description" name="description" class="admin-form-control" rows="3" maxlength="500"
              oninput="updateSeoPreview()">{{ old('description', $pageMeta->description ?? '') }}</textarea>
    <div class="admin-char-counter"><span id="descCount">0</span>/160 recommended</div>
</div>

<div class="admin-seo-preview mb-3">
    <div class="seo-preview-title" id="previewTitle">SEO title preview</div>
    <div class="seo-preview-url" id="previewUrl">{{ url('/') }}</div>
    <div class="seo-preview-description" id="previewDescription">Meta description preview will appear here.</div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="admin-form-group">
            <label for="focus_keyword">Focus Keyword</label>
            <input type="text" id="focus_keyword" name="focus_keyword" class="admin-form-control" maxlength="100"
                   value="{{ old('focus_keyword', $pageMeta->focus_keyword ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-form-group">
            <label for="keywords">Meta Keywords</label>
            <input type="text" id="keywords" name="keywords" class="admin-form-control" value="{{ $keywordsValue }}" placeholder="comma, separated, keywords">
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-form-group">
            <label for="secondary_keywords">Secondary Keywords</label>
            <input type="text" id="secondary_keywords" name="secondary_keywords" class="admin-form-control" value="{{ $secondaryValue }}" placeholder="comma, separated, keywords">
        </div>
    </div>
</div>

<div class="admin-form-group">
    <label for="canonical_url">Canonical URL (optional)</label>
    <input type="text" id="canonical_url" name="canonical_url" class="admin-form-control"
           value="{{ old('canonical_url', $pageMeta->canonical_url ?? '') }}" placeholder="/page or https://example.com/page">
    <small class="text-muted">Leave empty to use the page's own URL automatically.</small>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="admin-form-group">
            <label for="robots_index">Search Indexing</label>
            <select id="robots_index" name="robots_index" class="admin-form-control">
                <option value="1" @selected(old('robots_index', $pageMeta->robots_index ?? true) == 1)>Index</option>
                <option value="0" @selected(old('robots_index', $pageMeta->robots_index ?? true) == 0)>Noindex</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-form-group">
            <label for="robots_follow">Link Following</label>
            <select id="robots_follow" name="robots_follow" class="admin-form-control">
                <option value="1" @selected(old('robots_follow', $pageMeta->robots_follow ?? true) == 1)>Follow</option>
                <option value="0" @selected(old('robots_follow', $pageMeta->robots_follow ?? true) == 0)>Nofollow</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-form-group">
            <label for="is_active">Status</label>
            <select id="is_active" name="is_active" class="admin-form-control">
                <option value="1" @selected(old('is_active', $pageMeta->is_active ?? true) == 1)>Active</option>
                <option value="0" @selected(old('is_active', $pageMeta->is_active ?? true) == 0)>Inactive</option>
            </select>
        </div>
    </div>
</div>

<hr>
<h5>Open Graph (Facebook, LinkedIn, etc.)</h5>
<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="og_title">OG Title</label>
            <input type="text" id="og_title" name="og_title" class="admin-form-control" maxlength="255"
                   value="{{ old('og_title', $pageMeta->og_title ?? '') }}" placeholder="Falls back to SEO title">
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="og_image_file">OG Image {{ isset($pageMeta) && $pageMeta->og_image ? '(leave empty to keep current)' : '' }}</label>
            <input type="file" id="og_image_file" name="og_image_file" class="admin-form-control" accept="image/*">
            @if (isset($pageMeta) && $pageMeta->og_image)
                <img src="{{ $pageMeta->og_image }}" alt="Current OG image" style="max-width:160px; margin-top:8px; border-radius:6px;">
            @endif
        </div>
    </div>
</div>
<div class="admin-form-group">
    <label for="og_description">OG Description</label>
    <textarea id="og_description" name="og_description" class="admin-form-control" rows="2" maxlength="500" placeholder="Falls back to meta description">{{ old('og_description', $pageMeta->og_description ?? '') }}</textarea>
</div>

<hr>
<h5>Twitter / X Card</h5>
<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="twitter_title">Twitter Title</label>
            <input type="text" id="twitter_title" name="twitter_title" class="admin-form-control" maxlength="255"
                   value="{{ old('twitter_title', $pageMeta->twitter_title ?? '') }}" placeholder="Falls back to OG title">
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="twitter_image_file">Twitter Image {{ isset($pageMeta) && $pageMeta->twitter_image ? '(leave empty to keep current)' : '' }}</label>
            <input type="file" id="twitter_image_file" name="twitter_image_file" class="admin-form-control" accept="image/*">
            @if (isset($pageMeta) && $pageMeta->twitter_image)
                <img src="{{ $pageMeta->twitter_image }}" alt="Current Twitter image" style="max-width:160px; margin-top:8px; border-radius:6px;">
            @endif
        </div>
    </div>
</div>
<div class="admin-form-group">
    <label for="twitter_description">Twitter Description</label>
    <textarea id="twitter_description" name="twitter_description" class="admin-form-control" rows="2" maxlength="500" placeholder="Falls back to OG description">{{ old('twitter_description', $pageMeta->twitter_description ?? '') }}</textarea>
</div>

<div class="admin-form-group">
    <label for="notes">Internal Notes (optional)</label>
    <textarea id="notes" name="notes" class="admin-form-control" rows="2">{{ old('notes', $pageMeta->notes ?? '') }}</textarea>
</div>

<button type="submit" class="admin-btn admin-btn-primary">Save Page SEO</button>
<a href="{{ route('admin.page-metas.index') }}" class="admin-btn admin-btn-outline">Cancel</a>

@push('scripts')
    <script>
        function updateSeoPreview() {
            const title = document.getElementById('title').value || 'SEO title preview';
            const desc = document.getElementById('description').value || 'Meta description preview will appear here.';
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewDescription').textContent = desc;
            document.getElementById('titleCount').textContent = document.getElementById('title').value.length;
            document.getElementById('descCount').textContent = document.getElementById('description').value.length;
        }
        document.addEventListener('DOMContentLoaded', updateSeoPreview);
    </script>
@endpush
