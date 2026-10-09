@extends('admin.layouts.admin')

@section('title', 'Edit Service')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.services._form')
        </form>
    </div>
@endsection
