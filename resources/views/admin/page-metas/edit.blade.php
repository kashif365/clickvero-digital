@extends('admin.layouts.admin')

@section('title', 'Edit Page SEO')

@section('content')
    <div class="admin-card">
        <div class="admin-form-group">
            <label>Page</label>
            <div class="admin-badge">
                @if ($pageMeta->seoable)
                    Blog Post: {{ $pageMeta->seoable->title }}
                @else
                    Static Page: /{{ $pageMeta->route === 'home' ? '' : $pageMeta->route }}
                @endif
            </div>
        </div>

        <form action="{{ route('admin.page-metas.update', $pageMeta) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.page-metas._fields')
        </form>
    </div>
@endsection
