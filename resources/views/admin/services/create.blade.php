@extends('admin.layouts.admin')

@section('title', 'New Service')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.services._form')
        </form>
    </div>
@endsection
