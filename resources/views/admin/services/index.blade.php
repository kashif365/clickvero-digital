@extends('admin.layouts.admin')

@section('title', 'Services')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.services.create') }}" class="admin-btn admin-btn-accent"><i class="fa-solid fa-plus"></i> New Service</a>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.services.index') }}" class="admin-filter-bar">
            <div class="admin-form-group">
                <label for="search">Search</label>
                <input type="text" id="search" name="search" class="admin-form-control" placeholder="Name or slug" value="{{ $filters['search'] ?? '' }}">
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
            <a href="{{ route('admin.services.index') }}" class="admin-btn admin-btn-outline">Reset</a>
        </form>

        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td><code>/services/{{ $service->slug }}</code></td>
                            <td>
                                <span class="admin-badge {{ $service->status ? 'admin-badge-success' : 'admin-badge-danger' }}">
                                    {{ $service->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $service->created_at->format('d M, Y') }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('service.show', $service) }}" target="_blank" rel="noopener" class="admin-btn admin-btn-primary" style="padding:6px 12px;"><i class="fa-solid fa-arrow-up-right-from-square"></i> View</a>
                                <a href="{{ route('admin.services.edit', $service) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Edit</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="admin-empty-state">No services yet. Add your first service to give it its own dedicated page.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $services->links() }}</div>
    </div>
@endsection
