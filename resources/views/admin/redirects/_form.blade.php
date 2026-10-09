<div class="admin-form-group">
    <label for="name">Label (internal name)</label>
    <input type="text" id="name" name="name" class="admin-form-control" value="{{ old('name', $redirect->name ?? '') }}" placeholder="e.g. Old pricing page">
</div>

<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="source_path">Source path</label>
            <input type="text" id="source_path" name="source_path" class="admin-form-control" value="{{ old('source_path', $redirect->source_path ?? '') }}" placeholder="/old-page" required>
            <small class="text-muted">Internal path only, e.g. <code>/old-page</code>. Leading slash is added automatically; a trailing slash is stripped.</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination" class="admin-form-control" value="{{ old('destination', $redirect->destination ?? '') }}" placeholder="/new-page or https://example.com" required>
            <small class="text-muted">An internal path (<code>/new-page</code>) or a full <code>https://</code> URL. The visitor's query string is preserved automatically.</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="type">Redirect type</label>
            <select id="type" name="type" class="admin-form-control">
                @foreach ($types as $type)
                    <option value="{{ $type }}" @selected(old('type', $redirect->type ?? 301) == $type)>
                        {{ $type }} — {{ match ($type) { 301 => 'Permanent', 302 => 'Temporary (found)', 307 => 'Temporary (strict method)', 308 => 'Permanent (strict method)', default => '' } }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="is_active">Status</label>
            <select id="is_active" name="is_active" class="admin-form-control">
                <option value="1" @selected(old('is_active', $redirect->is_active ?? true) == 1)>Active</option>
                <option value="0" @selected(old('is_active', $redirect->is_active ?? true) == 0)>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="admin-form-group">
    <label for="notes">Notes (optional)</label>
    <textarea id="notes" name="notes" class="admin-form-control" rows="2">{{ old('notes', $redirect->notes ?? '') }}</textarea>
</div>

<button type="submit" class="admin-btn admin-btn-primary">Save Redirect</button>
<a href="{{ route('admin.redirects.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
