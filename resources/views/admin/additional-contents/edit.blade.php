@extends('admin.layouts.admin')

@section('title', 'Edit Additional Content')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.additional-contents.update', $content) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.additional-contents._form')
        </form>
    </div>
@endsection
