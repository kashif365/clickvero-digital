@extends('admin.layouts.admin')

@section('title', 'New Testimonial')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.testimonials.store') }}" method="POST">
            @csrf
            @include('admin.testimonials._form')
        </form>
    </div>
@endsection
