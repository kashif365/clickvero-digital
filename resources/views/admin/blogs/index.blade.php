@extends('admin.layouts.admin')

@section('title', 'Blogs')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.blogs.create') }}" class="admin-btn admin-btn-accent"><i class="fa-solid fa-plus"></i> New Blog Post</a>
    </div>

    <div class="admin-card">
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Published</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blogs as $blog)
                        <tr>
                            <td><img src="{{ $blog->image ?: asset('assets/img/blog/blog-1-1.jpg') }}" alt="" style="width:56px;height:40px;object-fit:cover;border-radius:6px;"></td>
                            <td>{{ $blog->title }}</td>
                            <td><span class="admin-badge">{{ $blog->category ?: '—' }}</span></td>
                            <td>{{ $blog->author ?: '—' }}</td>
                            <td>{{ $blog->published_at->format('d M, Y') }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="admin-btn admin-btn-outline" style="padding:6px 12px;">Edit</a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                </form>
                                <a href="{{ route('blog-details', $blog) }}" target="_blank" rel="noopener" class="admin-btn admin-btn-primary" style="padding:6px 12px;"><i class="fa-solid fa-arrow-up-right-from-square"></i> View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No blog posts yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $blogs->links() }}</div>
    </div>
@endsection
