@extends('admin.layouts.admin')

@section('title', 'New Team Member')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.team-members._form')
        </form>
    </div>
@endsection
