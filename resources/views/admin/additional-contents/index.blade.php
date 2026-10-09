@extends('admin.layouts.admin')

@section('title', 'Additional Content')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.additional-contents.create') }}" class="admin-btn admin-btn-accent"><i class="fa-solid fa-plus"></i> New Additional Content</a>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.additional-contents.index') }}" class="admin-filter-bar">
            <div class="admin-form-group">
                <label for="search">Search</label>
                <input type="text" id="search" name="search" class="admin-form-control" placeholder="Page URL or title" value="{{ $filters['search'] ?? '' }}">
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
            <a href="{{ route('admin.additional-contents.index') }}" class="admin-btn admin-btn-outline">Reset</a>
        </form>

        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Page URL</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contents as $item)
                        <tr>
                            <td><code>{{ $item->page_url }}</code></td>
                            <td>{{ $item->title ?: '—' }}</td>
                            <td>
                                <span class="admin-badge {{ $item->status ? 'admin-badge-success' : 'admin-badge-danger' }}">
                                    {{ $item->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('d M, Y') }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ url($item->page_url) }}" target="_blank" rel="noopener" class="admin-btn admin-btn-primary" style="padding:6px 12px;"><i class="fa-solid fa-arrow-up-right-from-square"></i> View</a>
                                <a href="{{ route('admin.additional-contents.edit', $item) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Edit</a>
                                <form action="{{ route('admin.additional-contents.destroy', $item) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this additional content?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="admin-empty-state">No additional content yet. Create one to add extra content to a specific page.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $contents->links() }}</div>
    </div>
@endsection
