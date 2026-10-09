@extends('admin.layouts.admin')

@section('title', 'Page Schemas')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.page-schemas.create') }}" class="admin-btn admin-btn-accent"><i class="fa-solid fa-plus"></i> New Schema</a>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.page-schemas.index') }}" class="admin-filter-bar">
            <div class="admin-form-group">
                <label for="search">Search</label>
                <input type="text" id="search" name="search" class="admin-form-control" value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="admin-form-group">
                <label for="schema_type">Type</label>
                <select id="schema_type" name="schema_type" class="admin-form-control">
                    <option value="">All types</option>
                    @foreach ($schemaTypes as $type)
                        <option value="{{ $type }}" @selected(($filters['schema_type'] ?? '') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="admin-form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="admin-form-control">
                    <option value="">All statuses</option>
                    <option value="active" @selected(($filters['status'] ?? '') === 'active')>Active</option>
                    <option value="inactive" @selected(($filters['status'] ?? '') === 'inactive')>Inactive</option>
                </select>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Filter</button>
            <a href="{{ route('admin.page-schemas.index') }}" class="admin-btn admin-btn-outline">Reset</a>
        </form>

        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Scope</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schemas as $schema)
                        <tr>
                            <td>{{ $schema->name }}</td>
                            <td><span class="admin-badge">{{ $schema->schema_type }}</span></td>
                            <td>
                                @if ($schema->scope === 'global')
                                    Entire site
                                @elseif ($schema->scope === 'route')
                                    Page: {{ $schema->route_name }}
                                @else
                                    Blog: {{ $schema->seoable?->title ?? '—' }}
                                @endif
                            </td>
                            <td>{{ $schema->priority }}</td>
                            <td>
                                <span class="admin-badge {{ $schema->is_active ? 'admin-badge-success' : 'admin-badge-danger' }}">
                                    {{ $schema->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.page-schemas.edit', $schema) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Edit</a>
                                <form action="{{ route('admin.page-schemas.toggle', $schema) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="admin-btn admin-btn-outline" style="padding:6px 12px;">
                                        {{ $schema->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.page-schemas.duplicate', $schema) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Duplicate</button>
                                </form>
                                <form action="{{ route('admin.page-schemas.destroy', $schema) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this schema?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="admin-empty-state">No schemas yet. Add structured data to help search engines understand your pages.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $schemas->links() }}</div>
    </div>
@endsection
