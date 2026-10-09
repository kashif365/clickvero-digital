<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class PublicBlogController extends Controller
{
    public function index()
    {
        return view('spa', [
            'blogs' => Blog::orderByDesc('published_at')->get(),
        ]);
    }

    public function show(Blog $blog)
    {
        return view('spa', ['blog' => $blog]);
    }
}
