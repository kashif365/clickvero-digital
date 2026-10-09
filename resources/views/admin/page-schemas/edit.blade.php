@extends('admin.layouts.admin')

@section('title', 'Edit Schema')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.page-schemas.update', $schema) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.page-schemas._form')
        </form>
    </div>
@endsection
