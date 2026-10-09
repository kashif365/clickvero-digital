@extends('admin.layouts.admin')

@section('title', 'Edit Redirect')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.redirects.update', $redirect) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.redirects._form')
        </form>
    </div>
@endsection
