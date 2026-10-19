@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-3 mb-2">
        <div class="col-md-4">
            <div class="admin-stat">
                <div class="admin-stat-icon"><i class="fa-solid fa-comment-dots"></i></div>
                <div>
                    <div class="admin-stat-value">{{ $quotesCount }}</div>
                    <div class="admin-stat-label">Quote Requests</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-stat">
                <div class="admin-stat-icon"><i class="fa-solid fa-newspaper"></i></div>
                <div>
                    <div class="admin-stat-value">{{ $blogsCount }}</div>
                    <div class="admin-stat-label">Blog Posts</div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card mt-4">
        <h2>Latest Quote Requests</h2>
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Subject</th>
                        <th>Received</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestQuotes as $quote)
                        <tr>
                            <td>{{ $quote->name }}</td>
                            <td>{{ $quote->email }}</td>
                            <td style="white-space:nowrap;">{{ $quote->phone ?: '—' }}</td>
                            <td>{{ $quote->subject ?: '—' }}</td>
                            <td>{{ $quote->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No quote requests yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
