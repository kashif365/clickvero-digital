@extends('admin.layouts.admin')

@section('title', 'New Redirect')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.redirects.store') }}" method="POST">
            @csrf
            @include('admin.redirects._form')
        </form>
    </div>
@endsection
