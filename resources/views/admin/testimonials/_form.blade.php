<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="name">Client name</label>
            <input type="text" id="name" name="name" class="admin-form-control" value="{{ old('name', $testimonial->name ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="role">Role &amp; company (optional)</label>
            <input type="text" id="role" name="role" class="admin-form-control" value="{{ old('role', $testimonial->role ?? '') }}" placeholder="e.g. Founder, Acme Retail">
        </div>
    </div>
</div>

<div class="admin-form-group">
    <label for="quote">Quote</label>
    <textarea id="quote" name="quote" class="admin-form-control" rows="4" maxlength="1000" required>{{ old('quote', $testimonial->quote ?? '') }}</textarea>
    <small class="text-muted">Only publish feedback a real client has given and agreed to share.</small>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="sort_order">Display order</label>
            <input type="number" id="sort_order" name="sort_order" class="admin-form-control" min="0" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
            <small class="text-muted">Lower numbers appear first.</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="is_active">Status</label>
            <select id="is_active" name="is_active" class="admin-form-control">
                <option value="1" @selected(old('is_active', $testimonial->is_active ?? true) == 1)>Active (shown on the website)</option>
                <option value="0" @selected(old('is_active', $testimonial->is_active ?? true) == 0)>Hidden</option>
            </select>
        </div>
    </div>
</div>

<button type="submit" class="admin-btn admin-btn-primary">Save</button>
<a href="{{ route('admin.testimonials.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
