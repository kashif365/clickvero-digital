@extends('admin.layouts.admin')

@section('title', 'Team')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.team-members.create') }}" class="admin-btn admin-btn-accent"><i class="fa-solid fa-plus"></i> New Team Member</a>
    </div>

    <div class="admin-card">
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Photo</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->role ?: '—' }}</td>
                            <td>@if ($item->photo)<img src="{{ $item->photo }}" alt="" style="width:44px; height:44px; object-fit:cover; border-radius:8px;">@else — @endif</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>{{ $item->is_active ? 'Active' : 'Hidden' }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.team-members.edit', $item) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Edit</a>
                                <form action="{{ route('admin.team-members.destroy', $item) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No team members yet. The team grid stays hidden on the website until you add one.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $members->links() }}</div>
    </div>
@endsection
