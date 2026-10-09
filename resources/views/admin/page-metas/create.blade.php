@extends('admin.layouts.admin')

@section('title', 'New Page SEO Record')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.page-metas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="admin-form-group">
                <label for="target_type">Page Type</label>
                <select id="target_type" name="target_type" class="admin-form-control" onchange="toggleTargetFields()">
                    <option value="route" @selected(old('target_type', 'route') === 'route')>Static Page</option>
                    <option value="blog" @selected(old('target_type') === 'blog')>Blog Post</option>
                </select>
            </div>

            <div class="admin-form-group" id="routeField">
                <label for="route">Select Page</label>
                <select id="route" name="route" class="admin-form-control">
                    @forelse ($availableRoutes as $routeName)
                        <option value="{{ $routeName }}" @selected(old('route') === $routeName)>{{ $routeName }}</option>
                    @empty
                        <option value="" disabled>All static pages already have an SEO record</option>
                    @endforelse
                </select>
            </div>

            <div class="admin-form-group" id="blogField" style="display:none;">
                <label for="blog_id">Select Blog Post</label>
                <select id="blog_id" name="blog_id" class="admin-form-control">
                    @forelse ($availableBlogs as $blog)
                        <option value="{{ $blog->id }}" @selected(old('blog_id') == $blog->id)>{{ $blog->title }}</option>
                    @empty
                        <option value="" disabled>All blog posts already have an SEO record</option>
                    @endforelse
                </select>
            </div>

            @include('admin.page-metas._fields')
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleTargetFields() {
            const type = document.getElementById('target_type').value;
            document.getElementById('routeField').style.display = type === 'route' ? '' : 'none';
            document.getElementById('blogField').style.display = type === 'blog' ? '' : 'none';
        }
        document.addEventListener('DOMContentLoaded', toggleTargetFields);
    </script>
@endpush
