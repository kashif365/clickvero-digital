<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="admin-form-control" value="{{ old('name', $member->name ?? '') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="role">Role</label>
            <input type="text" id="role" name="role" class="admin-form-control" value="{{ old('role', $member->role ?? '') }}" placeholder="e.g. SEO Lead" required>
        </div>
    </div>
</div>

<div class="admin-form-group">
    <label for="bio">Short bio (optional)</label>
    <textarea id="bio" name="bio" class="admin-form-control" rows="3" maxlength="1000">{{ old('bio', $member->bio ?? '') }}</textarea>
</div>

<div class="admin-form-group">
    <label for="photo">Photo</label>
    @if (! empty($member->photo))
        <div style="margin-bottom:10px;"><img src="{{ $member->photo }}" alt="" style="width:96px; height:96px; object-fit:cover; border-radius:10px;"></div>
    @endif
    <input type="file" id="photo" name="photo" class="admin-form-control" accept="image/jpeg,image/png,image/webp">
    <small class="text-muted">JPG, PNG, or WebP up to 4 MB. A portrait crop (4:5) works best.</small>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="sort_order">Display order</label>
            <input type="number" id="sort_order" name="sort_order" class="admin-form-control" min="0" value="{{ old('sort_order', $member->sort_order ?? 0) }}">
            <small class="text-muted">Lower numbers appear first.</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="is_active">Status</label>
            <select id="is_active" name="is_active" class="admin-form-control">
                <option value="1" @selected(old('is_active', $member->is_active ?? true) == 1)>Active (shown on the website)</option>
                <option value="0" @selected(old('is_active', $member->is_active ?? true) == 0)>Hidden</option>
            </select>
        </div>
    </div>
</div>

<button type="submit" class="admin-btn admin-btn-primary">Save</button>
<a href="{{ route('admin.team-members.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
