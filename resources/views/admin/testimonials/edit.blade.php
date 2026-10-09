@extends('admin.layouts.admin')

@section('title', 'Edit Testimonial')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.testimonials._form')
        </form>
    </div>
@endsection
