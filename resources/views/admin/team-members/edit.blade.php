@extends('admin.layouts.admin')

@section('title', 'Edit Team Member')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.team-members.update', $member) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.team-members._form')
        </form>
    </div>
@endsection
