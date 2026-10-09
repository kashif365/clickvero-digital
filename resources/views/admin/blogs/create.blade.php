@extends('admin.layouts.admin')

@section('title', 'New Blog Post')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.blogs._form')
        </form>
    </div>
@endsection
