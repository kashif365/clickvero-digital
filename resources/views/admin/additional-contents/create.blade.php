@extends('admin.layouts.admin')

@section('title', 'New Additional Content')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.additional-contents.store') }}" method="POST">
            @csrf
            @include('admin.additional-contents._form')
        </form>
    </div>
@endsection
