@extends('admin.layouts.admin')

@section('title', 'Quote Requests')

@section('content')
    <div class="admin-card">
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Subject</th>
                        <th>Received</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($quotes as $quote)
                        <tr>
                            <td>{{ $quote->name }}</td>
                            <td>{{ $quote->email }}</td>
                            <td>{{ $quote->phone }}</td>
                            <td>{{ $quote->subject ?: '—' }}</td>
                            <td>{{ $quote->created_at->format('d M, Y H:i') }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.quotes.show', $quote) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">View</a>
                                <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this quote?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No quote requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $quotes->links() }}</div>
    </div>
@endsection
