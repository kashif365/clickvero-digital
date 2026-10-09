@extends('admin.layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.blogs._form')
        </form>
    </div>
@endsection
