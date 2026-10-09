@extends('admin.layouts.admin')

@section('title', 'URL Redirects')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.redirects.create') }}" class="admin-btn admin-btn-accent"><i class="fa-solid fa-plus"></i> New Redirect</a>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.redirects.index') }}" class="admin-filter-bar">
            <div class="admin-form-group">
                <label for="search">Search</label>
                <input type="text" id="search" name="search" class="admin-form-control" placeholder="Name, source, or destination" value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="admin-form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="admin-form-control">
                    <option value="">All types</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" @selected(($filters['type'] ?? '') == $type)>{{ $type }}</option>
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
            <a href="{{ route('admin.redirects.index') }}" class="admin-btn admin-btn-outline">Reset</a>
        </form>

        <form method="POST" action="{{ route('admin.redirects.bulk') }}" id="bulkForm">
            @csrf
            <div style="overflow-x:auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width:32px;"><input type="checkbox" id="selectAll"></th>
                            <th>Name</th>
                            <th>Source</th>
                            <th>Destination</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($redirects as $redirect)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $redirect->id }}" class="row-checkbox"></td>
                                <td>{{ $redirect->name ?: '—' }}</td>
                                <td><code>{{ $redirect->source_path }}</code></td>
                                <td style="max-width:280px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $redirect->destination }}">{{ $redirect->destination }}</td>
                                <td><span class="admin-badge">{{ $redirect->type }}</span></td>
                                <td>
                                    <span class="admin-badge {{ $redirect->is_active ? 'admin-badge-success' : 'admin-badge-danger' }}">
                                        {{ $redirect->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $redirect->creator?->name ?: '—' }}</td>
                                <td style="white-space:nowrap;">
                                    <a href="{{ route('admin.redirects.edit', $redirect) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Edit</a>
                                    <form action="{{ route('admin.redirects.toggle', $redirect) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="admin-btn admin-btn-outline" style="padding:6px 12px;">
                                            {{ $redirect->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.redirects.destroy', $redirect) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this redirect?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="admin-empty-state">
                                        No redirects yet. Create one to start redirecting old or moved URLs.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($redirects->isNotEmpty())
                <div class="d-flex align-items-center gap-2 mt-3">
                    <select name="action" class="admin-form-control" style="width:auto;">
                        <option value="activate">Activate selected</option>
                        <option value="deactivate">Deactivate selected</option>
                        <option value="delete">Delete selected</option>
                    </select>
                    <button type="submit" class="admin-btn admin-btn-outline" id="bulkApply">Apply</button>
                </div>
            @endif
        </form>

        <div class="mt-3">{{ $redirects->links() }}</div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('selectAll')?.addEventListener('change', (e) => {
            document.querySelectorAll('.row-checkbox').forEach((cb) => { cb.checked = e.target.checked; });
        });

        document.getElementById('bulkForm')?.addEventListener('submit', (e) => {
            const checked = document.querySelectorAll('.row-checkbox:checked');
            if (checked.length === 0) {
                e.preventDefault();
                alert('Select at least one redirect first.');
                return;
            }
            const action = document.querySelector('select[name="action"]').value;
            if (action === 'delete' && !confirm(`Delete ${checked.length} redirect(s)?`)) {
                e.preventDefault();
            }
        });
    </script>
@endpush
