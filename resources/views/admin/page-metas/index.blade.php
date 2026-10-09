@extends('admin.layouts.admin')

@section('title', 'Page SEO')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.page-metas.create') }}" class="admin-btn admin-btn-accent"><i class="fa-solid fa-plus"></i> New Page SEO Record</a>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.page-metas.index') }}" class="admin-filter-bar">
            <div class="admin-form-group">
                <label for="search">Search</label>
                <input type="text" id="search" name="search" class="admin-form-control" placeholder="Title or route" value="{{ $filters['search'] ?? '' }}">
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Filter</button>
            <a href="{{ route('admin.page-metas.index') }}" class="admin-btn admin-btn-outline">Reset</a>
        </form>

        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Robots</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pageMetas as $pageMeta)
                        <tr>
                            <td>
                                @if ($pageMeta->seoable)
                                    <span class="admin-badge">Blog: {{ \Illuminate\Support\Str::limit($pageMeta->seoable->title, 30) }}</span>
                                @else
                                    <span class="admin-badge">/{{ $pageMeta->route === 'home' ? '' : $pageMeta->route }}</span>
                                @endif
                            </td>
                            <td>{{ $pageMeta->title }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($pageMeta->description, 60) ?: '—' }}</td>
                            <td>{{ $pageMeta->robotsContent() }}</td>
                            <td>
                                <span class="admin-badge {{ $pageMeta->is_active ? 'admin-badge-success' : 'admin-badge-danger' }}">
                                    {{ $pageMeta->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.page-metas.edit', $pageMeta) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Edit</a>
                                @if ($pageMeta->route && \Illuminate\Support\Facades\Route::has($pageMeta->route))
                                    <a href="{{ route($pageMeta->route) }}" target="_blank" rel="noopener" class="admin-btn admin-btn-primary" style="padding:6px 12px;"><i class="fa-solid fa-arrow-up-right-from-square"></i> View</a>
                                @elseif ($pageMeta->seoable)
                                    <a href="{{ route('blog-details', $pageMeta->seoable) }}" target="_blank" rel="noopener" class="admin-btn admin-btn-primary" style="padding:6px 12px;"><i class="fa-solid fa-arrow-up-right-from-square"></i> View</a>
                                @endif
                                <form action="{{ route('admin.page-metas.destroy', $pageMeta) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this SEO record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="admin-empty-state">No page SEO records yet.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $pageMetas->links() }}</div>
    </div>
@endsection
