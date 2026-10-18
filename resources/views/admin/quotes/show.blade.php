@extends('admin.layouts.admin')

@section('title', 'Quote Request')

@section('content')
    <div class="admin-card" style="max-width:640px;">
        <div class="admin-form-group">
            <label>Name</label>
            <div>{{ $quote->name }}</div>
        </div>
        <div class="admin-form-group">
            <label>Email</label>
            <div>{{ $quote->email }}</div>
        </div>
        <div class="admin-form-group">
            <label>Phone No</label>
            <div>{{ $quote->phone }}</div>
        </div>
        <div class="admin-form-group">
            <label>Subject</label>
            <div>{{ $quote->subject ?: '—' }}</div>
        </div>
        <div class="admin-form-group">
            <label>Message</label>
            <div style="white-space:pre-wrap;">{{ $quote->message }}</div>
        </div>
        <div class="admin-form-group">
            <label>Received</label>
            <div>{{ $quote->created_at->format('d M, Y H:i') }}</div>
        </div>
        <a href="{{ route('admin.quotes.index') }}" class="admin-btn admin-btn-outline">Back</a>
    </div>
@endsection
