@extends('admin.layouts.admin')

@section('title', 'New Schema')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.page-schemas.store') }}" method="POST">
            @csrf
            @include('admin.page-schemas._form')
        </form>
    </div>
@endsection
