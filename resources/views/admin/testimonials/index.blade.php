@extends('admin.layouts.admin')

@section('title', 'Testimonials')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.testimonials.create') }}" class="admin-btn admin-btn-accent"><i class="fa-solid fa-plus"></i> New Testimonial</a>
    </div>

    <div class="admin-card">
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Quote</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($testimonials as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->role ?: '—' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->quote, 70) }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>{{ $item->is_active ? 'Active' : 'Hidden' }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.testimonials.edit', $item) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Edit</a>
                                <form action="{{ route('admin.testimonials.destroy', $item) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No testimonials yet. The testimonials section stays hidden on the website until you add one.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $testimonials->links() }}</div>
    </div>
@endsection
