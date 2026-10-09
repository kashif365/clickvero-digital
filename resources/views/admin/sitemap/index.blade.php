@extends('admin.layouts.admin')

@section('title', 'Sitemap')

@section('content')
    <div class="admin-card" style="max-width:640px;">
        @if ($exists)
            <div class="admin-form-group">
                <label>Current file</label>
                <div>sitemap.xml — {{ number_format($size / 1024, 1) }} KB, updated {{ \Carbon\Carbon::createFromTimestamp($updatedAt)->diffForHumans() }}</div>
            </div>
            <a href="{{ route('admin.sitemap.download') }}" class="admin-btn admin-btn-outline"><i class="fa-solid fa-download"></i> Download</a>
            <form action="{{ route('admin.sitemap.destroy') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete the current sitemap?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn-danger"><i class="fa-solid fa-trash"></i> Delete</button>
            </form>
        @else
            <p>No sitemap yet. Generate one automatically from your active, indexable pages and blog posts, or upload a file manually.</p>
        @endif

        <hr class="my-4">

        <form action="{{ route('admin.sitemap.generate') }}" method="POST">
            @csrf
            <button type="submit" class="admin-btn admin-btn-primary"><i class="fa-solid fa-rotate"></i> Generate Sitemap From Current Pages</button>
        </form>
        <p class="text-muted mt-2" style="font-size:13px;">
            Includes all active, indexable static pages and blog posts. Pages marked "noindex" or "inactive" in Page SEO are excluded automatically.
            The sitemap also regenerates automatically whenever a blog post or page SEO record is saved or deleted.
        </p>

        <hr class="my-4">

        <form action="{{ route('admin.sitemap.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="admin-form-group">
                <label for="sitemap">Or upload a sitemap.xml manually {{ $exists ? '(replaces the current file)' : '' }}</label>
                <input type="file" id="sitemap" name="sitemap" class="admin-form-control" accept=".xml" required>
            </div>
            <button type="submit" class="admin-btn admin-btn-outline">Upload</button>
        </form>
    </div>
@endsection
